<?php

namespace App\Controllers\Admin;

use Core\Session;
use Core\Encrypt;
use App\Controllers\Controller;

class FlashSaleAdminController extends Controller
{
    public function getAllFlashSales()
    {
        // Lấy trang hiện tại từ URL, mặc định là 1
        $currentPage = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;

        // Số flash sale mỗi trang
        $perPage = 7;

        // Tính toán offset
        $offset = ($currentPage - 1) * $perPage;

        // Lấy từ khóa tìm kiếm (nếu có)
        $search = isset($_GET['search']) ? trim($_GET['search']) : '';
        $searchParam = '%' . $search . '%';

        // Đếm tổng số flash sale phù hợp
        $countQuery = "SELECT COUNT(*) AS total 
                   FROM flashsales f 
                   JOIN products p ON f.product_id = p.id 
                   WHERE p.product_name LIKE :search";
        $stmt = $this->db->prepare($countQuery);
        $stmt->bindParam(':search', $searchParam, \PDO::PARAM_STR);
        $stmt->execute();
        $totalFlashSales = $stmt->fetch(\PDO::FETCH_ASSOC)['total'];

        // Tính tổng số trang
        $totalPages = ceil($totalFlashSales / $perPage);

        // Truy vấn dữ liệu + phân trang
        $query = "SELECT f.*, p.product_name, p.product_image 
              FROM flashsales f 
              JOIN products p ON f.product_id = p.id 
              WHERE p.product_name LIKE :search 
              ORDER BY f.start_date ASC 
              LIMIT :offset, :perPage";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':search', $searchParam, \PDO::PARAM_STR);
        $stmt->bindParam(':offset', $offset, \PDO::PARAM_INT);
        $stmt->bindParam(':perPage', $perPage, \PDO::PARAM_INT);
        $stmt->execute();
        $flashsales = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        include_once VIEW_PATH . 'admin/flashsales/index.php';
    }

    public function getAllProducts($includeId = null)
    {
        if ($includeId) {
            $query = "SELECT * FROM products 
                  WHERE (id NOT IN (SELECT product_id FROM flashsales) OR id = :includeId)
                  ORDER BY product_name ASC";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':includeId', $includeId, \PDO::PARAM_INT);
        } else {
            $query = "SELECT * FROM products 
                  WHERE id NOT IN (SELECT product_id FROM flashsales)
                  ORDER BY product_name ASC";
            $stmt = $this->db->prepare($query);
        }

        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }


    public function createFlashSale()
    {
        $errors = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Lấy dữ liệu từ form
            $product_id = $_POST['product_id'] ?? '';
            $discount_price = $_POST['discount_price'] ?? '';
            $quantity = $_POST['quantity'] ?? '';
            $start_date = $_POST['start_date'] ?? '';
            $end_date = $_POST['end_date'] ?? '';

            // Kiểm tra lỗi
            $errors = $this->validateFlashSaleData($product_id, $discount_price, $quantity, $start_date, $end_date);

            // Nếu không có lỗi thì lưu
            if (empty($errors)) {
                $this->saveFlashSale($product_id, $discount_price, $quantity, $start_date, $end_date);
                return;
            }
        }

        // Load danh sách sản phẩm để chọn trong form
        $products = $this->getAllProducts();

        // Hiển thị form thêm flash sale (truyền biến $errors và $products)
        include_once VIEW_PATH . 'admin/flashsales/create.php';
    }

    private function validateFlashSaleData($product_id, $discount_price, $quantity, $start_date, $end_date)
    {
        $errors = [];

        if (empty($product_id)) {
            $errors['product_id'] = 'Vui lòng chọn sản phẩm.';
        }

        if (!is_numeric($discount_price) || $discount_price <= 0 || $discount_price > 100) {
            $errors['discount_price'] = 'Phần trăm giảm giá phải nằm trong khoảng 1-100%.';
        }

        if (!is_numeric($quantity) || $quantity <= 0) {
            $errors['quantity'] = 'Số lượng phải là số dương.';
        }

        if (empty($start_date) || empty($end_date)) {
            $errors['date'] = 'Vui lòng chọn ngày bắt đầu và kết thúc.';
        } elseif ($start_date > $end_date) {
            $errors['date'] = 'Ngày bắt đầu không được lớn hơn ngày kết thúc.';
        }

        return $errors;
    }

    private function saveFlashSale($product_id, $discount_price, $quantity, $start_date, $end_date)
    {
        $stmt = $this->db->prepare("INSERT INTO flashsales (product_id, discount_price, quantity, start_date, end_date)
                                VALUES (:product_id, :discount_price, :quantity, :start_date, :end_date)");
        $stmt->bindParam(':product_id', $product_id, \PDO::PARAM_INT);
        $stmt->bindParam(':discount_price', $discount_price, \PDO::PARAM_STR);
        $stmt->bindParam(':quantity', $quantity, \PDO::PARAM_INT);
        $stmt->bindParam(':start_date', $start_date);
        $stmt->bindParam(':end_date', $end_date);

        if ($stmt->execute()) {
            Session::set('message', ['success' => 'Thêm flash sale thành công!']);
            header('Location: ' . BASE_URL . '/admin/flash-sales');
            exit();
        } else {
            echo "Đã xảy ra lỗi khi lưu flash sale.";
        }
    }

    public function deleteFlashSale()
    {
        $encryptedId = $_POST['id'] ?? null;
        $id = Encrypt::decryptId($encryptedId, KEY);
        if (!$id) {
            die("ID không hợp lệ.");
        }

        $stmt = $this->db->prepare("DELETE FROM flashsales WHERE id = :id");
        $stmt->bindParam(':id', $id, \PDO::PARAM_INT);

        if ($stmt->execute()) {
            Session::set('message', [
                'success' => 'Xóa flashsale thành công!'
            ]);
            header('Location: ' . BASE_URL . '/admin/flash-sales');
            exit(); // Kết thúc xử lý sau khi chuyển hướng
        } else {
            echo "Đã xảy ra lỗi khi xóa flashsale.";
        }

        // Chuyển hướng về danh sách danh mục
        header('Location: ' . BASE_URL . '/admin/flash-sales');
        exit();
    }

    public function editFlashSale()
    {
        $errors = [];

        $encryptedId = $_GET['id'] ?? null;
        $id = Encrypt::decryptId($encryptedId, KEY);
        if (!$id) {
            die("ID không hợp lệ.");
        }

        // Lấy flash sale hiện tại
        $stmt = $this->db->prepare("SELECT * FROM flashsales WHERE id = :id");
        $stmt->bindParam(':id', $id, \PDO::PARAM_INT);
        $stmt->execute();
        $flashsale = $stmt->fetch(\PDO::FETCH_ASSOC);

        if (!$flashsale) {
            echo "Flash sale không tồn tại.";
            return;
        }

        // Nếu submit form
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $product_id = $_POST['product_id'] ?? '';
            $discount_price = $_POST['discount_price'] ?? '';
            $quantity = $_POST['quantity'] ?? '';
            $start_date = $_POST['start_date'] ?? '';
            $end_date = $_POST['end_date'] ?? '';

            $errors = $this->validateFlashSaleData($product_id, $discount_price, $quantity, $start_date, $end_date);

            // Nếu không lỗi thì cập nhật
            if (empty($errors)) {
                $this->updateFlashSale($id, $product_id, $discount_price, $quantity, $start_date, $end_date);
                return;
            }

            // Nếu có lỗi thì cập nhật lại dữ liệu flashsale để đổ ra form
            $flashsale = [
                'product_id'      => $product_id,
                'discount_price'  => $discount_price,
                'quantity'        => $quantity,
                'start_date'      => $start_date,
                'end_date'        => $end_date,
            ];
        }

        // Danh sách sản phẩm (bao gồm sản phẩm hiện tại)
        $products = $this->getAllProducts($flashsale['product_id']);

        // Gán product_name nếu chưa có
        if (!isset($flashsale['product_name'])) {
            foreach ($products as $product) {
                if ($product['id'] == $flashsale['product_id']) {
                    $flashsale['product_name'] = $product['product_name'];
                    break;
                }
            }
        }

        include_once VIEW_PATH . 'admin/flashsales/edit.php';
    }


    private function updateFlashSale($id, $product_id, $discount_price, $quantity, $start_date, $end_date)
    {
        $stmt = $this->db->prepare("
        UPDATE flashsales 
            SET product_id = :product_id,
                discount_price = :discount_price,
                quantity = :quantity,
                start_date = :start_date,
                end_date = :end_date
            WHERE id = :id
        ");

        $stmt->bindParam(':product_id', $product_id, \PDO::PARAM_INT);
        $stmt->bindParam(':discount_price', $discount_price, \PDO::PARAM_STR);
        $stmt->bindParam(':quantity', $quantity, \PDO::PARAM_INT);
        $stmt->bindParam(':start_date', $start_date);
        $stmt->bindParam(':end_date', $end_date);
        $stmt->bindParam(':id', $id, \PDO::PARAM_INT);

        if ($stmt->execute()) {
            Session::set('message', ['success' => 'Cập nhật flash sale thành công!']);
            header('Location: ' . BASE_URL . '/admin/flash-sales');
            exit();
        } else {
            echo "Đã xảy ra lỗi khi cập nhật flash sale.";
        }
    }
}
