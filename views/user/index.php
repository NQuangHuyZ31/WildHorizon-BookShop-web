<?php

use Core\Session;
use Helpers\CreateSlug;

$csrf_token = Core\CSRF::generateToken();

include_once VIEW_PATH_USER_LAYOUT . 'header.php';
?>
<!-- Content -->
<div class="container-fuild mx-auto mb-2">
    <div class="flex w-100 justify-between">
        <div class="single-item shadow-lg">
            <div class="single-item">
                <img src="<?php echo BASE_URL ?>/Public/images/banners/d24973d8-8df9-4de1-8c8d-58d338c3cac3_VN-1976-688.jpg_2200x2200q80.jpg" alt="">
                <img src="<?php echo BASE_URL ?>/Public/images/banners/a127309c-7b2b-412f-981a-6533901d5bc6_VN-1976-688.jpg_2200x2200q80.jpg" alt="">
                <img src="<?php echo BASE_URL ?>/Public/images/banners/b4ff1157-8492-4483-9a62-acbcc7c3a9b5_VN-1976-688.jpg_2200x2200q80.jpg" alt="">
                <img src="<?php echo BASE_URL ?>/Public/images/banners/ac103e8c-7045-4f75-a36a-38b490b3fe9f_VN-1976-688.jpg_2200x2200q80.jpg" alt="">
            </div>
        </div>
        <div class="flex px-1 flex-col ms-2">
            <div class="download-app px-2 shadow-lg">
                <div class="flex items-center">
                    <img src="<?php echo BASE_URL ?>/Public/images/icon.jpg" alt="logo" style="width: 42px; height: 42px;">
                    <p class="uppercase ms-2 text-nowrap font-bold" style="font-size: 14px; color: #6c1d00;;">try wildhorizon app</p>
                </div>
                <div class="download-app-content">
                    <div class="flex justify-start items-center py-1 px-2 text-white" style="font-size: 12px;">
                        <img src="https://img.lazcdn.com/g/tps/imgextra/i4/O1CN01cAMOjU1zqQJZU8EbT_!!6000000006765-2-tps-19-18.png_80x80q80.jpg_.avif" alt="star" style="height: 13px;width: 13px;">
                        <p class="ms-2 font-bold">4.7 Rated</p>
                    </div>
                    <div class="flex justify-start items-center px-2 mt-1 ">
                        <p class="text-white font-bold" style="font-size: 12px;">Get the wildhorizon App to enjoy</p>
                    </div>
                    <div class="flex justify-around items-center flex-col ms-5 px-4">
                        <div class="flex justify-start items-center">
                            <img src="<?php echo BASE_URL ?>/Public/images/banners/feeship.avif" alt="Freeshipping" style="width: 36px; height: 36px;">
                            <p class="text-white ms-4 uppercase font-bold">free shipping</p>
                        </div>
                        <div class="flex justify-start items-center">
                            <img src="<?php echo BASE_URL ?>/Public/images/banners/vouchers.avif" alt="vouchers" style="width: 36px; height: 36px;">
                            <p class="text-white ms-4 uppercase font-bold">EXCLUSIVE VOUCHERS</p>
                        </div>
                    </div>
                </div>
                <div class="flex items-center">
                    <div class="download-app-qr">
                        <img src="<?php echo BASE_URL ?>/Public/images/banners/qrcode_1736091045499.png" alt="qrcode-web">
                    </div>
                    <div class="flex flex-col ms-2">
                        <a href="#" class="download-app-appstore mb-5"></a>
                        <a href="#" class="download-app-ggplay"></a>
                    </div>
                </div>
                <div>
                    <p class="font-bold p-1" style="font-size: 10px;">Download the App now by scanning the QR code</p>
                </div>
            </div>
        </div>
    </div>
    <div class="grid grid-cols-3 mt-4">
        <a href="#" class="shadow-lg mr-3" style="height: 130px;">
            <div class="bg-white flex justify-between p-3 rounded-md h-full w-full">
                <div class="">
                    <p class="font-bold mb-2">Voucher</p>
                    <p class="text-nowrap hover:text-orange-400 text-sm">Collect & Redeem Now!</p>
                </div>
                <div class="flex justify-end" style="width: 138px;">
                    <img src="<?php echo BASE_URL ?>/Public/images/banners/voucher_a.avif" alt="voucher collect" class="h-full">
                </div>
            </div>
        </a>
        <a href="#" class="shadow-lg mr-3" style="height: 130px;">
            <div class="bg-white flex justify-between p-3 rounded-md h-full w-full">
                <div class="">
                    <p class="font-bold mb-2">Voucher</p>
                    <p class="text-nowrap hover:text-orange-400 text-sm">Collect & Redeem Now!</p>
                </div>
                <div class="flex justify-end" style="width: 138px;">
                    <img src="<?php echo BASE_URL ?>/Public/images/banners/voucher_a.avif" alt="voucher collect" class="h-full">
                </div>
            </div>
        </a>
        <a href="#" class="shadow-lg" style="height: 130px;">
            <div class="bg-white flex justify-between p-3 rounded-md h-full w-full">
                <div class="">
                    <p class="font-bold mb-2">Voucher</p>
                    <p class="text-nowrap hover:text-orange-400 text-sm">Collect & Redeem Now!</p>
                </div>
                <div class="flex justify-end" style="width: 138px;">
                    <img src="<?php echo BASE_URL ?>/Public/images/banners/voucher_a.avif" alt="voucher collect" class="h-full">
                </div>
            </div>
        </a>
    </div>
    <div class="mt-4">
        <div class="mb-3">
            <p class="text-lg">Flash Sale</p>
        </div>
        <div class="bg-white">
            <div class="flex justify-between items-center border-b-gray-300 border-b p-3 mb-3">
                <p class="uppercase font-bold text-orange-500 ms-3">On Sale Now</p>
                <div class="mr-3 flash-sale-btn">
                    <a href="<?php echo BASE_URL . '/flash-sale' ?>" class="uppercase font-bold text-orange-500">shop all products</a>
                </div>
            </div>
            <div class="grid grid-cols-6">
                <?php foreach ($flassale_products as $fproduct) { ?>
                    <a href="<?php echo  BASE_URL . '/product/' . CreateSlug::createSlug($fproduct['product_name']) . '-' . $fproduct['product_id'] . '' ?>" class="mr-2">
                        <div class="flex flex-col hover:shadow-md hover:rounded-sm whr-product-content">
                            <div class="whr-product-img py-2">
                                <img class="w-full h-full" src="<?php echo BASE_URL ?>/Public/upload/products/<?php echo $fproduct['product_image'] ?>" alt="sanpham">
                            </div>
                            <div class="flash-sale-product mt-1 mx-2">
                                <p class="text-sm flash-sale-product-title"><?php echo $fproduct['product_name'] ?></p>
                                <div class="flash-sale-product-price">
                                    <p class="text-orange-500"><u class="text-orange-500">đ</u><?php echo number_format($fproduct['price'], 0, '.', ','); ?></p>
                                    <p style="font-size: 13px;"><s class="opacity-50"><?php echo 'đ' . number_format($fproduct['price'] * (1 + $fproduct['discount_price'] / 100), 0, '.', ','); ?></s><span class="text-black ms-2"><?php echo '-' . number_format($fproduct['discount_price'], 0) . '%'; ?></span></p>
                                </div>
                            </div>
                        </div>
                        <div class="flex" style="height: 16px;"></div>
                    </a>
                <?php } ?>
            </div>
        </div>
    </div>
    <div class="mt-4">
        <p class="text-lg">Categories</p>
        <div class="grid grid-cols-8 mt-3">
            <?php foreach ($categories as $category) {  ?>
                <a href="<?php echo BASE_URL . '/category/' . CreateSlug::createSlug($category['catalog_name']) . '-' . ($category['id']) ?>">
                    <div class="flex flex-col bg-white border-b-2 border-r-2 border-gray-200 category">
                        <div class="w-full">
                            <div class="whr-category py-1">
                                <img src="<?php echo BASE_URL ?>/Public/upload/products/<?php echo $category['catalog_image'] ?>" alt="category" class="w-full h-full">
                            </div>
                            <div class="whr-category-title mb-2">
                                <p class="text-sm mx-4 mt-1 category-title"><?php echo $category['catalog_name'] ?></p>
                            </div>
                        </div>
                    </div>
                </a>
            <?php } ?>
        </div>
    </div>
    <div class="mt-4">
        <p class="text-lg">Just For You</p>
        <div class="flex flex-col ">
            <div class="mt-3 grid grid-cols-6 whr-product">
                <?php foreach ($products as $product) { ?>
                    <a href="<?php echo  BASE_URL . '/product/' . CreateSlug::createSlug($product['product_name']) . '-' . $product['id'] . '' ?>" class="mr-3 mb-4">
                        <div class="bg-white flex flex-col hover:shadow-md hover:rounded-sm whr-product-content">
                            <div class="whr-product-img py-2">
                                <img src="<?php echo BASE_URL ?>/Public/upload/products/<?php echo $product['product_image']; ?>" class="w-full h-full" alt="image">
                            </div>
                            <div class="px-2 mt-2 pb-3">
                                <p class="product-title text-sm"><?php echo $product['product_name'] ?></p>
                                <div class="flex items-start mt-2 flex-col">
                                    <div class="product-price">
                                        <p class="text-orange-500 mr-2"><?php echo number_format($product['price'] - (($product['price'] * $product['discount_price'] / 100)), '0', '.', '.') ?><u class="ms-1">đ</u></p>
                                        <p class="text-sm" style="font-size: 12px;"></p>
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
                <button type="button" id="loadMore-product" class="load-more-product" data-offset="<?php echo isset($primaryProduct) ? 30 : 10 ?>" data-load="<?php echo isset($primaryProduct) ? 1 : 0 ?>">Load more</button>
            </div>
        </div>
    </div>
</div>
<?php
// Footer
include_once VIEW_PATH_USER_LAYOUT . 'footer.php'
?>