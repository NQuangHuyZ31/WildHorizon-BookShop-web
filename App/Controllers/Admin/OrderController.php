<?php

namespace App\Controllers\Admin;

use App\Controllers\Controller;
use Core\Encrypt;

class OrderController extends Controller
{
    public function getAllOrders()
    {
        $currentPage = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
        $perPage = 15;
        $offset = ($currentPage - 1) * $perPage;

        // Lấy từ khóa tìm kiếm (nếu có)
        $search = isset($_GET['search']) ? trim($_GET['search']) : '';

        // Đếm tổng số đơn hàng (có áp dụng tìm kiếm nếu có từ khóa)
        $countQuery = "SELECT COUNT(*) AS sum FROM orders WHERE order_id LIKE :search";
        $stmt = $this->db->prepare($countQuery);
        $searchParam = '%' . $search . '%';
        $stmt->bindParam(':search', $searchParam, \PDO::PARAM_STR);
        $stmt->execute();
        $totalOrders = $stmt->fetch(\PDO::FETCH_ASSOC)['sum'];

        $totalPages = ceil($totalOrders / $perPage);

        // Lấy danh sách đơn hàng (có áp dụng tìm kiếm nếu có từ khóa)
        $query = "SELECT * FROM orders WHERE order_id LIKE :search ORDER BY order_date DESC LIMIT :offset, :perPage";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':search', $searchParam, \PDO::PARAM_STR);
        $stmt->bindParam(':offset', $offset, \PDO::PARAM_INT);
        $stmt->bindParam(':perPage', $perPage, \PDO::PARAM_INT);
        $stmt->execute();

        $orders = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        include_once VIEW_PATH . 'admin/orders/index.php';
    }


    public function getOrderDetail()
    {
        // Lấy order_id từ query string
        $encryptedId = $_GET['id'] ?? null;
        $order_id = Encrypt::decryptId($encryptedId, KEY);

        if ($order_id) {
            // Lấy thông tin đơn hàng
            $orderQuery = "SELECT * FROM orders WHERE order_id = :order_id";
            $stmt = $this->db->prepare($orderQuery);
            $stmt->bindParam(':order_id', $order_id, \PDO::PARAM_INT);
            $stmt->execute();
            $order = $stmt->fetch(\PDO::FETCH_ASSOC);

            // Nếu không tìm thấy đơn hàng
            if (!$order) {
                die("Không tìm thấy đơn hàng.");
            }

            // Lấy thông tin khách hàng
            $userQuery = "SELECT * FROM users WHERE user_id = :user_id AND role = 'customer'";
            $stmt = $this->db->prepare($userQuery);
            $stmt->bindParam(':user_id', $order['user_id'], \PDO::PARAM_INT);
            $stmt->execute();
            $user = $stmt->fetch(\PDO::FETCH_ASSOC);

            // Lấy chi tiết đơn hàng (sản phẩm đã đặt)
            $orderDetailsQuery = "SELECT od.order_detail_id, od.product_id, od.quantity, od.price, p.name AS product_name, p.image, p.price AS product_price
                                  FROM order_details od
                                  JOIN products p ON od.product_id = p.product_id
                                  WHERE od.order_id = :order_id";
            $stmt = $this->db->prepare($orderDetailsQuery);
            $stmt->bindParam(':order_id', $order_id, \PDO::PARAM_INT);
            $stmt->execute();
            $orderDetails = $stmt->fetchAll(\PDO::FETCH_ASSOC);

            // Truyền dữ liệu cho view
            include_once VIEW_PATH . 'admin/orders/detail.php';
        } else {
            die("Không có mã đơn hàng.");
        }
    }
}
