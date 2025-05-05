<?php

namespace App\Controllers\Admin;

use App\Controllers\Controller;
use App\Models\Order;
use Core\Encrypt;
use Core\Session;

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
        $countQuery = "SELECT COUNT(*) AS sum FROM orders WHERE id LIKE :search";
        $stmt = $this->db->prepare($countQuery);
        $searchParam = '%' . $search . '%';
        $stmt->bindParam(':search', $searchParam, \PDO::PARAM_STR);
        $stmt->execute();
        $totalOrders = $stmt->fetch(\PDO::FETCH_ASSOC)['sum'];

        $totalPages = ceil($totalOrders / $perPage);

        // Lấy danh sách đơn hàng (có áp dụng tìm kiếm nếu có từ khóa)
        $query = "
            SELECT orders.*, users.username AS username
            FROM orders
            JOIN users ON orders.user_id = users.id
            WHERE orders.id LIKE :search
            ORDER BY orders.order_date DESC
            LIMIT :offset, :perPage
        ";

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
            $orderQuery = "SELECT * FROM orders WHERE id = :order_id";
            $stmt = $this->db->prepare($orderQuery);
            $stmt->bindParam(':order_id', $order_id, \PDO::PARAM_INT);
            $stmt->execute();
            $order = $stmt->fetch(\PDO::FETCH_ASSOC);

            // Nếu không tìm thấy đơn hàng
            if (!$order) {
                die("Không tìm thấy đơn hàng.");
            }

            // Lấy thông tin khách hàng
            $userQuery = "SELECT * FROM users WHERE id = :user_id AND role = 'customer'";
            $stmt = $this->db->prepare($userQuery);
            $stmt->bindParam(':user_id', $order['user_id'], \PDO::PARAM_INT);
            $stmt->execute();
            $user = $stmt->fetch(\PDO::FETCH_ASSOC);

            // Lấy chi tiết đơn hàng (sản phẩm đã đặt)
            $orderDetailsQuery = "SELECT 
                                    od.id AS order_detail_id,
                                    od.product_id,
                                    od.quantity,
                                    od.price,
                                    od.total,
                                    p.product_name,
                                    p.product_image,
                                    p.price AS product_price,
                                    p.discount_price
                                  FROM order_details od
                                  JOIN products p ON od.product_id = p.id
                                  WHERE od.order_id = :order_id";
            $stmt = $this->db->prepare($orderDetailsQuery);
            $stmt->bindParam(':order_id', $order_id, \PDO::PARAM_INT);
            $stmt->execute();
            $orderDetails = $stmt->fetchAll(\PDO::FETCH_ASSOC);

            // Lấy thông tin địa chỉ giao hàng
            $shippingQuery = "SELECT * FROM order_shipping_addresses WHERE order_id = :order_id";
            $stmt = $this->db->prepare($shippingQuery);
            $stmt->bindParam(':order_id', $order_id, \PDO::PARAM_INT);
            $stmt->execute();
            $shippingAddress = $stmt->fetch(\PDO::FETCH_ASSOC);

            // Truyền dữ liệu cho view
            include_once VIEW_PATH . 'admin/orders/detail.php';
        } else {
            die("Không có mã đơn hàng.");
        }
    }

    public function updateOrderStatus()
    {
        $encryptedId = $_POST['order_id'] ?? null;
        $order_id = Encrypt::decryptId($encryptedId, KEY);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $status = $_POST['status'] ?? null;

            // Lấy trạng thái hiện tại của đơn hàng
            $query = "SELECT status FROM orders WHERE id = :order_id";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':order_id', $order_id, \PDO::PARAM_INT);
            $stmt->execute();
            $currentStatus = $stmt->fetch(\PDO::FETCH_ASSOC)['status'];

            // Nếu đơn đã "Đã giao hàng", thì không cho cập nhật nữa
            if ($currentStatus === 'Đã giao hàng') {
                Session::set('message', [
                    'error' => 'Đơn hàng đã giao thành công, không thể thay đổi trạng thái!'
                ]);
                $page = $_POST['page'] ?? 1;
                header("Location: " . BASE_URL . "/admin/orders?page=" . $page);
                exit;
            }

            // Nếu chưa "Đã giao", cho phép cập nhật
            $updateQuery = "UPDATE orders SET status = :status WHERE id = :order_id";
            $stmt = $this->db->prepare($updateQuery);
            $stmt->bindParam(':status', $status, \PDO::PARAM_STR);
            $stmt->bindParam(':order_id', $order_id, \PDO::PARAM_INT);

            if ($status && $status === 'Đã giao hàng') {
                $order = new Order();
                $order->updateColumn($order_id, 'is_payment', 1);
            }

            if ($stmt->execute()) {
                Session::set('message', [
                    'success' => 'Cập nhật trạng thái đơn hàng thành công!'
                ]);
            } else {
                echo "Đã xảy ra lỗi khi cập nhật trạng thái đơn hàng.";
            }

            $page = $_POST['page'] ?? 1;
            header("Location: " . BASE_URL . "/admin/orders?page=" . $page);
            exit;
        }
    }
}
