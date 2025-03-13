<?php
require_once 'config/config.php';
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

// header("Access-Control-Allow-Origin: *");

// // Cho phép các phương thức HTTP cụ thể
// header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");

// // Cho phép các header cụ thể
// header("Access-Control-Allow-Headers: Content-Type, Authorization");

// Xử lý yêu cầu OPTIONS (Preflight Request)
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

// Nạp các route
require_once __DIR__ . '/Router/web.php';
