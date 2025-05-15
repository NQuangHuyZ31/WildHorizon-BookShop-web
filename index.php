<?php

require_once 'Config/config.php';

ob_start(); // Bắt đầu output buffering

// Ẩn các lỗi Deprecated, Notice, Warning
error_reporting(E_ALL & ~E_DEPRECATED & ~E_NOTICE & ~E_WARNING);
ini_set('display_errors', 0); // Ngăn lỗi in ra màn hình

// Nếu cần log lỗi, bật log riêng (tùy chọn)
ini_set('log_errors', 1);
ini_set('error_log', 'data.log'); // Thư mục log tùy bạn
// ini_set('error_reporting', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

// Autoloader để tự động tải class
spl_autoload_register(function ($class) {
    $classPath = __DIR__ . '/' . str_replace('\\', '/', $class) . '.php';
    if (file_exists($classPath)) {
        require_once $classPath;
    } else {
        die("Không tìm thấy file: $classPath");
    }
});

// Cho phép mọi nguồn truy cập (hoặc thay thế bằng domain cụ thể)

header("Access-Control-Allow-Origin: *");
// header("Access-Control-Allow-Origin: https://wildhorizonbs.shoplands.store/");

// Cho phép các phương thức HTTP cụ thể
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");

// Cho phép các header cụ thể
header("Access-Control-Allow-Headers: Content-Type, Authorization");

// Xử lý yêu cầu OPTIONS (Preflight Request)
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

// Nạp các route
require_once __DIR__ . '/Router/web.php';
