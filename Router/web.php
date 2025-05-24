<?php

use App\Controllers\Admin\BannerAdvertistingController;
use Core\Router;

// API Controller
use App\Controllers\Api\LoginController as ApiLoginController;
use App\Controllers\Api\ProductController as ApiProductController;

// Admin Controller
use App\Controllers\Admin\CatalogController;
use App\Controllers\Admin\ProductController;
use App\Controllers\Admin\ProductAttributeController;
use App\Controllers\Admin\DashboardController;
use App\Controllers\Admin\OrderController;
use App\Controllers\Admin\ReviewController;
use App\Controllers\Admin\BrandController;
use App\Controllers\Admin\SupplierController;
use App\Controllers\Admin\FlashSaleAdminController;
use App\Controllers\Admin\UserFeedBackController;
use App\Controllers\TestController;
// Use Controller
use App\Controllers\User\CartController;
use App\Controllers\User\HomeController;
use App\Controllers\User\FlashSaleController;
use App\Controllers\User\Aut;
use App\Controllers\User\AuthController;
use App\Controllers\User\CategoryController;
use App\Controllers\User\CheckoutController;
use App\Controllers\User\ChiTietSanPhamController;
use App\Controllers\User\DanhSachSanPhamController;
use App\Controllers\User\FeedbackController;
use App\Controllers\User\Customer_Account\AccountController;
use App\Controllers\User\Customer_Account\CustomerAddressController;
use App\Controllers\User\Customer_Account\CustomerChangePasswordController;
use App\Controllers\User\Customer_Account\CustomerOrderController;
use App\Controllers\User\Customer_Account\CustomerReviewController;
use App\Controllers\User\Customer_Account\CustomerSpecialEventController;
use App\Controllers\User\Customer_Account\CustomerVoucherController;
use App\Controllers\User\Customer_Account\CustomerWishListController;
use App\Controllers\User\IntroduceController;
use App\Controllers\User\LoginFacebookController;
use App\Controllers\User\LoginGoogleController;
use App\Controllers\User\VoucherController;
use App\Middleware\AuthAdminMiddleware;
// User Middleware
use App\Middleware\AuthMiddleware;
use App\Middleware\BlockMiddleware;

// Khởi tạo đối tượng Router
$router = new Router();

// =============================================================ROUTER CUSTOMER==================================================
// Route đến trang chủ
$router->get('/', [HomeController::class, 'index']);

//Route Trang đăng nhập
$router->get('/dang-nhap', [AuthController::class, 'index']);
$router->post('/dang-nhap', [AuthController::class, 'handelLogin']);

// Route đến Login Facebook
$router->get('/dang-nhap/facebook', [LoginFacebookController::class, 'redirectToFacebook']);
$router->get('/fb-callback', [LoginFacebookController::class, 'handleFacebookCallback']);

// Route đến trang Login Google
$router->get('/dang-nhap/google', [LoginGoogleController::class, 'redirectToGoogle']);
$router->get('/dang-nhap/google-callback', [LoginGoogleController::class, 'handleGoogleCallback']);

// Route đến trang đăng ký
$router->get('/dang-ky', [AuthController::class, 'register']);
$router->post('/dang-ky', [AuthController::class, 'handleRegister']);
$router->get('/dang-ky/verify-account', [AuthController::class, 'showVerifyAccount']);
$router->post('/dang-ky/verify-account', [AuthController::class, 'verifyAccount']);
$router->post('/dang-ky/verify-account/resend', [AuthController::class, 'resendOTP']);

// Route Trang đăng xuất
$router->post('/dang-xuat', [AuthController::class, 'logout'], [AuthMiddleware::class]);

// Route trang loadmore trang homepage
$router->get('/homepage/product/loadmore', [HomeController::class, 'loadMore']);

// Route đến trang giới thiệu
$router->get('/gioi-thieu', [IntroduceController::class, 'index']);

// Route Trang feedback 
$router->get('/feedback', [FeedbackController::class, 'feedback'], [AuthMiddleware::class]);
$router->post('/feedback', [FeedbackController::class, 'handleFeedback'], [AuthMiddleware::class]);
$router->get('/feedback/answer', [FeedbackController::class, 'feedbackAnswer'], [AuthMiddleware::class]);

// Route Trang voucher
$router->get('/voucher', [VoucherController::class, 'index']);
$router->post('/voucher/save', [VoucherController::class, 'saveVoucher'], [AuthMiddleware::class]);

// Route trang flash sale
$router->get('/flash-sale', [FlashSaleController::class, 'index']);
$router->get('/loadmorefs', [FlashSaleController::class, 'loadMoreFlashSale']);

// Route trang giỏ hàng
$router->get('/gio-hang', [CartController::class, 'index']);
$router->post('/gio-hang/delete', [CartController::class, 'deleteProduct']);
$router->post('/addtocart', [CartController::class, 'addToCart']);
$router->post('/updatepricecart', [CartController::class, 'updatePriceCart'], [AuthMiddleware::class]);
$router->post('/checkquantitycart', [CartController::class, 'checkQuantityCart'], [AuthMiddleware::class]);

// Route trang danh sách sản phẩm
$router->get('/product', [DanhSachSanPhamController::class, 'index']);
$router->get('/product/loadmoreproduct', [DanhSachSanPhamController::class, 'loadmoreProduct']);
$router->get('/product/search-filter', [DanhSachSanPhamController::class, 'searchFilter']);

// Route đến danh mục sản phẩm
$router->get('/category/{slug}-{id}', [CategoryController::class, 'index']);

// Route trang chi tiết sản phẩm
$router->get('/product/{slug}-{id}', [ChiTietSanPhamController::class, 'index']);
$router->post('/savetempaddress', [ChiTietSanPhamController::class, 'savetempAddress']);
$router->post('/checkquantity', [ChiTietSanPhamController::class, 'checkQuantity']);

// Route đến trang checkout
$router->post('/checkout/process', [CheckoutController::class, 'chekoutProcess'], [AuthMiddleware::class]);
$router->get('/checkout', [CheckoutController::class, 'index'], [AuthMiddleware::class]);
$router->post('/checkout/addnewaddress', [CheckoutController::class, 'addNewAddressCheckout'], [AuthMiddleware::class]);
$router->post('/checkout/getaddress', [CheckoutController::class, 'getAddressCheckout'], [AuthMiddleware::class]);
$router->post('/checkout/delete', [CheckoutController::class, 'deleteAddressCheckout'], [AuthMiddleware::class]);
$router->post('/saveorder', [CheckoutController::class, 'checkout']);
$router->post('/checkout/vnpay/checkout_again/{id}', [CheckoutController::class, 'vnPayCheckoutAgain'], [AuthMiddleware::class]);
$router->get('/checkout/vnpay/return', [CheckoutController::class, 'vnPayReturn'], [AuthMiddleware::class]);

// Route đến trang customer
$router->get('/customer/account', [AccountController::class, 'index'], [AuthMiddleware::class]);
$router->post('/customer/account', [AccountController::class, 'updateInfo'], [AuthMiddleware::class]);

$router->get('/customer/address', [CustomerAddressController::class, 'index'], [AuthMiddleware::class]);
$router->get('/customer/address/add', [CustomerAddressController::class, 'showPageAddNew'], [AuthMiddleware::class]);
$router->post('/customer/address/add', [CustomerAddressController::class, 'addNewAddress'], [AuthMiddleware::class]);
$router->post('/customer/address/delete', [CustomerAddressController::class, 'deleteAddress'], [AuthMiddleware::class]);
$router->get('/customer/address/edit/{id}', [CustomerAddressController::class, 'showPageEditAddress'], [AuthMiddleware::class]);
$router->post('/customer/address/edit', [CustomerAddressController::class, 'updateAddress'], [AuthMiddleware::class]);

$router->get('/customer/changepassword', [CustomerChangePasswordController::class, 'index'], [AuthMiddleware::class]);
$router->post('/customer/changepassword/sendmailverify', [CustomerChangePasswordController::class, 'sendCodeVerifyChangePW'], [AuthMiddleware::class]);
$router->get('/customer/changepassword/verify', [CustomerChangePasswordController::class, 'showChangePWVerifyPage'], [AuthMiddleware::class]);
$router->post('/customer/changepassword/verify', [CustomerChangePasswordController::class, 'verifyChangePassword'], [AuthMiddleware::class]);
$router->post('/customer/changepassword/verify/resend', [CustomerChangePasswordController::class, 'reSendOTP'], [AuthMiddleware::class]);

// $router->get('/customer/specialevent', [CustomerSpecialEventController::class, 'index'], [AuthMiddleware::class]);
// $router->get('/customer/specialevent/{slug}', [CustomerSpecialEventController::class, 'showEventDeTailPage'], [AuthMiddleware::class]);

$router->get('/customer/order', [CustomerOrderController::class, 'index'], [AuthMiddleware::class]);
$router->get('/customer/order/detail/{id}', [CustomerOrderController::class, 'showOrderDetailPage'], [AuthMiddleware::class]);
$router->get('/customer/order/getorder', [CustomerOrderController::class, 'getOrderInfo', [AuthMiddleware::class]]);
$router->post('/customer/order/savereview', [CustomerOrderController::class, 'saveReview'], [AuthMiddleware::class]);
$router->get('/customer/order/getproductreview', [CustomerReviewController::class, 'getProductReview', [AuthMiddleware::class]]);

$router->get('/customer/voucher', [CustomerVoucherController::class, 'index'], [AuthMiddleware::class]);
$router->get('/customer/wishlist', [CustomerWishListController::class, 'index'], [AuthMiddleware::class]);
$router->get('/customer/review', [CustomerReviewController::class, 'index'], [AuthMiddleware::class]);


// ===========================================================ROUTER ADMIN==============================================================
// Route đến trang đăng nhập admin
$router->get('/admin/login', [DashboardController::class, 'login']);
$router->post('/admin/login', [DashboardController::class, 'login']);

// Route đến dashboard admin
$router->get('/dashboard', [DashboardController::class, 'index'], [AuthAdminMiddleware::class]);

// Route đăng xuất
$router->get('/admin/logout', [DashboardController::class, 'logout']);

// Route đến quản lí banner quảng cáo
$router->get('/admin/banner', [BannerAdvertistingController::class, 'index'], [AuthAdminMiddleware::class]);
$router->get('/admin/banner/create', [BannerAdvertistingController::class, 'showCreateBannerPage'], [AuthAdminMiddleware::class]);
$router->post('/admin/banner/create', [BannerAdvertistingController::class, 'createBanner'], [AuthAdminMiddleware::class]);
$router->get('/admin/banner/edit/{id}', [BannerAdvertistingController::class, 'showEditBannerPage'], [AuthAdminMiddleware::class]);
$router->post('/admin/banner/edit', [BannerAdvertistingController::class, 'updateBanner'], [AuthAdminMiddleware::class]);
$router->post('/admin/banner/changestatus', [BannerAdvertistingController::class, 'changeStatusBanner'], [AuthAdminMiddleware::class]);
$router->post('/admin/banner/delete', [BannerAdvertistingController::class, 'deleteBanner'], [AuthAdminMiddleware::class]);

// Route quản trị sản phẩm
$router->get('/admin/products', [ProductController::class, 'getAllProducts'], [AuthAdminMiddleware::class]);
$router->get('/admin/products/create', [ProductController::class, 'createProduct'], [AuthAdminMiddleware::class]);
$router->post('/admin/products/create', [ProductController::class, 'createProduct'], [AuthAdminMiddleware::class]);
$router->post('/admin/products/delete', [ProductController::class, 'deleteProduct'], [AuthAdminMiddleware::class]);
$router->get('/admin/products/edit', [ProductController::class, 'editProduct'], [AuthAdminMiddleware::class]);
$router->post('/admin/products/edit', [ProductController::class, 'editProduct'], [AuthAdminMiddleware::class]);

// Route quản trị danh mục 
$router->get('/admin/catalogs', [CatalogController::class, 'getAllCatalogs'], [AuthAdminMiddleware::class]);
$router->get('/admin/catalogs/create', [CatalogController::class, 'createCatalog'], [AuthAdminMiddleware::class]);
$router->post('/admin/catalogs/create', [CatalogController::class, 'createCatalog'], [AuthAdminMiddleware::class]);
$router->post('/admin/catalogs/delete', [CatalogController::class, 'deleteCatalog'], [AuthAdminMiddleware::class]);
$router->get('/admin/catalogs/edit', [CatalogController::class, 'editCatalog'], [AuthAdminMiddleware::class]);
$router->post('/admin/catalogs/edit', [CatalogController::class, 'editCatalog'], [AuthAdminMiddleware::class]);

// Route quản trị thương hiệu
$router->get('/admin/brands', [BrandController::class, 'getAllBrands'], [AuthAdminMiddleware::class]);
$router->get('/admin/brands/create', [BrandController::class, 'createBrand'], [AuthAdminMiddleware::class]);
$router->post('/admin/brands/create', [BrandController::class, 'createBrand'], [AuthAdminMiddleware::class]);
$router->post('/admin/brands/delete', [BrandController::class, 'deleteBrand'], [AuthAdminMiddleware::class]);
$router->get('/admin/brands/edit', [BrandController::class, 'editBrand'], [AuthAdminMiddleware::class]);
$router->post('/admin/brands/edit', [BrandController::class, 'editBrand'], [AuthAdminMiddleware::class]);

// Route quản trị nhà cung cấp
$router->get('/admin/suppliers', [SupplierController::class, 'getAllSuppliers'], [AuthAdminMiddleware::class]);
$router->get('/admin/suppliers/create', [SupplierController::class, 'createSupplier'], [AuthAdminMiddleware::class]);
$router->post('/admin/suppliers/create', [SupplierController::class, 'createSupplier'], [AuthAdminMiddleware::class]);
$router->post('/admin/suppliers/delete', [SupplierController::class, 'deleteSupplier'], [AuthAdminMiddleware::class]);
$router->get('/admin/suppliers/edit', [SupplierController::class, 'editSupplier'], [AuthAdminMiddleware::class]);
$router->post('/admin/suppliers/edit', [SupplierController::class, 'editSupplier'], [AuthAdminMiddleware::class]);

// Route quản trị thuộc tính
$router->get('/admin/product-attributes', [ProductAttributeController::class, 'getAllAttributes'], [AuthAdminMiddleware::class]);
$router->get('/admin/product-attributes/create', [ProductAttributeController::class, 'createAttribute'], [AuthAdminMiddleware::class]);
$router->post('/admin/product-attributes/create', [ProductAttributeController::class, 'createAttribute'], [AuthAdminMiddleware::class]);
$router->post('/admin/product-attributes/delete', [ProductAttributeController::class, 'deleteAttribute'], [AuthAdminMiddleware::class]);
// $router->get('/admin/product-attributes/edit', [ProductAttributeController::class, 'editAttribute']);
$router->post('/admin/product-attributes/update', [ProductAttributeController::class, 'updateAttribute'], [AuthAdminMiddleware::class]);

// Route quản trị đơn hàng
$router->get('/admin/orders', [OrderController::class, 'getAllOrders'], [AuthAdminMiddleware::class]);
$router->get('/admin/orders/detail', [OrderController::class, 'getOrderDetail'], [AuthAdminMiddleware::class]);

$router->post('/admin/orders/update', [OrderController::class, 'updateOrderStatus'], [AuthAdminMiddleware::class]);

// Route quản trị review
$router->get('/admin/reviews', [ReviewController::class, 'getAllReviews'], [AuthAdminMiddleware::class]);
$router->get('/admin/reviews/product', [ReviewController::class, 'getReviewsByProduct'], [AuthAdminMiddleware::class]);
$router->post('/admin/reviews/change-status', [ReviewController::class, 'changeReviewStatus'], [AuthAdminMiddleware::class]);

// Router trang manager user feedback
$router->get('/admin/user_feedback', [UserFeedBackController::class, 'index'], [AuthAdminMiddleware::class]);
$router->get('/admin/user_feedback/{id}', [UserFeedBackController::class, 'showUserFeedbackDetail'], [AuthAdminMiddleware::class]);
$router->post('/admin/user_feedback/answer', [UserFeedBackController::class, 'saveAnswerFeedback'], [AuthAdminMiddleware::class]);

// Route quản trị flash sale
$router->get('/admin/flash-sales', [FlashSaleAdminController::class, 'getAllFlashSales'], [AuthAdminMiddleware::class]);
$router->get('/admin/flash-sales/create', [FlashSaleAdminController::class, 'createFlashSale'], [AuthAdminMiddleware::class]);
$router->post('/admin/flash-sales/create', [FlashSaleAdminController::class, 'createFlashSale'], [AuthAdminMiddleware::class]);
$router->post('/admin/flash-sales/delete', [FlashSaleAdminController::class, 'deleteFlashSale'], [AuthAdminMiddleware::class]);
$router->get('/admin/flash-sales/edit', [FlashSaleAdminController::class, 'editFlashSale'], [AuthAdminMiddleware::class]);
$router->post('/admin/flash-sales/edit', [FlashSaleAdminController::class, 'editFlashSale'], [AuthAdminMiddleware::class]);

// ===========================================API ROUTE=========================================================================
// $router->post('/v1/api/login', [ApiLoginController::class, 'handleLogin']);
// $router->get('/v1/api/product', [ApiProductController::class, 'getAll']);

// Route test
$router->get('/test', [TestController::class, 'index']);
// Xử lý request
$router->handleRequest();
