<?php

use Core\Session;
use Helpers\CreateSlug;
use Helpers\Format;

$csrf_token = Core\CSRF::generateToken();
// var_dump($_SESSION);
include_once VIEW_PATH_USER_LAYOUT . 'header.php';
?>
<!-- Content -->
<div class="container-fuild mx-auto mb-2 p-1 lg:p-0">
    <div class="flex w-full justify-between">
        <?php if ($banner_headers != null) { ?>
            <div class="single-item shadow-lg flex-1">
                <div class="single-item">
                    <?php foreach ($banner_headers as $banner) { ?>
                        <img src="<?php echo $banner['image'] ?>" alt="banner_ads">
                    <?php } ?>
                </div>
            </div>
        <?php } else { ?>
            <div class="p-2 relative">
                <img src="https://res.cloudinary.com/whr-clound/image/upload/v1746261219/lbh72mmtznw6zcjmp9ao.png" alt="banner_image">
                <div class="absolute top-[35%] lg:top-[40%] left-[25%] w-[50%] user-select-none">
                    <p class="text-[14px] text-white lg:text-2xl p-1">Wildhorizon BookShop</p>
                    <p class="text-white p-1 mb-1 hidden lg:block">Khám phá thế giới tri thức bất tận, nơi những cuốn sách hay dẫn lối bạn đến chân trời mới mỗi ngày.</p>
                    <button class="btn btn-warning min-h-[40px] h-[30px] lg:h-full w-[120px] lg:w-[160px]"><a href="<?php echo BASE_URL ?>/product" class="text-[11px] lg:text-[14px]">Khám phá ngay</a></button>
                </div>
            </div>
        <?php } ?>
        <div class="hidden lg:flex px-1 flex-col ms-2">
            <div class="download-app px-2 shadow-lg">
                <div class="flex items-center">
                    <img class="lazyload" data-src="<?php echo BASE_URL ?>/Public/images/icon.jpg" alt="logo" style="width: 42px; height: 42px;">
                    <p class="uppercase ms-2 text-nowrap font-bold text-[12px] lg:text-[14px]">Thử ngay trên app</p>
                </div>
                <div class="download-app-content">
                    <div class="flex justify-start items-center py-1 px-2 text-white" style="font-size: 12px;">
                        <img class="lazyload" data-src="https://res.cloudinary.com/whr-clound/image/upload/v1746261861/spufdjpyukljijvrxgpd.avif" alt="star" style="height: 13px;width: 13px;">
                        <p class="ms-2 font-bold">4.7 Rated</p>
                    </div>
                    <div class="flex justify-start items-center px-2 mt-1 ">
                        <p class="text-white font-bold" style="font-size: 12px;">Tải ứng dụng để tận hưởng</p>
                    </div>
                    <div class="flex justify-around items-center flex-col ms-5 px-4">
                        <div class="flex justify-start items-center">
                            <img class="lazyload" data-src="https://res.cloudinary.com/whr-clound/image/upload/v1746262298/vy5zjlui8rlwmltdfd9x.avif" alt="Freeshipping" style="width: 36px; height: 36px;">
                            <p class="text-white ms-4 uppercase font-bold text-[14px]">Miễn phí vận chuyển</p>
                        </div>
                        <div class="flex justify-start items-center">
                            <img class="lazyload" data-src="https://res.cloudinary.com/whr-clound/image/upload/v1746262970/vwzulzjtwayjok5m1bjh.avif" alt="vouchers" style="width: 36px; height: 36px;">
                            <p class="text-white ms-4 uppercase font-bold text-[14px]">Giảm giá độc quyền</p>
                        </div>
                    </div>
                </div>
                <div class="flex items-center">
                    <div class="download-app-qr">
                        <img data-src="https://res.cloudinary.com/whr-clound/image/upload/v1746261960/oi9rxapyk1ii6k9bii0f.png" alt="qrcode-web" class="lazyload">
                    </div>
                    <div class="flex flex-col ms-2">
                        <a href="#" class="download-app-appstore mb-5"></a>
                        <a href="#" class="download-app-ggplay"></a>
                    </div>
                </div>
                <div>
                    <p class="font-bold p-1" style="font-size: 10px;">Tải xuống ứng dụng ngay bây giờ bằng cách quét mã QR</p>
                </div>
            </div>
        </div>
    </div>
    <div class="grid grid-cols-2 lg:grid-cols-3 mt-4 px-2 gap-3">
        <a href="<?php echo BASE_URL ?>/voucher" class="shadow-lg h-full" style="max-height: 130px;">
            <div class="bg-white flex justify-between p-3 rounded-md h-full w-full">
                <div class="text-[12px] lg:text-sm">
                    <p class="font-bold mb-2">Voucher</p>
                    <p class="text-wrap text-[12px] lg:text-nowrap hover:text-orange-400 lg:text-sm">Thu thập & Sử dụng ngay!</p>
                </div>
                <div class="flex justify-end h-[60px] lg:h-full lg:w-full" style="max-width: 138px;">
                    <img data-src="<?php echo BASE_URL ?>/Public/images/52eea06f-896c-4e21-a3b8-9b681e4485a5_VN-276-260.png_300x300q80.png_.avif" alt="voucher collect" class="h-full lazyload">
                </div>
            </div>
        </a>
        <a href="#" class="shadow-lg h-full" style="max-height: 130px;">
            <div class="bg-white flex justify-between p-3 rounded-md h-full w-full">
                <div class="text-[12px] lg:text-sm">
                    <p class="font-bold mb-2">Voucher</p>
                    <p class="text-wrap text-[12px] lg:text-nowrap hover:text-orange-400 lg:text-sm">Collect & Redeem Now!</p>
                </div>
                <div class="flex justify-end h-[60px] lg:h-full lg:w-full" style="max-width: 138px;">
                    <img data-src="<?php echo BASE_URL ?>/Public/images/52eea06f-896c-4e21-a3b8-9b681e4485a5_VN-276-260.png_300x300q80.png_.avif" alt="voucher collect" class="h-full lazyload">
                </div>
            </div>
        </a>
        <a href="#" class="shadow-lg h-full" style="max-height: 130px;">
            <div class="bg-white flex justify-between p-3 rounded-md h-full w-full">
                <div class="text-[12px] lg:text-sm">
                    <p class="font-bold mb-2">Voucher</p>
                    <p class="text-wrap text-[12px] lg:text-nowrap hover:text-orange-400 lg:text-sm">Collect & Redeem Now!</p>
                </div>
                <div class="flex justify-end h-[60px] lg:h-full lg:w-full" style="max-width: 138px;">
                    <img data-src="<?php echo BASE_URL ?>/Public/images/52eea06f-896c-4e21-a3b8-9b681e4485a5_VN-276-260.png_300x300q80.png_.avif" alt="voucher collect" class="h-full lazyload">
                </div>
            </div>
        </a>
    </div>
    <!-- Flashsales -->
    <div class="mt-4 p-1 lg:p-0">
        <div class="mb-3">
            <p class="ps-2 text-sm lg:p-0 lg:text-lg ">Flash Sale</p>
        </div>
        <div class="bg-white">
            <div class="flex justify-between items-center border-b-gray-300 border-b p-3 mb-3">
                <p class="text-[12px] lg:text-[14px] uppercase font-bold text-orange-500 ms-3">On Sale Now</p>
                <div class="mr-3 flash-sale-btn">
                    <a href="<?php echo BASE_URL . '/flash-sale' ?>" class="uppercase font-bold text-orange-500 text-[12px] lg:text-[14px]">shop all products</a>
                </div>
            </div>
            <div class="swiper swiperFlashsale">
                <div class="swiper-wrapper">
                    <?php foreach ($flassale_products as $fproduct) { ?>
                        <a href="<?php echo  BASE_URL . '/product/' . CreateSlug::createSlug($fproduct['product_name']) . '-' . $fproduct['product_id'] . '' ?>" class="mr-2 swiper-slide">
                            <div class="flex flex-col hover:shadow-md hover:rounded-sm whr-product-content lg:min-h-[260px]">
                                <div class="whr-product-img py-2">
                                    <img class="w-full h-full lazyload" data-src="<?php echo $fproduct['product_image'] ?>" alt="sanpham">
                                </div>
                                <div class="flash-sale-product mt-1 mx-2">
                                    <p class="text-[13px] lg:text-sm flash-sale-product-title px-2 lg:px-0"><?php echo $fproduct['product_name'] ?></p>
                                    <div class="flash-sale-product-price text-[13px] lg:text-sm px-2 lg:px-0">
                                        <p class="text-orange-500"><?php echo Format::forMatPrice($fproduct['price'] - ($fproduct['price'] * $fproduct['discount_price'] / 100), 0, '.', ',') ?><u class="text-orange-500 ms-1">đ</u></p>
                                        <p class="flash-sale-product-price-sale"><s class="opacity-50">đ<?php echo Format::forMatPrice($fproduct['price'], 0, '.', ',') ?></s>
                                            <span class="text-white ms-2 bg-red-600 rounded-sm px-1">-<?php echo Format::formatNumber($fproduct['discount_price']) . '%' ?></span>
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="flex" style="height: 16px;"></div>
                        </a>
                    <?php } ?>
                </div>
                <!-- <div class="swiper-button-next"></div>
                <div class="swiper-button-prev"></div> -->
            </div>
        </div>
    </div>
    <div class="mt-4 p-1 lg:p-0">
        <p class="ps-2 text-sm lg:p-0 lg:text-lg ">Danh mục sản phẩm</p>
        <div class="grid grid-cols-3 lg:grid-cols-8 mt-3">
            <?php foreach ($categories as $category) {  ?>
                <a href="<?php echo BASE_URL . '/category/' . CreateSlug::createSlug($category['catalog_name']) . '-' . ($category['id']) ?>">
                    <div class="flex flex-col bg-white border-b-2 border-r-2 border-gray-200 category">
                        <div class="w-full">
                            <div class="whr-category py-1 w-[50px] h-[50px] lg:w-[60px] lg:h-[60px]">
                                <img data-src="<?php echo $category['catalog_image'] ?>" alt="category" class="w-full h-full lazyload">
                            </div>
                            <div class="whr-category-title mb-2">
                                <p class="text-[13px] lg:text-sm mx-4 mt-1 category-title"><?php echo $category['catalog_name'] ?></p>
                            </div>
                        </div>
                    </div>
                </a>
            <?php } ?>
        </div>
    </div>
    <div class="mt-4 p-1 lg:p-0">
        <p class="ps-2 text-sm lg:p-0 lg:text-lg ">Dành cho bạn</p>
        <div class="flex flex-col ">
            <div class="mt-3 grid gap-2 grid-cols-2 lg:grid-cols-6 whr-product px-1 lg:px-0">
                <?php foreach ($products as $product) { ?>
                    <a href="<?php echo  BASE_URL . '/product/' . CreateSlug::createSlug($product['product_name']) . '-' . $product['id'] . '' ?>">
                        <div class="bg-white flex flex-col hover:shadow-md hover:rounded-sm whr-product-content lg:min-h-[260px]">
                            <div class="whr-product-img py-2">
                                <img data-src="<?php echo $product['product_image'] ?>" class="w-full h-full lazyload" alt="image">
                            </div>
                            <div class="px-2 lg:mt-1 pb-3">
                                <p class="text-[13px] lg:text-sm flash-sale-product-title px-2 lg:px-0"><?php echo $product['product_name'] ?></p>
                                <div class="flex items-start lg:mt-1 flex-col px-2 lg:px-0">
                                    <div class="product-price text-[13px] lg:text-sm">
                                        <p class="text-orange-500 mr-2"><?php echo number_format($product['price'] - (($product['price'] * $product['discount_price'] / 100)), '0', '.', '.') ?><u class="ms-1">đ</u></p>
                                    </div>
                                    <?php if (isset($product['discount_price']) && $product['discount_price'] > 0) { ?>
                                        <div class="product-price-sale">
                                            <p class="flash-sale-product-price-sale"><s class="opacity-50">đ<?php echo number_format($product['price'], 0, '.', ',') ?></s>
                                                <span class="text-white ms-2 bg-red-600 rounded-sm px-1 text-center">-<?php echo number_format($product['discount_price'], 0) . '%' ?></span>
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
                <button type="button" id="loadMore-product" class="load-more-product w-[100px] lg:w-full lg:text-sm text-[12px] lg:h-[40px] h-[35px] flex items-center justify-center" data-offset="<?php echo isset($primaryProduct) ? 30 : 10 ?>" data-load="<?php echo isset($primaryProduct) ? 1 : 0 ?>">Xem thêm</button>
            </div>
        </div>
    </div>
</div>
<?php
// Footer
include_once VIEW_PATH_USER_LAYOUT . 'footer.php'
?>