<?php

namespace App\Controllers\Admin;

use App\Controllers\Controller;

class OrderController extends Controller
{
    public function getAllOrders()
    {
        $currentPage = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
        $perPage = 15;
        $offset = ($currentPage - 1) * $perPage;

        $countQuery = "SELECT COUNT(*) AS sum FROM orders";
        $countResult = $this->db->query($countQuery);
        $totalOrders = $countResult->fetch_assoc()['sum'];

        $totalPages = ceil($totalOrders / $perPage);

        $query = "SELECT * FROM orders ORDER BY order_date DESC LIMIT $offset, $perPage";
        $result = $this->db->query($query);

        $orders = [];
        while ($row = $result->fetch_assoc()) {
            $orders[] = $row;
        }
        include_once VIEW_PATH . 'admin/orders/index.php';
    }

    public function getOrderDetail()
    {
        // Lấy order_id từ query string
        $order_id = isset($_GET['id']) ? $_GET['id'] : null;

        if ($order_id) {
            // Lấy thông tin đơn hàng
            $orderQuery = $this->db->prepare("SELECT * FROM orders WHERE order_id = ?");
            $orderQuery->bind_param('i', $order_id);
            $orderQuery->execute();
            $orderResult = $orderQuery->get_result();
            $order = $orderResult->fetch_assoc();

            // Nếu không tìm thấy đơn hàng
            if (!$order) {
                die("Không tìm thấy đơn hàng.");
            }

            // Lấy thông tin khách hàng
            $userQuery = $this->db->prepare("SELECT * FROM users WHERE user_id = ? AND role = 'customer'");
            $userQuery->bind_param('i', $order['user_id']);
            $userQuery->execute();
            $userResult = $userQuery->get_result();
            $user = $userResult->fetch_assoc();

            // Lấy chi tiết đơn hàng (sản phẩm đã đặt)
            $orderDetailsQuery = $this->db->prepare("SELECT od.order_detail_id, od.product_id, od.quantity, od.price, p.name AS product_name, p.image, p.price AS product_price
                                                 FROM order_details od
                                                 JOIN products p ON od.product_id = p.product_id
                                                 WHERE od.order_id = ?");
            $orderDetailsQuery->bind_param('i', $order_id);
            $orderDetailsQuery->execute();
            $orderDetailsResult = $orderDetailsQuery->get_result();
            $orderDetails = [];

            while ($detail = $orderDetailsResult->fetch_assoc()) {
                $orderDetails[] = $detail;
            }

            // Truyền dữ liệu cho view
            include_once VIEW_PATH . 'admin/orders/detail.php';
        } else {
            die("Không có mã đơn hàng.");
        }
    }
}
