<?php

// Use Controller

use App\Controllers\User\CartController;
use App\Controllers\User\DanhSachSanPhamController;
use App\Controllers\User\HomeController;
use App\Controllers\User\FlashSaleController;
use App\Controllers\User\LoginController;
use Core\Router;


// User Middleware
use App\Middleware\AuthMiddleware;

// Khởi tạo đối tượng Router
$router = new Router();

// Route đến trang chủ
$router->get('/', [HomeController::class, 'index'],[AuthMiddleware::class]);

// Route đến trang đăng ký
$router->get('/dang-ky',[LoginController::class,'register']);
$router->post('/dang-ky',[LoginController::class,'handleRegister']);

//Route Trang đăng nhập
$router->get('/dang-nhap',[LoginController::class,'index']);
$router->post('/dang-nhap',[LoginController::class,'handelLogin']);

// Route Trang đăng xuất
$router->post('/dang-xuat',[LoginController::class,'logout']);

// Route Trang feedback 
$router->get('/feedback',[HomeController::class,'feedback']);
$router->post('/feedback',[HomeController::class,'handleFeedback']);
// Route trang flash sale
$router->get('/flash-sale',[FlashSaleController::class,'index']);

// Route trang giỏ hàng
$router->get('/gio-hang',[CartController::class,'index']);

// Route trang danh sách sản phẩm
$router->get('/san-pham',[DanhSachSanPhamController::class,'index']);
// Xử lý request
$router->handleRequest();
