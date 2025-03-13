<?php

namespace App\Controllers\Admin;

use Core\Session;
use Core\Encrypt;
use App\Controllers\Controller;

class ProductAttributeController extends Controller
{
    public function getAllAttributes()
    {
        // Lấy trang hiện tại từ URL, mặc định là 1
        $currentPage = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;

        // Số thuộc tính mỗi trang
        $perPage = 15;

        // Tính toán offset
        $offset = ($currentPage - 1) * $perPage;

        // Lấy từ khóa tìm kiếm (nếu có)
        $search = isset($_GET['search']) ? trim($_GET['search']) : '';

        // Truy vấn để lấy tổng số thuộc tính (có áp dụng tìm kiếm)
        $countQuery = "
        SELECT COUNT(*) AS total 
        FROM product_attributes pa
        JOIN products p ON pa.product_id = p.id
        WHERE p.product_name LIKE :search OR pa.attr_name LIKE :search
    ";
        $stmt = $this->db->prepare($countQuery);
        $searchParam = '%' . $search . '%';
        $stmt->bindParam(':search', $searchParam, \PDO::PARAM_STR);
        $stmt->execute();
        $totalAttributes = $stmt->fetch(\PDO::FETCH_ASSOC)['total'];

        // Tính tổng số trang
        $totalPages = ceil($totalAttributes / $perPage);

        // Truy vấn lấy thuộc tính có áp dụng tìm kiếm và phân trang
        $query = "
        SELECT 
            pa.id, 
            p.product_name, 
            pa.attr_name, 
            pa.attr_value 
        FROM 
            product_attributes pa
        JOIN 
            products p ON pa.product_id = p.id
        WHERE p.product_name LIKE :search OR pa.attr_name LIKE :search
        LIMIT :perPage OFFSET :offset
    ";

        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':search', $searchParam, \PDO::PARAM_STR);
        $stmt->bindParam(':perPage', $perPage, \PDO::PARAM_INT);
        $stmt->bindParam(':offset', $offset, \PDO::PARAM_INT);
        $stmt->execute();

        $attributes = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        // Truyền dữ liệu vào view
        include_once VIEW_PATH . 'admin/product-attributes/index.php';
    }


    private function getAttributeById($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM product_attributes WHERE id = :id");
        $stmt->bindParam(':id', $id, \PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    private function getAllProducts()
    {
        $stmt = $this->db->prepare("SELECT * FROM products");
        $stmt->execute();
        $products = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        return $products;
    }
    public function createAttribute()
    {
        $products = $this->getAllProducts();
        $errors = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $product_id = $_POST['product_id'] ?? '';
            $attr_names = $_POST['attr_name'] ?? [];
            $attr_values = $_POST['attr_value'] ?? [];

            if (empty($product_id)) {
                $errors['product_id'] = 'Vui lòng chọn sản phẩm!';
            }

            // Kiểm tra xem có ít nhất một cặp thuộc tính hợp lệ không
            $hasValidAttributes = false;

            foreach ($attr_names as $index => $attr_name) {
                $attr_value = $attr_values[$index] ?? '';

                if (!empty($attr_name) && !empty($attr_value)) {
                    $hasValidAttributes = true;
                } else {
                    if (empty($attr_name)) {
                        $errors['attr_name'][$index] = "Tên thuộc tính không được để trống!";
                    }
                    if (empty($attr_value)) {
                        $errors['attr_value'][$index] = "Giá trị không được để trống!";
                    }
                }
            }

            if (!$hasValidAttributes) {
                $errors['general'] = "Bạn phải nhập ít nhất một cặp thuộc tính hợp lệ!";
            }

            if (empty($errors)) {
                foreach ($attr_names as $index => $attr_name) {
                    $attr_value = $attr_values[$index] ?? '';

                    if (!empty($attr_name) && !empty($attr_value)) {
                        $this->saveAttribute($product_id, $attr_name, $attr_value);
                    }
                }

                Session::set('message', ['success' => 'Thêm thuộc tính sản phẩm thành công!']);
                header('Location: ' . BASE_URL . '/admin/product-attributes');
                exit();
            }
        }

        include_once VIEW_PATH . 'admin/product-attributes/create.php';
    }

    private function saveAttribute($product_id, $attr_name, $attr_value)
    {
        $stmt = $this->db->prepare("INSERT INTO product_attributes (product_id, attr_name, attr_value) VALUES (:product_id, :attr_name, :attr_value)");
        $stmt->bindParam(':product_id', $product_id, \PDO::PARAM_INT);
        $stmt->bindParam(':attr_name', $attr_name, \PDO::PARAM_STR);
        $stmt->bindParam(':attr_value', $attr_value, \PDO::PARAM_STR);
        $stmt->execute();
    }

    public function deleteAttribute()
    {
        $encryptedId = $_POST['id'] ?? null;
        $id = Encrypt::decryptId($encryptedId, KEY);
        if (!$id) {
            die("ID không hợp lệ.");
        }

        $stmt = $this->db->prepare("DELETE FROM product_attributes WHERE id = :id");
        $stmt->bindParam(':id', $id, \PDO::PARAM_INT);

        if ($stmt->execute()) {
            Session::set('message', ['success' => 'Xóa thuộc tính thành công!']);
            header('Location: ' . BASE_URL . '/admin/product-attributes');
            exit();
        } else {
            echo "Lỗi khi xóa thuộc tính.";
        }
    }

    // public function editAttribute()
    // {
    //     $errors = [];
    //     $encryptedId = $_GET['id'] ?? null;
    //     $id = Encrypt::decryptId($encryptedId, KEY);
    //     if (!$id) {
    //         die("ID không hợp lệ.");
    //     }

    //     if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    //         $product_id = $_POST['product_id'] ?? '';
    //         $attr_name = $_POST['attr_name'] ?? '';
    //         $attr_value = $_POST['attr_value'] ?? '';



    //         if (empty($errors)) {
    //             $this->updateAttribute($id, $product_id, $attr_name, $attr_value);
    //             return;
    //         }
    //     }

    //     $attribute = $this->getAttributeById($id);
    //     include_once VIEW_PATH . 'admin/product-attributes/edit.php';
    // }

    // private function updateAttribute($id, $product_id, $attr_name, $attr_value)
    // {
    //     $stmt = $this->db->prepare("UPDATE product_attributes SET product_id = :product_id, attr_name = :attr_name, attr_value = :attr_value WHERE id = :id");
    //     $stmt->bindParam(':product_id', $product_id, \PDO::PARAM_INT);
    //     $stmt->bindParam(':attr_name', $attr_name, \PDO::PARAM_STR);
    //     $stmt->bindParam(':attr_value', $attr_value, \PDO::PARAM_STR);
    //     $stmt->bindParam(':id', $id, \PDO::PARAM_INT);

    //     if ($stmt->execute()) {
    //         Session::set('message', ['success' => 'Cập nhật thuộc tính thành công!']);
    //         header('Location: ' . BASE_URL . '/admin/product-attributes');
    //         exit();
    //     } else {
    //         echo "Lỗi khi cập nhật thuộc tính.";
    //     }
    // }
    public function updateAttribute()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = \Core\Encrypt::decryptId($_POST['id'], KEY);
            $name = trim($_POST['edit_name']);
            $value = trim($_POST['edit_value']);

            if (!$id || empty($name) || empty($value)) {
                Session::set('message', ['error' => 'Vui lòng điền đầy đủ thông tin.']);
                header("Location: " . BASE_URL_NAME . "/admin/product-attributes");
                exit;
            }

            // Kết nối database
            $stmt = $this->db->prepare("UPDATE product_attributes SET attr_name = :edit_name, attr_value = :edit_value WHERE id = :id");

            // Bind giá trị
            $stmt->bindParam(':edit_name', $name, \PDO::PARAM_STR);
            $stmt->bindParam(':edit_value', $value, \PDO::PARAM_STR);
            $stmt->bindParam(':id', $id, \PDO::PARAM_INT);

            // Thực thi truy vấn
            if ($stmt->execute()) {
                Session::set('message', ['success' => 'Cập nhật thuộc tính thành công!']);
            } else {
                Session::set('message', ['error' => 'Có lỗi xảy ra khi cập nhật.']);
            }

            // Chuyển hướng về trang danh sách thuộc tính
            $page = $_GET['page'] ?? 1;
            header("Location: " . BASE_URL_NAME . "/admin/product-attributes?page=" . $page);
            exit;
        }
    }
}
