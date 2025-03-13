<?php

namespace Core;

use Core\Database;

class Auth
{
    protected $db;

    public function __construct()
    {
        $this->db = Database::getInstance()->getConnection();

        // Bắt đầu phiên làm việc nếu chưa có
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    /**
     * Đăng nhập người dùng
     *
     * @param string $email
     * @param string $password
     * @return bool
     */
    public function login($email, $password)
    {
        // Truy vấn người dùng theo email
        $stmt = $this->db->prepare("select * from users where email=?");
        $stmt->execute([$email]);
        $user = $stmt->fetch(\PDO::FETCH_ASSOC);

        // Kiểm tra người dùng và xác minh mật khẩu
        if ($user && password_verify($password, $user['password'])) {

            Session::set('user', [
                'id' => $user['id'],
                'name' => $user['firstname'] . ' ' . $user['lastname'],
                'role' => $user['role'],
                'isfirstlogin' => $user['firstlogin']
            ]);
            // if ($user['role'] === 'customer') {
            // return $user;
            // }
            // Lưu thông tin người dùng vào session
        }

        return false;
    }

    /**
     * Kiểm tra người dùng đã đăng nhập
     *
     * @return bool
     */
    public function check()
    {
        return isset($_SESSION['user']);
    }

    /**
     * Lấy thông tin người dùng hiện tại
     *
     * @return array|null
     */
    public function user()
    {
        return $_SESSION['user'] ?? null;
    }

    /**
     * Đăng xuất người dùng
     */
    public function logout()
    {
        unset($_SESSION['user']);
        session_destroy();
    }

    /**
     * Kiểm tra quyền của người dùng
     *
     * @param string $role
     * @return bool
     */
    public function hasRole($role)
    {
        return isset($_SESSION['user']) && $_SESSION['user']['role'] === $role;
    }
}
