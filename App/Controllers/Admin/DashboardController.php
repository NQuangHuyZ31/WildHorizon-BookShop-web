<?php
namespace App\Controllers\Admin;
use Core\Session;
use App\Controllers\Controller;

class DashboardController extends Controller
{
    private function authenticate()
    {
        // Kiểm tra nếu session không có thông tin người dùng
        if (!Session::has('admin') || Session::get('admin')['role'] !== 'admin') {
            // Chuyển hướng đến trang đăng nhập
            header('Location: ' . BASE_URL . '/admin/login');
            exit;
        }
    }

    public function index()
    {
        $this->authenticate();
        // Tổng số người dùng với role là 'customer'
        $result = $this->db->query("SELECT COUNT(*) as count FROM users WHERE role = 'customer'");
        $totalCustomers = $result->fetch_assoc()['count'];

        // Tổng số sản phẩm
        $result = $this->db->query("SELECT COUNT(*) as count FROM products");
        $totalProducts = $result->fetch_assoc()['count'];

        // Tổng số đơn hàng với trạng thái 'Chờ xác nhận'
        $result = $this->db->query("SELECT COUNT(*) as count FROM orders WHERE status = 'Chờ xác nhận'");
        $pendingOrders = $result->fetch_assoc()['count'];

        // Truyền dữ liệu vào view
        include_once VIEW_PATH . 'admin/index.php';
    }
    
    public function login()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'];
            $password = $_POST['password'];

            // Sử dụng chuẩn bị truy vấn để tránh SQL injection
            $stmt = $this->db->prepare("SELECT * FROM users WHERE email = ?");
            $stmt->bind_param("s", $email);  // 's' đại diện cho kiểu dữ liệu string
            $stmt->execute();

            // Lấy kết quả
            $result = $stmt->get_result();
            $user = $result->fetch_assoc();

            if ($user && password_verify($password, $user['password'])) {
                // Kiểm tra nếu role của người dùng là 'admin'
                if ($user['role'] === 'admin') {
                    // Đăng nhập thành công, lưu thông tin người dùng vào session
                    Session::set('admin', [
                        'id' => $user['id'],
                        'name' => $user['name'],
                        'email' => $user['email'],
                        'role' => $user['role']
                    ]);

                    // Chuyển hướng tới trang dashboard
                    header('Location: ' . BASE_URL . '/dashboard');
                    exit;
                } else {
                    // Nếu không phải admin, thông báo lỗi
                    Session::set('message', [
                        'error' => 'Bạn không có quyền truy cập vào trang này!'
                    ]);
                    header('Location: ' . BASE_URL . '/admin/login');
                    exit;
                }
            } else {
                // Đăng nhập thất bại, thông báo lỗi
                Session::set('message', [
                    'error' => 'Email hoặc mật khẩu không chính xác!'
                ]);
                header('Location: ' . BASE_URL . '/admin/login');
                exit;
            }
        }

        // Nếu không phải POST, chỉ hiển thị form đăng nhập
        include_once VIEW_PATH . 'admin/login.php';
    }

    public function logout()
    {
        Session::delete('admin');
        header('Location: ' . BASE_URL . '/admin/login');
        exit;
    }
}
