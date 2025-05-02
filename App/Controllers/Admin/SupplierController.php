<?php

namespace App\Controllers\Admin;

use App\Controllers\Controller;
use Core\Session;
use Core\Encrypt;

class SupplierController extends Controller
{
    public function getAllSuppliers()
    {
        // Lấy trang hiện tại từ URL, mặc định là 1
        $currentPage = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;

        // Số brand mỗi trang
        $perPage = 7;

        // Tính toán offset
        $offset = ($currentPage - 1) * $perPage;

        // Lấy từ khóa tìm kiếm (nếu có)
        $search = isset($_GET['search']) ? trim($_GET['search']) : '';

        // Truy vấn để lấy tổng số sản phẩm (có áp dụng tìm kiếm)
        $countQuery = "SELECT COUNT(*) AS total FROM suppliers WHERE supplier_name LIKE :search";
        $stmt = $this->db->prepare($countQuery);
        $searchParam = '%' . $search . '%';
        $stmt->bindParam(':search', $searchParam, \PDO::PARAM_STR);
        $stmt->execute();
        $totalSuppliers = $stmt->fetch(\PDO::FETCH_ASSOC)['total'];

        // Tính tổng số trang
        $totalPages = ceil($totalSuppliers / $perPage);

        // Truy vấn sử dụng phân trang    
        $stmt = $this->db->prepare("SELECT * FROM suppliers WHERE supplier_name LIKE :search ORDER BY supplier_name ASC LIMIT :offset, :perPage");
        $searchParam = '%' . $search . '%';
        $stmt->bindParam(':search', $searchParam, \PDO::PARAM_STR);
        $stmt->bindParam(':offset', $offset, \PDO::PARAM_INT);
        $stmt->bindParam(':perPage', $perPage, \PDO::PARAM_INT);
        $stmt->execute();
        
        $suppliers = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        include_once VIEW_PATH . 'admin/suppliers/index.php';
    }

    private function getSupplierById($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM suppliers WHERE id = :id");
        $stmt->bindParam(':id', $id, \PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    public function createSupplier()
    {
        $errors = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $supplier_name = $_POST['supplier_name'] ?? '';
            $phone = $_POST['phone'] ?? '';
            $email = $_POST['email'] ?? '';
            $address = $_POST['address'] ?? '';

            $errors = $this->validateSupplierData($supplier_name, $phone, $email, $address);

            if (empty($errors)) {
                $this->saveSupplier($supplier_name, $phone, $email, $address);
                return;
            }
        }

        include_once VIEW_PATH . 'admin/suppliers/create.php';
    }

    private function validateSupplierData($supplier_name, $phone, $email, $address)
    {
        $errors = [];

        if (empty($supplier_name)) {
            $errors['supplier_name'] = 'Tên nhà cung cấp không được để trống!';
        }

        if (empty($phone)) {
            $errors['phone'] = 'Số điện thoại không được để trống!';
        } elseif (!preg_match('/^(0|\+84)[0-9]{9}$/', $phone)) {
            $errors['phone'] = 'Số điện thoại không hợp lệ! Định dạng đúng: 0XXXXXXXXX hoặc +84XXXXXXXXX';
        }
        
        if (empty($email)) {
            $errors['email'] = 'Email không được để trống!';
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = 'Email không hợp lệ!';
        } elseif (!preg_match('/^[\w\.-]+@[\w\.-]+\.[a-zA-Z]{2,6}$/', $email)) {
            $errors['email'] = 'Email không đúng định dạng!';
        }
    
        if (empty($address)) {
            $errors['address'] = 'Địa chỉ không được để trống!';
        }

        return $errors;
    }

    private function saveSupplier($supplier_name, $phone, $email, $address)
    {
        $stmt = $this->db->prepare("INSERT INTO suppliers (supplier_name, phone, email, address) VALUES (:supplier_name, :phone, :email, :address)");
        $stmt->bindParam(':supplier_name', $supplier_name, \PDO::PARAM_STR);
        $stmt->bindParam(':phone', $phone, \PDO::PARAM_STR);
        $stmt->bindParam(':email', $email, \PDO::PARAM_STR);
        $stmt->bindParam(':address', $address, \PDO::PARAM_STR);

        if ($stmt->execute()) {
            Session::set('message', ['success' => 'Thêm nhà cung cấp thành công!']);
            header('Location: ' . BASE_URL . '/admin/suppliers');
            exit();
        } else {
            echo "Đã xảy ra lỗi khi lưu nhà cung cấp.";
        }
    }

    public function deleteSupplier()
    {
        $encryptedId = $_POST['id'] ?? null;
        $id = Encrypt::decryptId($encryptedId, KEY);

        if (!$id) {
            die("ID không hợp lệ.");
        }

        $stmt = $this->db->prepare("DELETE FROM suppliers WHERE id = :id");
        $stmt->bindParam(':id', $id, \PDO::PARAM_INT);

        if ($stmt->execute()) {
            Session::set('message', ['success' => 'Xóa nhà cung cấp thành công!']);
        } else {
            echo "Đã xảy ra lỗi khi xóa nhà cung cấp.";
        }

        header('Location: ' . BASE_URL . '/admin/suppliers');
        exit();
    }

    public function editSupplier()
    {
        $errors = [];
        $encryptedId = $_GET['id'] ?? null;
        $id = Encrypt::decryptId($encryptedId, KEY);

        if (!$id) {
            die("ID không hợp lệ.");
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $supplier_name = $_POST['supplier_name'] ?? '';
            $phone = $_POST['phone'] ?? '';
            $email = $_POST['email'] ?? '';
            $address = $_POST['address'] ?? '';

            $errors = $this->validateSupplierData($supplier_name, $phone, $email, $address);

            if (empty($errors)) {
                $this->updateSupplier($id, $supplier_name, $phone, $email, $address);
                header('Location: ' . BASE_URL . '/admin/suppliers');
                exit();
            }
        }

        $supplier = $this->getSupplierById($id);
        include_once VIEW_PATH . 'admin/suppliers/edit.php';
    }

    private function updateSupplier($id, $supplier_name, $phone, $email, $address)
    {
        $stmt = $this->db->prepare("UPDATE suppliers SET supplier_name = :supplier_name, phone = :phone, email = :email, address = :address WHERE id = :id");
        $stmt->bindParam(':supplier_name', $supplier_name, \PDO::PARAM_STR);
        $stmt->bindParam(':phone', $phone, \PDO::PARAM_STR);
        $stmt->bindParam(':email', $email, \PDO::PARAM_STR);
        $stmt->bindParam(':address', $address, \PDO::PARAM_STR);
        $stmt->bindParam(':id', $id, \PDO::PARAM_INT);

        if ($stmt->execute()) {
            Session::set('message', ['success' => 'Cập nhật nhà cung cấp thành công!']);
            header('Location: ' . BASE_URL . '/admin/suppliers');
            exit();
        } else {
            echo "Đã xảy ra lỗi khi cập nhật nhà cung cấp.";
        }
    }
}
