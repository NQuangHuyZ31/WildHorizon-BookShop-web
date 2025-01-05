<?php
namespace Core;

class Session {
    // Khởi tạo session
    public static function start() {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
    }

    // Lưu dữ liệu vào session
    public static function set($key, $value) {
        self::start();
        $_SESSION[$key] = $value;
    }

    // Lấy dữ liệu từ session
    public static function get($key) {
        self::start();
        return isset($_SESSION[$key]) ? $_SESSION[$key] : null;
    }

    // Kiểm tra sự tồn tại của session
    public static function has($key) {
        self::start();
        return isset($_SESSION[$key]);
    }

    // Xóa dữ liệu khỏi session
    public static function delete($key) {
        self::start();
        if (self::has($key)) {
            unset($_SESSION[$key]);
        }
    }

    // Hủy toàn bộ session
    public static function destroy() {
        self::start();
        session_unset();
        session_destroy();
    }
}
?>
