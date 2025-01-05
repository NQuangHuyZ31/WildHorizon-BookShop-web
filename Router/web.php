<?php
use Core\Router;
// Use Controller
use App\Controllers\User\HomeController;

// User Middleware
use App\Middleware\AuthMiddleware;

// Khởi tạo đối tượng Router
$router = new Router();

// Route đến trang chủ
$router->get('/', [HomeController::class, 'index'],[AuthMiddleware::class]);

// Route đến trang đăng ký
$router->get('/dang-ky',[HomeController::class,'abc']);

// Xử lý request
$router->handleRequest();
