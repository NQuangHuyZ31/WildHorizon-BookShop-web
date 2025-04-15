<?php
namespace App\Controllers\Admin;
use App\Controllers\Controller;
use Core\Session;
use Core\Encrypt;
class CatalogController extends Controller
{
    public function getAllCatalogs()
    {
        // Lấy trang hiện tại từ URL, mặc định là 1
        $currentPage = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;

        // Số brand mỗi trang
        $perPage = 5;

        // Tính toán offset
        $offset = ($currentPage - 1) * $perPage;

        // Lấy từ khóa tìm kiếm (nếu có)
        $search = isset($_GET['search']) ? trim($_GET['search']) : '';

        //Truy vấn để lấy tổng số danh mục
        $countQuery = "SELECT COUNT(*) AS total FROM catalogs WHERE catalog_name LIKE :search";
        $stmt = $this->db->prepare($countQuery);
        $searchParam = '%' . $search . '%';
        $stmt->bindParam(':search', $searchParam, \PDO::PARAM_STR);
        $stmt->execute();
        $totalCatalogs = $stmt->fetch(\PDO::FETCH_ASSOC)['total'];

        //Tính tổng số trang
        $totalPages = ceil($totalCatalogs / $perPage);

        // Truy vấn sử dụng phân trang
        $stmt = $this->db->prepare("SELECT * FROM catalogs WHERE catalog_name LIKE :search ORDER BY catalog_name ASC LIMIT :offset, :perPage");
        $searchParam = '%' . $search . '%';
        $stmt->bindParam(':search', $searchParam, \PDO::PARAM_STR);
        $stmt->bindParam(':offset', $offset, \PDO::PARAM_INT);
        $stmt->bindParam(':perPage', $perPage, \PDO::PARAM_INT);
        $stmt->execute();
        $catalogs = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        // Hiển thị giao diện danh mục
        include_once VIEW_PATH . 'admin/catalogs/index.php';
    }


    public function createCatalog()
    {
        // Khởi tạo mảng lỗi
        $errors = [];

        // Kiểm tra nếu là phương thức POST
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Lấy dữ liệu từ form
            $catalog_name = $_POST['catalog_name'] ?? '';
            $description = $_POST['description'] ?? '';
            $catalog_image = $_FILES['catalog_image'] ?? null;

            // Kiểm tra lỗi trên các trường
            $errors = $this->validateCatalogData($catalog_name, $description, $catalog_image);

            // Nếu không có lỗi, lưu danh mục
            if (empty($errors)) {
                // Truyền đúng tham số vào saveCatalog
                $this->saveCatalog($catalog_name, $description, $catalog_image);
                return; // Dừng lại sau khi lưu xong và chuyển hướng
            }
        }

        // Nếu có lỗi, truyền lỗi vào view
        include_once VIEW_PATH . 'admin/catalogs/create.php';
    }


    private function validateCatalogData($catalog_name, $description, $catalog_image, $currentImage = null)
    {
        $errors = [];

        // Kiểm tra tên danh mục
        if (empty($catalog_name)) {
            $errors['catalog_name'] = 'Tên danh mục không được để trống.';
        }

        // Kiểm tra mô tả
        if (empty($description)) {
            $errors['description'] = 'Mô tả không được để trống.';
        }
        // Kiểm tra hình ảnh
        if ($catalog_image && $catalog_image['error'] === UPLOAD_ERR_NO_FILE) {
            // Nếu không tải ảnh lên mới, thì không báo lỗi
            if (empty($currentImage)) {
                $errors['catalog_image'] = 'Vui lòng tải lên hình ảnh.';
            }
        } elseif ($catalog_image && $catalog_image['error'] === UPLOAD_ERR_OK) {
            // Kiểm tra phần mở rộng của tệp
            $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];
            $fileExtension = strtolower(pathinfo($catalog_image['name'], PATHINFO_EXTENSION));
            if (!in_array($fileExtension, $allowedExtensions)) {
                $errors['catalog_image'] = 'Phần mở rộng tệp không hợp lệ. Chỉ hỗ trợ JPG, PNG, GIF.';
            }

            // Kiểm tra tên ảnh trong cơ sở dữ liệu nếu có ảnh mới
            $imageName = basename($catalog_image['name']);
            if ($this->checkImageExists($imageName, $currentImage)) {
                $errors['catalog_image'] = 'Tên ảnh đã tồn tại. Vui lòng chọn tên khác.';
            }
        }
        return $errors;
    }

    private function checkImageExists($imageName, $currentImage)
    {
        // Nếu ảnh cũ không đổi, không cần kiểm tra
        if ($imageName === $currentImage) {
            return false;
        }

        // Kiểm tra trong cơ sở dữ liệu nếu tên ảnh đã tồn tại
        $query = "SELECT COUNT(*) FROM catalogs WHERE catalog_image = :imageName";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':imageName', $imageName, \PDO::PARAM_STR);
        $stmt->execute();

        // Lấy kết quả
        $count = $stmt->fetchColumn();

        // Kiểm tra nếu có ít nhất một danh mục có tên ảnh này
        return $count > 0;
    }
    public function saveCatalog($catalog_name, $description, $catalog_image)
    {
        $imagePath = null;
        if ($catalog_image && $catalog_image['error'] === UPLOAD_ERR_OK) {
            $uploadDir = UPLOAD_DIR . 'catalogs/';
            $imageName = basename($catalog_image['name']);
            $imagePath = $uploadDir . $imageName;
            if (!move_uploaded_file($catalog_image['tmp_name'], $imagePath)) {
                die('Lỗi khi tải lên ảnh.');
            }
        }

        // Chuẩn bị câu lệnh SQL
        $stmt = $this->db->prepare("INSERT INTO catalogs (catalog_name, description, catalog_image) VALUES (:catalog_name, :description, :catalog_image)");

        // Gán tham số vào câu lệnh SQL
        $stmt->bindParam(':catalog_name', $catalog_name, \PDO::PARAM_STR);
        $stmt->bindParam(':description', $description, \PDO::PARAM_STR);
        $stmt->bindParam(':catalog_image', $imageName, \PDO::PARAM_STR);

        // Thực thi câu lệnh SQL và kiểm tra kết quả
        if ($stmt->execute()) {
            // Thiết lập thông báo thành công
            Session::set('message', [
                'success' => 'Thêm danh mục thành công!'
            ]);
            // Chuyển hướng về danh sách danh mục
            header('Location: ' . BASE_URL . '/admin/catalogs');
            exit(); // Kết thúc xử lý sau khi chuyển hướng
        } else {
            // Hiển thị thông báo lỗi nếu xảy ra sự cố
            echo "Đã xảy ra lỗi khi lưu danh mục.";
        }
    }


    public function deleteCatalog()
    {
        // Lấy tham số từ POST hoặc query string
        $encryptedId = $_POST['id'] ?? null;
        $id = Encrypt::decryptId($encryptedId, KEY);
        if (!$id) {
            die("ID không hợp lệ.");
        }

        $query = "SELECT catalog_image FROM catalogs WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id, \PDO::PARAM_INT);
        $stmt->execute();

        $catalog = $stmt->fetch(\PDO::FETCH_ASSOC);

        if ($catalog && !empty($catalog['catalog_image'])) {
            $imagePath = UPLOAD_DIR . 'catalogs/' . $catalog['catalog_image'];

            // Kiểm tra và xóa file ảnh nếu tồn tại
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }
        }

        // Tiến hành xóa danh mục
        $stmt = $this->db->prepare("DELETE FROM catalogs WHERE id = :id");

        // Gán tham số vào câu lệnh SQL
        $stmt->bindParam(':id', $id, \PDO::PARAM_INT);

        // Thực thi câu lệnh SQL và kiểm tra kết quả
        if ($stmt->execute()) {
            // Thiết lập thông báo thành công
            Session::set('message', [
                'success' => 'Xóa danh mục thành công!'
            ]);
        } else {
            // Hiển thị lỗi nếu xảy ra sự cố
            die("Đã xảy ra lỗi khi xóa danh mục.");
        }

        // Chuyển hướng về danh sách danh mục
        header('Location: ' . BASE_URL . '/admin/catalogs');
        exit();
    }


    public function getCatalogById($id)
    {
        // Kiểm tra tính hợp lệ của ID
        if (!is_numeric($id)) {
            die("ID không hợp lệ.");
        }

        // Chuẩn bị câu lệnh SQL
        $stmt = $this->db->prepare("SELECT * FROM catalogs WHERE id = :id");

        // Gán tham số ID vào câu lệnh SQL
        $stmt->bindParam(':id', $id, \PDO::PARAM_INT);

        // Thực thi câu lệnh
        $stmt->execute();

        // Trả về kết quả dưới dạng mảng
        return $stmt->fetch(\PDO::FETCH_ASSOC); // Trả về dữ liệu của danh mục dưới dạng mảng kết hợp
    }

    public function validateUpdateCatalogData($catalog_name, $description, $catalog_image, $currentImage = null)
    {
        $errors = [];

        // Kiểm tra tên danh mục
        if (empty($catalog_name)) {
            $errors['catalog_name'] = 'Tên danh mục không được để trống.';
        }

        // Kiểm tra mô tả
        if (empty($description)) {
            $errors['description'] = 'Mô tả không được để trống.';
        }

        // Kiểm tra hình ảnh
        if ($catalog_image && $catalog_image['error'] === UPLOAD_ERR_OK) {
            // Kiểm tra phần mở rộng của tệp
            $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];
            $fileExtension = strtolower(pathinfo($catalog_image['name'], PATHINFO_EXTENSION));
            if (!in_array($fileExtension, $allowedExtensions)) {
                $errors['catalog_image'] = 'Phần mở rộng tệp không hợp lệ. Chỉ hỗ trợ JPG, PNG, GIF.';
            }

            // Kiểm tra tên ảnh trong cơ sở dữ liệu nếu có ảnh mới
            $imageName = basename($catalog_image['name']);
            if ($this->checkImageExists($imageName, $currentImage)) {
                $errors['catalog_image'] = 'Tên ảnh đã tồn tại. Vui lòng chọn tên khác.';
            }
        }
        return $errors;
    }
    public function editCatalog()
    {
        $errors = [];
        $encryptedId = $_GET['id'] ?? null; // Lấy id từ query string
        $id = Encrypt::decryptId($encryptedId, KEY);
        // Nếu không có id, dừng xử lý
        if (!$id) {
            die("ID không hợp lệ.");
        }

        // Nếu là phương thức POST, xử lý dữ liệu form
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $catalog_name = $_POST['catalog_name'] ?? '';
            $description = $_POST['description'] ?? '';
            $catalog_image = $_FILES['catalog_image'] ?? null;
            $errors = $this->validateUpdateCatalogData($catalog_name, $description, $catalog_image);

            // Nếu không có lỗi, cập nhật danh mục
            if (empty($errors)) {
                $this->updateCatalog($id, $catalog_name, $description, $catalog_image);
                header('Location: ' . BASE_URL_NAME . '/admin/catalogs');
                exit();
            }
        }

        // Nếu có lỗi, lấy danh mục hiện tại để hiển thị trong form
        $catalog = $this->getCatalogById($id);
        include_once VIEW_PATH . 'admin/catalogs/edit.php';
    }


    public function updateCatalog($id, $catalog_name, $description, $catalog_image)
    {
        $uploadDir = UPLOAD_DIR . 'catalogs/';
        $imagePath = null;

        // Lấy thông tin sản phẩm hiện tại để kiểm tra ảnh cũ
        $catalog = $this->getCatalogById($id);
        if (!$catalog) {
            die('Không tìm thấy danh mục với ID: ' . $id);
        }
        $currentImagePath = $catalog['catalog_image'] ?? null;

        // Nếu có tải lên ảnh mới, xử lý lưu ảnh mới
        if ($catalog_image && $catalog_image['error'] === UPLOAD_ERR_OK) {
            $imageName = basename($catalog_image['name']); // Chỉ lấy tên ảnh (không có đường dẫn đầy đủ)
            $imagePath = $imageName;

            // Di chuyển ảnh mới vào thư mục
            if (!move_uploaded_file($catalog_image['tmp_name'], $uploadDir . $imageName)) {
                die('Lỗi khi tải lên ảnh.');
            }

            // Xóa ảnh cũ nếu có
            if ($currentImagePath && file_exists($uploadDir . $currentImagePath)) {
                unlink($uploadDir . $currentImagePath);
            }
        } else {
            // Nếu không có ảnh mới, giữ nguyên ảnh cũ
            $imagePath = $currentImagePath;
        }

        // Chuẩn bị câu lệnh SQL
        $stmt = $this->db->prepare("UPDATE catalogs SET catalog_name = :catalog_name, description = :description, catalog_image = :catalog_image WHERE id = :id");

        // Gán tham số cho câu lệnh SQL
        $stmt->bindParam(':catalog_name', $catalog_name, \PDO::PARAM_STR);
        $stmt->bindParam(':description', $description, \PDO::PARAM_STR);
        $stmt->bindParam(':catalog_image', $imagePath, \PDO::PARAM_STR);
        $stmt->bindParam(':id', $id, \PDO::PARAM_INT);
    
        if ($stmt->execute()) {
            Session::set('message', [
                'success'=>'Cập nhật danh mục thành công!'
            ]);
            header('Location: ' . BASE_URL . '/admin/catalogs');
            exit();
        } else {
            echo "Đã xảy ra lỗi khi cập nhật danh mục.";
        }
    }
}

?>