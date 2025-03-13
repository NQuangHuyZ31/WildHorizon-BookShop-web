<?php
namespace App\Controllers\Admin;

use Core\Session;
use Core\Encrypt;
use App\Controllers\Controller;

class BrandController extends Controller
{
    public function getAllBrands()
    {
        $stmt = $this->db->prepare("SELECT * FROM brands");
        $stmt->execute();
        $brands = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        include_once VIEW_PATH . 'admin/brands/index.php';
    }

    private function getBrandById($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM brands WHERE id = :id");
        $stmt->bindParam(':id', $id, \PDO::PARAM_INT);
        $stmt->execute();

        $brand = $stmt->fetch(\PDO::FETCH_ASSOC);
        return $brand;
    }
    public function createBrand()
    {
        // Khởi tạo mảng lỗi
        $errors = [];

        // Kiểm tra nếu là phương thức POST
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Lấy dữ liệu từ form
            $brand_name = $_POST['brand_name'] ?? '';
            $description = $_POST['description'] ?? '';
            
            // Kiểm tra lỗi trên các trường
            $errors = $this->validatebrandData($brand_name);

            // Nếu không có lỗi, lưu danh mục
            if (empty($errors)) {
                // Truyền đúng tham số vào savebrand
                $this->savebrand($brand_name, $description);
                return; // Dừng lại sau khi lưu xong và chuyển hướng
            }
        }

        // Nếu có lỗi, truyền lỗi vào view
        include_once VIEW_PATH . 'admin/brands/create.php';
    }

    private function validatebrandData($brand_name)
    {
        $errors = [];

        if (empty($brand_name)) {
            $errors['brand_name'] = 'Tên thương hiệu không được để trống!';
        }

        return $errors;
    }

    private function savebrand($brand_name, $description)
    {
        $stmt = $this->db->prepare("INSERT INTO brands (brand_name, description) VALUES (:brand_name, :description)");
        $stmt->bindParam(':brand_name', $brand_name, \PDO::PARAM_STR);
        $stmt->bindParam(':description', $description, \PDO::PARAM_STR);
        // Thực thi câu lệnh SQL và kiểm tra kết quả
        if ($stmt->execute()) {
            // Thiết lập thông báo thành công
            Session::set('message', [
                'success' => 'Thêm thương hiệu thành công!'
            ]);
            // Chuyển hướng về danh sách thương hiệu
            header('Location: ' . BASE_URL . '/admin/brands');
            exit(); // Kết thúc xử lý sau khi chuyển hướng
        } else {
            // Hiển thị thông báo lỗi nếu xảy ra sự cố
            echo "Đã xảy ra lỗi khi lưu thương hiệu.";
        }
    }

    public function deleteBrand()
    {
        $encryptedId = $_POST['id'] ?? null;
        $id = Encrypt::decryptId($encryptedId, KEY);
        if (!$id) {
            die("ID không hợp lệ.");
        }

        $stmt = $this->db->prepare("DELETE FROM brands WHERE id = :id");
        $stmt->bindParam(':id', $id, \PDO::PARAM_INT);
        
        if ($stmt->execute()) {
            Session::set('message', [
                'success' => 'Xóa thương hiệu thành công!'
            ]);
            header('Location: ' . BASE_URL . '/admin/brands');
            exit(); // Kết thúc xử lý sau khi chuyển hướng
        }
        else {
            echo "Đã xảy ra lỗi khi xóa thương hiệu.";
        }

        // Chuyển hướng về danh sách danh mục
        header('Location: ' . BASE_URL . '/admin/brands');
        exit();
    }

    public function editBrand()
    {
        $errors = [];
        $encryptedId = $_GET['id'] ?? null; // Lấy id từ query string
        $id = Encrypt::decryptId($encryptedId, KEY);
        if (!$id) {
            die("ID không hợp lệ.");
        }

        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $brand_name = $_POST['brand_name'] ?? '';
            $description = $_POST['description'] ?? '';
            $errors = $this->validatebrandData($brand_name, $description);

            if(empty($errors)) {
                $this->updatebrand($id, $brand_name, $description);
                header('Location: ' . BASE_URL . '/admin/brands');
                exit(); // Kết thúc xử lý sau khi chuyển hướng
            }
        }

        $brand = $this->getBrandById($id);
        include_once VIEW_PATH . 'admin/brands/edit.php';
    }

    private function updatebrand($id, $brand_name, $description)
    {
        $stmt = $this->db->prepare("UPDATE brands SET brand_name = :brand_name, description = :description WHERE id = :id");
        $stmt->bindParam(':brand_name', $brand_name, \PDO::PARAM_STR);
        $stmt->bindParam(':description', $description, \PDO::PARAM_STR);
        $stmt->bindParam(':id', $id, \PDO::PARAM_INT);

        if ($stmt->execute()) {
            Session::set('message', [
                'success' => 'Cập nhật thương hiệu thành công!'
            ]);
            header('Location: ' . BASE_URL . '/admin/brands');
            exit(); // Kết thúc xử lý sau khi chuyển hướng
        }
        else{
            echo "Đã xảy ra lỗi khi Cập nhật thương hiệu.";
        }
    }
}

?>