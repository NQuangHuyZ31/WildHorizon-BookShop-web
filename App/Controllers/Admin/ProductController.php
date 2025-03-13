<?php

namespace App\Controllers\Admin;

use Core\Session;
use Core\Encrypt;
use App\Controllers\Controller;

class ProductController extends Controller
{
    public function getAllProducts()
    {
        // Lấy trang hiện tại từ URL, mặc định là 1
        $currentPage = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;

        // Số sản phẩm mỗi trang
        $perPage = 10;

        // Tính toán offset
        $offset = ($currentPage - 1) * $perPage;

        // Lấy từ khóa tìm kiếm (nếu có)
        $search = isset($_GET['search']) ? trim($_GET['search']) : '';

        // Truy vấn để lấy tổng số sản phẩm (có áp dụng tìm kiếm)
        $countQuery = "
        SELECT COUNT(*) AS total 
        FROM products AS p
        LEFT JOIN catalogs AS c ON p.catalog_id = c.catalog_id
        WHERE p.name LIKE :search OR c.name LIKE :search
    ";
        $stmt = $this->db->prepare($countQuery);
        $searchParam = '%' . $search . '%';
        $stmt->bindParam(':search', $searchParam, \PDO::PARAM_STR);
        $stmt->execute();
        $totalProducts = $stmt->fetch(\PDO::FETCH_ASSOC)['total'];

        // Tính tổng số trang
        $totalPages = ceil($totalProducts / $perPage);

        // Truy vấn lấy sản phẩm có áp dụng tìm kiếm và phân trang
        $query = "
        SELECT 
            p.*, 
            c.name AS catalog_name,
            fs.discount_price AS discount
        FROM 
            products AS p
        LEFT JOIN 
            catalogs AS c ON p.catalog_id = c.catalog_id
        LEFT JOIN 
            flashsales AS fs ON fs.product_id = p.product_id
        WHERE p.name LIKE :search OR c.name LIKE :search
        LIMIT :perPage OFFSET :offset
    ";

        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':search', $searchParam, \PDO::PARAM_STR);
        $stmt->bindParam(':perPage', $perPage, \PDO::PARAM_INT);
        $stmt->bindParam(':offset', $offset, \PDO::PARAM_INT);
        $stmt->execute();

        $products = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        // Truyền sản phẩm, trang hiện tại, tổng số trang và từ khóa tìm kiếm vào view
        include_once VIEW_PATH . 'admin/products/index.php';
    }


    private function getAllCatalogs()
    {
        $query = "SELECT * FROM catalogs";
        $stmt = $this->db->prepare($query);
        $stmt->execute();

        $catalogs = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        return $catalogs;
    }


    private function validateProductData($name, $catalog_id, $price, $stock, $image, $currentImage = null)
    {
        $errors = [];

        // Kiểm tra tên sản phẩm
        if (empty($name)) {
            $errors['name'] = 'Tên sản phẩm không được để trống.';
        }

        // Kiểm tra danh mục
        if (empty($catalog_id)) {
            $errors['catalog_id'] = 'Vui lòng chọn danh mục.';
        }

        // Kiểm tra giá
        if (!is_numeric($price) || $price <= 0) {
            $errors['price'] = 'Giá sản phẩm phải là số lớn hơn 0.';
        }

        // Kiểm tra số lượng
        if (!is_numeric($stock) || $stock < 0) {
            $errors['stock'] = 'Số lượng sản phẩm phải là số không âm.';
        }

        // Kiểm tra hình ảnh
        if ($image && $image['error'] === UPLOAD_ERR_NO_FILE) {
            // Nếu không tải ảnh lên mới, thì không báo lỗi
            if (empty($currentImage)) {
                $errors['image'] = 'Vui lòng tải lên hình ảnh.';
            }
        } elseif ($image && $image['error'] === UPLOAD_ERR_OK) {
            // Kiểm tra phần mở rộng của tệp
            $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];
            $fileExtension = strtolower(pathinfo($image['name'], PATHINFO_EXTENSION));
            if (!in_array($fileExtension, $allowedExtensions)) {
                $errors['image'] = 'Phần mở rộng tệp không hợp lệ. Chỉ hỗ trợ JPG, PNG, GIF.';
            }

            // Kiểm tra tên ảnh trong cơ sở dữ liệu nếu có ảnh mới
            $imageName = basename($image['name']);
            if ($this->checkImageExists($imageName, $currentImage)) {
                $errors['image'] = 'Tên ảnh đã tồn tại. Vui lòng chọn tên khác.';
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
        $query = "SELECT COUNT(*) FROM products WHERE image = :imageName";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':imageName', $imageName, \PDO::PARAM_STR);
        $stmt->execute();

        // Lấy kết quả
        $count = $stmt->fetchColumn();

        // Kiểm tra nếu có ít nhất một sản phẩm có tên ảnh này
        return $count > 0;
    }

    public function createProduct()
    {
        $errors = [];
        $catalogs = $this->getAllCatalogs(); // Lấy danh sách catalog để hiển thị trong form

        // Kiểm tra nếu là phương thức POST
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Lấy dữ liệu từ form
            $name = $_POST['name'] ?? '';
            $description = $_POST['description'] ?? null; // Có thể null
            $catalog_id = $_POST['catalog_id'] ?? null;
            $author = $_POST['author'] ?? null; // Có thể null
            $publish_year = $_POST['publish_year'] ?? null; // Có thể null
            $color = $_POST['color'] ?? null; // Có thể null
            $price = $_POST['price'] ?? '';
            $stock = $_POST['stock'] ?? '';
            $image = $_FILES['image'] ?? null; // File upload

            // Kiểm tra lỗi trên các trường
            $errors = $this->validateProductData($name, $catalog_id, $price, $stock, $image);

            // Nếu không có lỗi, lưu sản phẩm
            if (empty($errors)) {
                $this->saveProduct($name, $description, $catalog_id, $author, $publish_year, $color, $price, $stock, $image);
                return; // Dừng lại sau khi lưu xong và chuyển hướng
            }
        }

        // Nếu có lỗi hoặc phương thức GET, hiển thị form tạo sản phẩm
        include_once VIEW_PATH . 'admin/products/create.php';
    }

    private function saveProduct($name, $description, $catalog_id, $author, $publish_year, $color, $price, $stock, $image)
    {
        // Xử lý upload ảnh nếu có
        $imagePath = null;
        if ($image && $image['error'] === UPLOAD_ERR_OK) {
            $uploadDir = UPLOAD_DIR . 'products/';
            $imageName = basename($image['name']);
            $imagePath = $uploadDir . $imageName;
            if (!move_uploaded_file($image['tmp_name'], $imagePath)) {
                die('Lỗi khi tải lên ảnh.');
            }
        }

        // Chuẩn bị câu lệnh SQL
        // Chuẩn bị câu lệnh SQL
        $query = "
            INSERT INTO products (name, description, catalog_id, author, publish_year, color, price, stock, image)
            VALUES (:name, :description, :catalog_id, :author, :publish_year, :color, :price, :stock, :image)
        ";

        $stmt = $this->db->prepare($query);

        // Liên kết các tham số
        $stmt->bindParam(':name', $name, \PDO::PARAM_STR);
        $stmt->bindParam(':description', $description, \PDO::PARAM_STR);
        $stmt->bindParam(':catalog_id', $catalog_id, \PDO::PARAM_INT);
        $stmt->bindParam(':author', $author, \PDO::PARAM_STR);
        $stmt->bindParam(':publish_year', $publish_year, \PDO::PARAM_INT);
        $stmt->bindParam(':color', $color, \PDO::PARAM_STR);
        $stmt->bindParam(':price', $price, \PDO::PARAM_STR);
        $stmt->bindParam(':stock', $stock, \PDO::PARAM_INT);
        $stmt->bindParam(':image', $imageName, \PDO::PARAM_STR);

        // Thực thi câu lệnh SQL
        if ($stmt->execute()) {
            Session::set('message', [
                'success' => 'Thêm sản phẩm thành công!'
            ]);
            header('Location: ' . BASE_URL_NAME . '/admin/products');
            exit();
        } else {
            echo "Đã xảy ra lỗi khi lưu sản phẩm.";
        }
    }

    public function deleteProduct()
    {
        $encryptedId = $_POST['id'] ?? null;

        if (!$encryptedId) {
            die("ID không hợp lệ.");
        }

        $id = Encrypt::decryptId($encryptedId, KEY);

        // Truy vấn tên ảnh từ cơ sở dữ liệu
        $query = "SELECT image FROM products WHERE product_id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id, \PDO::PARAM_INT);
        $stmt->execute();

        $product = $stmt->fetch(\PDO::FETCH_ASSOC);

        if ($product && !empty($product['image'])) {
            $imagePath = UPLOAD_DIR . 'products/' . $product['image'];

            // Kiểm tra và xóa file ảnh nếu tồn tại
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }
        }

        // Xóa bản ghi sản phẩm trong cơ sở dữ liệu
        $deleteQuery = "DELETE FROM products WHERE product_id = :id";
        $deleteStmt = $this->db->prepare($deleteQuery);
        $deleteStmt->bindParam(':id', $id, \PDO::PARAM_INT);

        if ($deleteStmt->execute()) {
            Session::set('message', [
                'success' => 'Xóa sản phẩm thành công!'
            ]);
            header('Location: ' . BASE_URL_NAME . '/admin/products');
            exit();
        } else {
            echo "Đã xảy ra lỗi khi xóa sản phẩm.";
        }
    }

    public function getProductById($id)
    {
        $query = "SELECT * FROM products WHERE product_id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id, \PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetch(\PDO::FETCH_ASSOC); // Trả về dữ liệu của sản phẩm
    }


    private function validateUpdateProductData($name, $catalog_id, $price, $stock, $image, $currentImage = null)
    {
        $errors = [];

        // Kiểm tra tên sản phẩm
        if (empty($name)) {
            $errors['name'] = 'Tên sản phẩm không được để trống.';
        }

        // Kiểm tra danh mục
        if (empty($catalog_id)) {
            $errors['catalog_id'] = 'Vui lòng chọn danh mục.';
        }

        // Kiểm tra giá
        if (!is_numeric($price) || $price <= 0) {
            $errors['price'] = 'Giá sản phẩm phải là số lớn hơn 0.';
        }

        // Kiểm tra số lượng
        if (!is_numeric($stock) || $stock < 0) {
            $errors['stock'] = 'Số lượng sản phẩm phải là số không âm.';
        }

        // Kiểm tra hình ảnh

        if ($image && $image['error'] === UPLOAD_ERR_OK) {
            // Kiểm tra phần mở rộng của tệp
            $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];
            $fileExtension = strtolower(pathinfo($image['name'], PATHINFO_EXTENSION));
            if (!in_array($fileExtension, $allowedExtensions)) {
                $errors['image'] = 'Phần mở rộng tệp không hợp lệ. Chỉ hỗ trợ JPG, PNG, GIF.';
            }

            // Kiểm tra tên ảnh trong cơ sở dữ liệu nếu có ảnh mới
            $imageName = basename($image['name']);
            if ($this->checkImageExists($imageName, $currentImage)) {
                $errors['image'] = 'Tên ảnh đã tồn tại. Vui lòng chọn tên khác.';
            }
        }

        return $errors;
    }
    public function editProduct()
    {
        $errors = [];
        $catalogs = $this->getAllCatalogs();
        $encryptedId = $_GET['id'] ?? null;

        // Nếu không có ID, dừng xử lý
        if (!$encryptedId) {
            die("ID không hợp lệ.");
        }

        // Giải mã ID
        $id = Encrypt::decryptId($encryptedId, KEY);

        // Kiểm tra xem ID có hợp lệ không
        if (!$id) {
            die("ID không hợp lệ.");
        }

        // Lấy thông tin sản phẩm hiện tại
        $product = $this->getProductById($id);

        // Nếu là phương thức POST, xử lý dữ liệu form
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Lấy dữ liệu từ form
            $name = $_POST['name'] ?? '';
            $description = $_POST['description'] ?? null;
            $catalog_id = $_POST['catalog_id'] ?? null;
            $author = $_POST['author'] ?? null;
            $publish_year = $_POST['publish_year'] ?? null;
            $color = $_POST['color'] ?? null;
            $price = $_POST['price'] ?? 0;
            $stock = $_POST['stock'] ?? 0;
            $image = $_FILES['image'] ?? null;

            // Kiểm tra dữ liệu nhập vào
            $errors = $this->validateUpdateProductData($name, $catalog_id, $price, $stock, $image);

            // Nếu không có lỗi, xử lý cập nhật sản phẩm
            if (empty($errors)) {
                $this->updateProduct($id, $name, $description, $catalog_id, $author, $publish_year, $color, $price, $stock, $image);
                header('Location: ' . BASE_URL_NAME . '/admin/products');
                exit();
            }
        }

        // Nếu có lỗi hoặc là phương thức GET, hiển thị thông tin sản phẩm trong form
        $product = $this->getProductById($id);
        include_once VIEW_PATH . 'admin/products/edit.php';
    }

    public function updateProduct($id, $name, $description, $catalog_id, $author, $publish_year, $color, $price, $stock, $image)
    {
        $uploadDir = UPLOAD_DIR . 'products/';
        $imagePath = null;

        // Lấy thông tin sản phẩm hiện tại để kiểm tra ảnh cũ
        $product = $this->getProductById($id);
        if (!$product) {
            die('Không tìm thấy sản phẩm với ID: ' . $id);
        }
        $currentImagePath = $product['image'] ?? null;

        // Nếu có tải lên ảnh mới, xử lý lưu ảnh mới
        if ($image && $image['error'] === UPLOAD_ERR_OK) {
            $imageName = basename($image['name']); // Chỉ lấy tên ảnh (không có đường dẫn đầy đủ)
            $imagePath = $imageName;

            // Di chuyển ảnh mới vào thư mục
            if (!move_uploaded_file($image['tmp_name'], $uploadDir . $imageName)) {
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
        $query = "
            UPDATE products 
            SET name = :name, description = :description, catalog_id = :catalog_id, author = :author, 
                publish_year = :publish_year, color = :color, price = :price, stock = :stock, image = :image 
            WHERE product_id = :id
        ";

        // Chuẩn bị statement
        $stmt = $this->db->prepare($query);

        // Liên kết các tham số
        $stmt->bindParam(':name', $name, \PDO::PARAM_STR);
        $stmt->bindParam(':description', $description, \PDO::PARAM_STR);
        $stmt->bindParam(':catalog_id', $catalog_id, \PDO::PARAM_INT);
        $stmt->bindParam(':author', $author, \PDO::PARAM_STR);
        $stmt->bindParam(':publish_year', $publish_year, \PDO::PARAM_INT);
        $stmt->bindParam(':color', $color, \PDO::PARAM_STR);
        $stmt->bindParam(':price', $price, \PDO::PARAM_STR);
        $stmt->bindParam(':stock', $stock, \PDO::PARAM_INT);
        $stmt->bindParam(':image', $imagePath, \PDO::PARAM_STR);
        $stmt->bindParam(':id', $id, \PDO::PARAM_INT);

        // Thực thi câu lệnh SQL
        if ($stmt->execute()) {
            Session::set('message', [
                'success' => 'Cập nhật sản phẩm thành công!'
            ]);
            header('Location: ' . BASE_URL_NAME . '/admin/products');
            exit();
        } else {
            die('Đã xảy ra lỗi khi cập nhật sản phẩm');
        }
    }
}
