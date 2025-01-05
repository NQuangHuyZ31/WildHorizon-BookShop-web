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

// Nạp các route
require_once __DIR__ . '/Router/web.php';