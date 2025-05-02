<!-- sidebar.php -->

<?php
$currentUrl = $_SERVER['REQUEST_URI'];
?>

<div class="w-64 bg-gray-800 text-white p-6 min-h-screen">
    <div class="flex flex-col h-full justify-between">
        <div>
            <h1 class="text-2xl font-semibold text-center mb-8">Admin Panel</h1>
            <ul>
                <li class="mb-4">
                    <a href="<?= BASE_URL ?>/dashboard"
                        class="flex items-center space-x-3 p-2 rounded-lg hover:bg-gray-700 <?= str_contains($currentUrl, '/dashboard') ? 'bg-gray-700' : '' ?>">
                        <i class="fas fa-tachometer-alt w-5 h-5"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li class="mb-4">
                    <a href="<?= BASE_URL ?>/admin/banner"
                        class="flex items-center space-x-3 p-2 rounded-lg hover:bg-gray-700 <?= str_contains($currentUrl, '/admin/banner') ? 'bg-gray-700' : '' ?>">
                        <i class="fa-solid fa-newspaper"></i>
                        <span>Banner quảng cáo</span>
                    </a>
                </li>
                <li class="mb-4">
                    <a href="<?= BASE_URL ?>/admin/brands"
                        class="flex items-center space-x-3 p-2 rounded-lg hover:bg-gray-700 <?= str_contains($currentUrl, '/admin/brands') ? 'bg-gray-700' : '' ?>">
                        <i class="fas fa-tags w-5 h-5"></i>
                        <span>Thương hiệu</span>
                    </a>
                </li>
                <li class="mb-4">
                    <a href="<?= BASE_URL ?>/admin/suppliers"
                        class="flex items-center space-x-3 p-2 rounded-lg hover:bg-gray-700 <?= str_contains($currentUrl, '/admin/suppliers') ? 'bg-gray-700' : '' ?>">
                        <i class="fas fa-warehouse w-5 h-5"></i>
                        <span>Nhà cung cấp</span>
                    </a>
                </li>
                <li class="mb-4">
                    <a href="<?= BASE_URL ?>/admin/catalogs"
                        class="flex items-center space-x-3 p-2 rounded-lg hover:bg-gray-700 <?= str_contains($currentUrl, '/admin/catalogs') ? 'bg-gray-700' : '' ?>">
                        <i class="fas fa-list w-5 h-5"></i>
                        <span>Danh mục</span>
                    </a>
                </li>
                <li class="mb-4">
                    <a href="<?= BASE_URL ?>/admin/products"
                        class="flex items-center space-x-3 p-2 rounded-lg hover:bg-gray-700 <?= str_contains($currentUrl, '/admin/products') ? 'bg-gray-700' : '' ?>">
                        <i class="fas fa-boxes w-5 h-5"></i>
                        <span>Sản phẩm</span>
                    </a>
                </li>
                <li class="mb-4">
                    <a href="<?= BASE_URL ?>/admin/flash-sales"
                        class="flex items-center space-x-3 p-2 rounded-lg hover:bg-gray-700 <?= str_contains($currentUrl, '/admin/flash-sales') ? 'bg-gray-700' : '' ?>">
                        <i class="fas fa-bolt w-5 h-5"></i>
                        <span>Flash sales</span>
                    </a>
                </li>
                <li class="mb-4">
                    <a href="<?= BASE_URL ?>/admin/product-attributes"
                        class="flex items-center space-x-3 p-2 rounded-lg hover:bg-gray-700 <?= str_contains($currentUrl, '/admin/product-attributes') ? 'bg-gray-700' : '' ?>">
                        <i class="fas fa-bookmark w-5 h-5"></i>
                        <span>Thuộc tính sản phẩm</span>
                    </a>
                </li>
                <li class="mb-4">
                    <a href="<?= BASE_URL ?>/admin/orders"
                        class="flex items-center space-x-3 p-2 rounded-lg hover:bg-gray-700 <?= str_contains($currentUrl, '/admin/orders') ? 'bg-gray-700' : '' ?>">
                        <i class="fas fa-truck w-5 h-5"></i>
                        <span>Đơn hàng</span>
                    </a>
                </li>
                <li class="mb-4">
                    <a href="<?= BASE_URL ?>/admin/reviews"
                        class="flex items-center space-x-3 p-2 rounded-lg hover:bg-gray-700 <?= str_contains($currentUrl, '/admin/reviews') ? 'bg-gray-700' : '' ?>">
                        <i class="fas fa-star w-5 h-5"></i>
                        <span>Đánh giá</span>
                    </a>
                </li>
            </ul>
        </div>
        <div>
            <a href="<?= BASE_URL ?>/admin/logout"
                class="flex items-center space-x-3 p-2 rounded-lg mt-8 hover:bg-gray-700 <?= str_contains($currentUrl, '/admin/logout') ? 'bg-gray-700' : '' ?>">
                <i class="fas fa-sign-out-alt w-5 h-5"></i>
                <span>Đăng xuất</span>
            </a>
        </div>
    </div>
</div>