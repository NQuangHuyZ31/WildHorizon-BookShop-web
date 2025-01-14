<?php
namespace App\Controllers\Admin;
use App\Controllers\Controller;
use Core\Session;

class CatalogController extends Controller
{
    public function getAllCatalogs()
    {
        $result = $this->db->query("SELECT * FROM catalogs");
        $catalogs = [];
        while ($row = $result->fetch_assoc()) {
            $catalogs[] = $row;
        }
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
        $stmt = $this->db->prepare("INSERT INTO catalogs (name, description) VALUES (?, ?)");

        // Kiểm tra kết nối và chuẩn bị câu lệnh SQL
        if ($stmt === false) {
            die('Lỗi chuẩn bị câu lệnh SQL: ' . $this->db->error);
        }

        // Liên kết các tham số với câu lệnh SQL
        $stmt->bind_param('ss', $name, $description); // 'ss' cho biết 2 tham số này là string

        // Thực thi câu lệnh SQL và kiểm tra xem có lỗi không
        if ($stmt->execute()) {
            Session::set('message', [
                'success'=>'Thêm danh mục thành công!'
            ]);
            header('Location: ' . BASE_URL . '/admin/catalogs');
            exit(); // Dừng lại sau khi chuyển hướng để tránh xuất thêm bất kỳ nội dung nào
        } else {
            // Hiển thị thông báo lỗi nếu xảy ra sự cố
            echo "Đã xảy ra lỗi khi lưu danh mục.";
        }
    }

    public function deleteCatalog()
    {
        // Lấy tham số từ query string
        $id = $_POST['id'] ?? null;

        if (!$id) {
            // Xử lý khi không có id
            die("ID không hợp lệ.");
        }

        // Tiến hành xóa danh mục
        $stmt = $this->db->prepare("DELETE FROM catalogs WHERE catalog_id = ?");
        if ($stmt === false) {
            die('Lỗi chuẩn bị câu lệnh SQL: ' . $this->db->error);
        }

        $stmt->bind_param('i', $id); // 'i' cho biết tham số là integer

        if ($stmt->execute()) {
            Session::set('message', [
                'success'=>'Xóa danh mục thành công!'
            ]);
        } else {
        }

        header('Location: ' . BASE_URL_NAME . '/admin/catalogs');
        exit();
    }

    public function getCatalogById($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM catalogs WHERE catalog_id = ?");
        if ($stmt === false) {
            die('Lỗi chuẩn bị câu lệnh SQL: ' . $this->db->error);
        }
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc(); // Trả về dữ liệu của danh mục
    }

    public function editCatalog()
    {
        $errors = [];
        $id = $_GET['id'] ?? null; // Lấy id từ query string

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
        $stmt = $this->db->prepare("UPDATE catalogs SET name = ?, description = ? WHERE catalog_id = ?");
        if ($stmt === false) {
            die('Lỗi chuẩn bị câu lệnh SQL: ' . $this->db->error);
        }
        $stmt->bind_param('ssi', $name, $description, $id);
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