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

        // Tổng số người dùng với vai trò 'customer'
        $stmt = $this->db->prepare("SELECT COUNT(*) as count FROM users WHERE role = :role");
        $stmt->execute(['role' => 'customer']);
        $totalCustomers = $stmt->fetch(\PDO::FETCH_ASSOC)['count'];

        // Tổng số sản phẩm
        $stmt = $this->db->prepare("SELECT COUNT(*) as count FROM products");
        $stmt->execute();
        $totalProducts = $stmt->fetch(\PDO::FETCH_ASSOC)['count'];

        // Tổng số đơn hàng với trạng thái 'Chờ xác nhận'
        $stmt = $this->db->prepare("SELECT COUNT(*) as count FROM orders WHERE status = :status");
        $stmt->execute(['status' => 'Chờ xác nhận']);
        $pendingOrders = $stmt->fetch(\PDO::FETCH_ASSOC)['count'];

        // Truyền dữ liệu vào view
        include_once VIEW_PATH . 'admin/index.php';
    }

    
    public function login()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'];
            $password = $_POST['password'];

            // Sử dụng chuẩn bị truy vấn để tránh SQL injection
            $stmt = $this->db->prepare("SELECT * FROM users WHERE email = :email");
            $stmt->bindParam(':email', $email, \PDO::PARAM_STR);  // 's' đại diện cho kiểu dữ liệu string
            $stmt->execute();

            // Lấy kết quả
            $user = $stmt->fetch(\PDO::FETCH_ASSOC);

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
