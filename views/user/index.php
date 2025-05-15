<?php

use Core\Session;
use Helpers\CreateSlug;
use Helpers\Format;

$csrf_token = Core\CSRF::generateToken();
// var_dump($_SESSION);
include_once VIEW_PATH_USER_LAYOUT . 'header.php';
?>
<!-- Content -->
<div class="p-1 w-full xl:container xl:mx-auto xl:p-0">
    <div class="w-full xl:max-w-screen-xl xl:mx-auto my-4">
        <div class="flex w-full justify-between xl:h-[320px]">
            <?php if ($banner_headers != null) { ?>
                <div class="single-item shadow-md flex-1">
                    <div class="single-item">
                        <?php foreach ($banner_headers as $banner) { ?>
                            <img src="<?php echo $banner['image'] ?>" alt="banner_ads">
                        <?php } ?>
                    </div>
                </div>
            <?php } else { ?>
                <div class="relative shadow-sm">
                    <img src="https://res.cloudinary.com/whr-clound/image/upload/v1746261219/lbh72mmtznw6zcjmp9ao.png" alt="banner_image" class="rounded-md w-full h-full">
                    <div class="absolute top-[35%] xl:top-[40%] left-[25%] w-[50%] user-select-none">
                        <p class="text-[14px] text-white xl:text-2xl p-1">Wildhorizon BookShop</p>
                        <p class="text-white p-1 mb-1 hidden xl:block">Khám phá thế giới tri thức bất tận, nơi những cuốn sách hay dẫn lối bạn đến chân trời mới mỗi ngày.</p>
                        <button class="btn btn-warning min-h-[40px] h-[30px] xl:h-full w-[120px] xl:w-[160px]"><a href="<?php echo BASE_URL ?>/product" class="text-[11px] xl:text-[14px]">Khám phá ngay</a></button>
                    </div>
                </div>
            <?php } ?>
            <div class="hidden xl:block h-full ms-3">
                <div class="flex flex-col justify-between h-full">
                    <img src="https://res.cloudinary.com/whr-clound/image/upload/v1747208447/jballivb9svsnrtug0zm.webp" alt="banner" class="rounded-md">
                    <img src="https://res.cloudinary.com/whr-clound/image/upload/v1747208461/izkakqe887p0okq6d6ic.webp" alt="banner" class="rounded-md">
                </div>
            </div>
        </div>
        <div class="grid grid-cols-2 xl:grid-cols-3 my-7 gap-3">
            <a href="<?php echo BASE_URL ?>/voucher" class="shadow-sm xl:shadow-md h-full" style="max-height: 130px;">
                <div class="bg-white flex justify-between p-3 rounded-md h-full w-full">
                    <div class="text-[12px] xl:text-sm">
                        <p class="font-bold mb-2">Voucher</p>
                        <p class="text-wrap text-[12px] xl:text-nowrap hover:text-orange-400 xl:text-sm">Thu thập & Sử dụng ngay!</p>
                    </div>
                    <div class="flex justify-end h-[60px] xl:h-full xl:w-full" style="max-width: 138px;">
                        <img data-src="<?php echo BASE_URL ?>/Public/images/52eea06f-896c-4e21-a3b8-9b681e4485a5_VN-276-260.png_300x300q80.png_.avif" alt="voucher collect" class="h-full lazyload">
                    </div>
                </div>
            </a>
            <a href="#" class="shadow-sm xl:shadow-md h-full" style="max-height: 130px;">
                <div class="bg-white flex justify-between p-3 rounded-md h-full w-full">
                    <div class="text-[12px] xl:text-sm">
                        <p class="font-bold mb-2"></p>
                        <p class="text-wrap text-[12px] xl:text-nowrap hover:text-orange-400 xl:text-sm">Collect & Redeem Now!</p>
                    </div>
                    <div class="flex justify-end h-[60px] xl:h-full xl:w-full" style="max-width: 138px;">
                        <img data-src="<?php echo BASE_URL ?>/Public/images/52eea06f-896c-4e21-a3b8-9b681e4485a5_VN-276-260.png_300x300q80.png_.avif" alt="voucher collect" class="h-full lazyload">
                    </div>
                </div>
            </a>
            <a href="#" class="shadow-sm xl:shadow-md h-full" style="max-height: 130px;">
                <div class="bg-white flex justify-between p-3 rounded-md h-full w-full">
                    <div class="text-[12px] xl:text-sm">
                        <p class="font-bold mb-2">Voucher</p>
                        <p class="text-wrap text-[12px] xl:text-nowrap hover:text-orange-400 xl:text-sm">Collect & Redeem Now!</p>
                    </div>
                    <div class="flex justify-end h-[60px] xl:h-full xl:w-full" style="max-width: 138px;">
                        <img data-src="<?php echo BASE_URL ?>/Public/images/52eea06f-896c-4e21-a3b8-9b681e4485a5_VN-276-260.png_300x300q80.png_.avif" alt="voucher collect" class="h-full lazyload">
                    </div>
                </div>
            </a>
        </div>
    </div>
    <!-- Flashsales -->
    <div class="w-full mt-10 p-1 xl:container xl:p-0 mb-10">
        <div class="w-full xl:max-w-screen-xl xl:mx-auto relative">
            <div class="">
                <div class="flex justify-between items-center px-5 xl:px-7 py-3 mb-3 bg-white relative z-50 rounded-md">
                    <div class="flex items-center">
                        <img src="https://res.cloudinary.com/whr-clound/image/upload/v1745417547/xumhjzw0igzdwwgosq1k.svg" alt="fs_icon">
                    </div>
                    <div class="mr-3 flex items-center text-blue-500 text-[13px] xl:text-sm">
                        <a href="<?php echo BASE_URL . '/flash-sale' ?>" class="">Xem tất cả</a>
                        <i class="fa-solid fa-angle-up rotate-90"></i>
                    </div>
                </div>
                <div class="swiper swiperFlashsale">
                    <div class="swiper-wrapper">
                        <?php foreach ($flassale_products as $fproduct) { ?>
                            <a href="<?php echo  BASE_URL . '/product/' . CreateSlug::createSlug($fproduct['product_name']) . '-' . $fproduct['product_id'] . '' ?>" class="mr-2 swiper-slide">
                                <div class="flex flex-col shadow-sm whr-product-content pb-2 xl:pb-0 xl:min-h-[260px] bg-white rounded-md">
                                    <div class="whr-product-img py-2">
                                        <img class="w-full h-full lazyload" data-src="<?php echo $fproduct['product_image'] ?>" alt="sanpham">
                                    </div>
                                    <div class="flash-sale-product mt-1 mx-2">
                                        <p class="text-[13px] xl:text-sm flash-sale-product-title px-2 xl:px-0"><?php echo $fproduct['product_name'] ?></p>
                                        <div class="flash-sale-product-price text-[13px] xl:text-sm px-2 xl:px-0">
                                            <p class="text-orange-500"><?php echo Format::forMatPrice($fproduct['price'] - ($fproduct['price'] * $fproduct['discount_price'] / 100), 0, '.', ',') ?><u class="text-orange-500 ms-1">đ</u></p>
                                            <p class="flash-sale-product-price-sale"><s class="opacity-50">đ<?php echo Format::forMatPrice($fproduct['price'], 0, '.', ',') ?></s>
                                                <span class="text-white ms-2 bg-red-600 rounded-sm px-1 text-[9px] xl:text-[11px]">-<?php echo Format::formatNumber($fproduct['discount_price']) . '%' ?></span>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="flex" style="height: 16px;"></div>
                            </a>
                        <?php } ?>
                    </div>
                </div>
            </div>
            <div class="bg_fs"></div>
        </div>
    </div>
    <div class="mt-10 p-1 xl:p-0">
        <div class="w-full xl:max-w-screen-xl xl:mx-auto bg-white px-3 rounded-md">
            <div class="flex items-center text-sm xl:text-xl p-4 border-b border-gray-200 font-bold">
                <i class="fa-solid fa-store mr-2 xl:mr-3"></i>
                <p class="ps-2 xl:p-0">Danh Mục Sản Phẩm</p>
            </div>
            <div class="grid grid-cols-3 gap-2 xl:grid-cols-10 py-3">
                <?php foreach ($categories as $category) {  ?>
                    <a href="<?php echo BASE_URL . '/category/' . CreateSlug::createSlug($category['catalog_name']) . '-' . ($category['id']) ?>" class="hover:text-orange-500 border border-gray-200 transition duration-500 ease-in-out rounded-md">
                        <div class="flex flex-col py-1">
                            <div class="w-full flex flex-col items-center justify-center">
                                <div class="whr-category py-1 w-[50px] h-[50px] xl:w-[60px] xl:h-[60px]">
                                    <img data-src="<?php echo $category['catalog_image'] ?>" alt="category" class="w-full h-full lazyload">
                                </div>
                                <div class="text-center">
                                    <p class="text-[13px] xl:text-sm mx-4 mt-1 category-title"><?php echo $category['catalog_name'] ?></p>
                                </div>
                            </div>
                        </div>
                    </a>
                <?php } ?>
            </div>
        </div>
    </div>
    <!-- Nổi bật trong tuần -->
    <div class="mt-10 p-1 xl:p-0">
        <div class="w-full xl:max-w-screen-xl xl:mx-auto bg-white rounded-md">
            <div class="bg-pink-200 px-3 py-2 rounded-t-md flex items-center">
                <div class="w-[35px] h-[35px] flex items-center justify-center rounded-md" style="background: url(https://res.cloudinary.com/whr-clound/image/upload/v1747141655/mqcesjm6cxlkrihb67cr.webp) no-repeat center center;">
                    <i class="fa-solid fa-arrow-trend-up text-white z-50 relative"></i>
                </div>
                <p class="ms-3 font-bold text-sm xl:text-lg">Bán Chạy Trong Tuần</p>
            </div>
            <div class="swiper outstanding_product py-3">
                <div class="swiper-wrapper">
                    <?php foreach ($product_best_sellers as $product) { ?>
                        <a href="<?php echo  BASE_URL . '/product/' . CreateSlug::createSlug($product['product_name']) . '-' . $product['id'] . '' ?>" class="mr-2 swiper-slide">
                            <div class="flex flex-col whr-product-content pb-2 xl:pb-0 xl:min-h-[260px] bg-white rounded-md hover:shadow-full">
                                <div class="whr-product-img py-2">
                                    <img class="w-full h-full lazyload" data-src="<?php echo $product['product_image'] ?>" alt="sanpham">
                                </div>
                                <div class="flash-sale-product mt-1 mx-2">
                                    <p class="text-[13px] xl:text-sm flash-sale-product-title px-2 xl:px-0"><?php echo $product['product_name'] ?></p>
                                    <div class="flash-sale-product-price text-[13px] xl:text-sm px-2 xl:px-0">
                                        <p class="text-orange-500"><?php echo $product['f_quantity'] > 0 ? Format::forMatPrice($product['price'] - ($product['price'] * $product['f_discount_price'] / 100)) : Format::forMatPrice($product['price'] - ($product['price'] * $product['discount_price'] / 100)) ?><u class="text-orange-500 ms-1">đ</u></p>
                                        <p class="flash-sale-product-price-sale"><s class="opacity-50">đ<?php echo Format::forMatPrice($product['price'], 0, '.', ',') ?></s>
                                            <span class="text-white ms-2 bg-red-600 rounded-sm px-1 text-[9px] xl:text-[11px]">-<?php echo $product['f_quantity'] > 0 ? Format::formatNumber($product['f_discount_price']) : Format::formatNumber($product['discount_price']) ?>%</span>
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="flex" style="height: 16px;"></div>
                        </a>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
    <div class="mt-8 p-1 bg-white rounded-md xl:p-5 xl:max-w-screen-xl xl:mx-auto">
        <div class="px-3 py-3 rounded-t-md flex items-center border-b border-gray-200">
            <div class="w-[35px] h-[35px] flex items-center justify-center rounded-md" style="background: url(https://res.cloudinary.com/whr-clound/image/upload/v1747141655/mqcesjm6cxlkrihb67cr.webp) no-repeat center center;">
                <i class="fa-solid fa-star text-white relative z-50"></i>
            </div>
            <p class="ms-3 font-bold text-sm xl:text-lg">Dành cho bạn</p>
        </div>
        <div class="flex flex-col ">
            <div class="mt-3 grid gap-2 grid-cols-2 xl:grid-cols-6 whr-product px-1 xl:px-0">
                <?php foreach ($products as $product) { ?>
                    <a href="<?php echo  BASE_URL . '/product/' . CreateSlug::createSlug($product['product_name']) . '-' . $product['id'] . '' ?>">
                        <div class="bg-white flex flex-col hover:shadow-full whr-product-content xl:min-h-[260px]">
                            <div class="whr-product-img py-2">
                                <img data-src="<?php echo $product['product_image'] ?>" class="w-full h-full lazyload" alt="image">
                            </div>
                            <div class="px-2 xl:mt-1 pb-3">
                                <p class="text-[13px] xl:text-sm flash-sale-product-title px-2 xl:px-0"><?php echo $product['product_name'] ?></p>
                                <div class="flex items-start xl:mt-1 flex-col px-2 xl:px-0">
                                    <div class="product-price text-[13px] xl:text-sm">
                                        <p class="text-orange-500 mr-2"><?php echo number_format($product['price'] - (($product['price'] * $product['discount_price'] / 100)), '0', '.', '.') ?><u class="ms-1">đ</u></p>
                                    </div>
                                    <?php if (isset($product['discount_price']) && $product['discount_price'] > 0) { ?>
                                        <div class="product-price-sale">
                                            <p class="flash-sale-product-price-sale"><s class="opacity-50">đ<?php echo number_format($product['price'], 0, '.', ',') ?></s>
                                                <span class="text-white ms-2 bg-red-600 rounded-sm px-1 text-center text-[9px] xl:text-[11px]">-<?php echo number_format($product['discount_price'], 0) . '%' ?></span>
                                            </p>
                                        </div>
                                    <?php  } ?>
                                </div>
                            </div>
                        </div>
                    </a>
                <?php } ?>
            </div>
            <div class="mb-2 pt-3">
                <button type="button" id="homepage-loadMore-product" class="load-more-product w-[100px] xl:w-full xl:text-sm text-[12px] xl:h-[40px] h-[35px] flex items-center justify-center" data-offset="10">Xem thêm</button>
            </div>
        </div>
    </div>
</div>
<?php
// Footer
include_once VIEW_PATH_USER_LAYOUT . 'footer.php'
?>