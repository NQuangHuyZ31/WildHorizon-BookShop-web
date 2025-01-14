<?php

use App\Controllers\Admin\CatalogController;
use App\Controllers\Admin\ProductController;
use Core\Router;
// Use Controller
use App\Controllers\User\HomeController;
use App\Controllers\Admin\DashboardController;
use App\Controllers\Admin\OrderController;

// User Middleware
use App\Middleware\AuthMiddleware;

// Khởi tạo đối tượng Router
$router = new Router();

// Route đến trang chủ
$router->get('/', [HomeController::class, 'index'],[AuthMiddleware::class]);

// Route đến trang đăng ký
$router->get('/dang-ky',[HomeController::class,'abc']);


// Route đến trang đăng nhập admin
$router->get('/admin/login', [DashboardController::class, 'login']);
$router->post('/admin/login', [DashboardController::class, 'login']);

// Route đến dashboard admin
$router->get('/dashboard', [DashboardController::class, 'index'],[AuthMiddleware::class]);

// Route đăng xuất
$router->get('/admin/logout', [DashboardController::class, 'logout']);

// Route quản trị sản phẩm
$router->get('/admin/products', [ProductController::class, 'getAllProducts']);
$router->get('/admin/products/create', [ProductController::class, 'createProduct']);
$router->post('/admin/products/create', [ProductController::class, 'createProduct']);
$router->post('/admin/products/delete', [ProductController::class, 'deleteProduct']);
$router->get('/admin/products/edit', [ProductController::class, 'editProduct']);
$router->post('/admin/products/edit', [ProductController::class, 'editProduct']);

// Route quản trị danh mục 
$router->get('/admin/catalogs', [CatalogController::class, 'getAllCatalogs']);
$router->get('/admin/catalogs/create', [CatalogController::class, 'createCatalog']);
$router->post('/admin/catalogs/create', [CatalogController::class, 'createCatalog']);
$router->post('/admin/catalogs/delete', [CatalogController::class, 'deleteCatalog']);
$router->get('/admin/catalogs/edit', [CatalogController::class, 'editCatalog']);
$router->post('/admin/catalogs/edit', [CatalogController::class, 'editCatalog']);

// Route quản trị đơn hàng
$router->get('/admin/orders', [OrderController::class, 'getAllOrders']);
$router->get('/admin/orders/detail', [OrderController::class, 'getOrderDetail']);
// Xử lý request
$router->handleRequest();
