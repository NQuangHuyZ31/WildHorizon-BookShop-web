<?php
namespace App\Controllers\Admin;
use App\Controllers\Controller;
use Core\Session;
use Core\Encrypt;
class CatalogController extends Controller
{
    public function getAllCatalogs()
    {
        // Truy vấn danh sách danh mục
        $stmt = $this->db->prepare("SELECT * FROM catalogs");
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
            $name = $_POST['name'] ?? '';
            $description = $_POST['description'] ?? '';

            // Kiểm tra lỗi trên các trường
            $errors = $this->validateCatalogData($name, $description);

            // Nếu không có lỗi, lưu danh mục
            if (empty($errors)) {
                // Truyền đúng tham số vào saveCatalog
                $this->saveCatalog($name, $description); // Truyền $name và $description
                return; // Dừng lại sau khi lưu xong và chuyển hướng
            }
        }

        // Nếu có lỗi, truyền lỗi vào view
        include_once VIEW_PATH . 'admin/catalogs/create.php';
    }


    private function validateCatalogData($name, $description)
    {
        $errors = [];

        // Kiểm tra tên danh mục
        if (empty($name)) {
            $errors['name'] = 'Tên danh mục không được để trống.';
        }

        // Kiểm tra mô tả
        if (empty($description)) {
            $errors['description'] = 'Mô tả không được để trống.';
        }

        return $errors;
    }


    public function saveCatalog($name, $description)
    {
        // Chuẩn bị câu lệnh SQL
        $stmt = $this->db->prepare("INSERT INTO catalogs (name, description) VALUES (:name, :description)");

        // Gán tham số vào câu lệnh SQL
        $stmt->bindParam(':name', $name, \PDO::PARAM_STR);
        $stmt->bindParam(':description', $description, \PDO::PARAM_STR);

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

        // Tiến hành xóa danh mục
        $stmt = $this->db->prepare("DELETE FROM catalogs WHERE catalog_id = :id");

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
        $stmt = $this->db->prepare("SELECT * FROM catalogs WHERE catalog_id = :id");

        // Gán tham số ID vào câu lệnh SQL
        $stmt->bindParam(':id', $id, \PDO::PARAM_INT);

        // Thực thi câu lệnh
        $stmt->execute();

        // Trả về kết quả dưới dạng mảng
        return $stmt->fetch(\PDO::FETCH_ASSOC); // Trả về dữ liệu của danh mục dưới dạng mảng kết hợp
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
            $name = $_POST['name'] ?? '';
            $description = $_POST['description'] ?? '';
            $errors = $this->validateCatalogData($name, $description);

            // Nếu không có lỗi, cập nhật danh mục
            if (empty($errors)) {
                $this->updateCatalog($id, $name, $description);
                header('Location: ' . BASE_URL_NAME . '/admin/catalogs');
                exit();
            }
        }

        // Nếu có lỗi, lấy danh mục hiện tại để hiển thị trong form
        $catalog = $this->getCatalogById($id);
        include_once VIEW_PATH . 'admin/catalogs/edit.php';
    }


    public function updateCatalog($id, $name, $description)
    {
        // Chuẩn bị câu lệnh SQL
        $stmt = $this->db->prepare("UPDATE catalogs SET name = :name, description = :description WHERE catalog_id = :id");

        // Gán tham số cho câu lệnh SQL
        $stmt->bindParam(':name', $name, \PDO::PARAM_STR);
        $stmt->bindParam(':description', $description, \PDO::PARAM_STR);
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