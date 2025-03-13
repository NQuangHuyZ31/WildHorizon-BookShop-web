<?php

use Core\Router;

// API Controller
use App\Controllers\Api\LoginController as ApiLoginController;
use App\Controllers\Api\ProductController as ApiProductController;

// Use Controller
use App\Controllers\User\CartController;
use App\Controllers\User\HomeController;
use App\Controllers\User\FlashSaleController;
use App\Controllers\User\LoginController;


// Admin Controller
use App\Controllers\Admin\CatalogController;
use App\Controllers\Admin\ProductController;
use App\Controllers\Admin\DashboardController;
use App\Controllers\Admin\OrderController;
use App\Controllers\User\CategoryController;
use App\Controllers\User\CheckoutController;
use App\Controllers\User\ChiTietSanPhamController;
use App\Controllers\User\DanhSachSanPhamController;
use App\Controllers\User\FeedbackController;
// User Middleware
use App\Middleware\AuthMiddleware;
use App\Models\Cart;

// Khởi tạo đối tượng Router
$router = new Router();

// =============================================================ROUTER CUSTOMER==================================================
// Route đến trang chủ
$router->get('/', [HomeController::class, 'index']);

//Route Trang đăng nhập
$router->get('/dang-nhap', [LoginController::class, 'index']);
$router->post('/dang-nhap', [LoginController::class, 'handelLogin']);

// Route đến trang đăng ký
$router->get('/dang-ky', [LoginController::class, 'register']);
$router->post('/dang-ky', [LoginController::class, 'handleRegister']);

// Route Trang đăng xuất
$router->post('/dang-xuat', [LoginController::class, 'logout']);

// Route Trang feedback 
$router->get('/feedback', [FeedbackController::class, 'feedback'], [AuthMiddleware::class]);
$router->post('/feedback', [FeedbackController::class, 'handleFeedback']);

// Route trang flash sale
$router->get('/flash-sale', [FlashSaleController::class, 'index']);
$router->get('/loadmorefs', [FlashSaleController::class, 'loadMoreFlashSale']);

// Route trang giỏ hàng
$router->get('/gio-hang', [CartController::class, 'index']);
$router->post('/gio-hang/delete', [CartController::class, 'deleteProduct']);
$router->post('/addtocart', [CartController::class, 'addToCart']);
$router->post('/updatepricecart', [CartController::class, 'updatePriceCart']);
$router->post('/checkquantitycart', [CartController::class, 'checkQuantityCart']);
// Route trang danh sách sản phẩm
$router->get('/product', [DanhSachSanPhamController::class, 'index']);
$router->get('/loadmore', [DanhSachSanPhamController::class, 'loadMore']);

// Route đến danh mục sản phẩm
$router->get('/category/{slug}-{id}', [CategoryController::class, 'index']);

// Route trang chi tiết sản phẩm
$router->get('/product/{slug}-{id}', [ChiTietSanPhamController::class, 'index']);
$router->post('/savetempaddress', [ChiTietSanPhamController::class, 'savetempAddress']);
$router->post('/checkquantity', [ChiTietSanPhamController::class, 'checkQuantity']);

// Route đến trang checkout
$router->post('/checkout', [CheckoutController::class, 'index']);
$router->post('/saveorder', [CheckoutController::class, 'checkout']);

// ===========================================================ROUTER ADMIN==============================================================
// Route đến trang đăng nhập admin
$router->get('/admin/login', [DashboardController::class, 'login']);
$router->post('/admin/login', [DashboardController::class, 'login']);

// Route đến dashboard admin
$router->get('/dashboard', [DashboardController::class, 'index']);

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

// ===========================================API ROUTE=========================================================================
// $router->post('/v1/api/login', [ApiLoginController::class, 'handleLogin']);
// $router->get('/v1/api/product', [ApiProductController::class, 'getAll']);

// Xử lý request
$router->handleRequest();
