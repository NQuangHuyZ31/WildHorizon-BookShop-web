<?php
// Header

use Core\Session;
$user = Session::get('user');
if (!empty($user) && $user['role'] !== 'user') {
    header('location: ' . BASE_URL . '/dang-nhap');
}
$csrf_token = Core\CSRF::generateToken();
include_once('layout/header.php');
?>
<!-- Content -->
<div class="container-fuild mx-auto mb-2">
    <div class="flex w-100 justify-between">
        <div class="single-item shadow-lg">
            <div class="single-item">
                <img src="./Public/images/banners/d24973d8-8df9-4de1-8c8d-58d338c3cac3_VN-1976-688.jpg_2200x2200q80.jpg" alt="">
                <img src="./Public/images/banners/a127309c-7b2b-412f-981a-6533901d5bc6_VN-1976-688.jpg_2200x2200q80.jpg" alt="">
                <img src="./Public/images/banners/b4ff1157-8492-4483-9a62-acbcc7c3a9b5_VN-1976-688.jpg_2200x2200q80.jpg" alt="">
                <img src="./Public/images/banners/ac103e8c-7045-4f75-a36a-38b490b3fe9f_VN-1976-688.jpg_2200x2200q80.jpg" alt="">
            </div>
        </div>
        <div class="flex px-1 flex-col ms-2">
            <div class="download-app px-2 shadow-lg">
                <div class="flex items-center">
                    <img src="./Public/images/icon.jpg" alt="logo" style="width: 42px; height: 42px;">
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
                            <img src="./Public/images/banners/feeship.avif" alt="Freeshipping" style="width: 36px; height: 36px;">
                            <p class="text-white ms-4 uppercase font-bold">free shipping</p>
                        </div>
                        <div class="flex justify-start items-center">
                            <img src="./Public/images/banners/vouchers.avif" alt="vouchers" style="width: 36px; height: 36px;">
                            <p class="text-white ms-4 uppercase font-bold">EXCLUSIVE VOUCHERS</p>
                        </div>
                    </div>
                </div>
                <div class="flex items-center">
                    <div class="download-app-qr">
                        <img src="./Public/images/banners/qrcode_1736091045499.png" alt="qrcode-web">
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
                    <img src="./Public/images/banners/voucher_a.avif" alt="voucher collect" class="h-full">
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
                    <img src="./Public/images/banners/voucher_a.avif" alt="voucher collect" class="h-full">
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
                    <img src="./Public/images/banners/voucher_a.avif" alt="voucher collect" class="h-full">
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
                <a href="#" class="mr-2">
                    <div class="flex flex-col hover:shadow-md hover:rounded-sm">
                        <div>
                            <img src="./Public/images/Probi.avif" alt="sanpham">
                        </div>
                        <div class="flash-sale-product mt-1 mx-2">
                            <p class="text-sm flash-sale-product-title">Probi yogurt drink low sugar bottle 130ml -24 bottles/carton yogurt</p>
                            <div class="flash-sale-product-price">
                                <p class="text-orange-500"><u class="text-orange-500">đ</u>82,000</p>
                                <p style="font-size: 13px;"><s class="opacity-50">đ99,000</s><span class="text-black ms-2">-17%</span></p>
                            </div>
                        </div>
                    </div>
                    <div class="flex" style="height: 16px;"></div>
                </a>
                <a href="#" class="mr-2">
                    <div class="flex flex-col hover:shadow-md hover:rounded-sm">
                        <div>
                            <img src="./Public/images/Probi.avif" alt="sanpham">
                        </div>
                        <div class="flash-sale-product mt-1 mx-2">
                            <p class="text-sm flash-sale-product-title">Probi yogurt drink low sugar bottle 130ml -24 bottles/carton yogurt</p>
                            <div class="flash-sale-product-price">
                                <p class="text-orange-500"><u class="text-orange-500">đ</u>82,000</p>
                                <p style="font-size: 13px;"><s class="opacity-50">đ99,000</s><span class="text-black ms-2">-17%</span></p>
                            </div>
                        </div>
                    </div>
                    <div class="flex" style="height: 16px;"></div>
                </a>
                <a href="#" class="mr-2">
                    <div class="flex flex-col hover:shadow-md hover:rounded-sm">
                        <div>
                            <img src="./Public/images/Probi.avif" alt="sanpham">
                        </div>
                        <div class="flash-sale-product mt-1 mx-2">
                            <p class="text-sm flash-sale-product-title">Probi yogurt drink low sugar bottle 130ml -24 bottles/carton yogurt</p>
                            <div class="flash-sale-product-price">
                                <p class="text-orange-500"><u class="text-orange-500">đ</u>82,000</p>
                                <p style="font-size: 13px;"><s class="opacity-50">đ99,000</s><span class="text-black ms-2">-17%</span></p>
                            </div>
                        </div>
                    </div>
                    <div class="flex" style="height: 16px;"></div>
                </a>
                <a href="#" class="mr-2">
                    <div class="flex flex-col hover:shadow-md hover:rounded-sm">
                        <div>
                            <img src="./Public/images/Probi.avif" alt="sanpham">
                        </div>
                        <div class="flash-sale-product mt-1 mx-2">
                            <p class="text-sm flash-sale-product-title">Probi yogurt drink low sugar bottle 130ml -24 bottles/carton yogurt</p>
                            <div class="flash-sale-product-price">
                                <p class="text-orange-500"><u class="text-orange-500">đ</u>82,000</p>
                                <p style="font-size: 13px;"><s class="opacity-50">đ99,000</s><span class="text-black ms-2">-17%</span></p>
                            </div>
                        </div>
                    </div>
                    <div class="flex" style="height: 16px;"></div>
                </a>
                <a href="#" class="mr-2">
                    <div class="flex flex-col hover:shadow-md hover:rounded-sm">
                        <div>
                            <img src="./Public/images/Probi.avif" alt="sanpham">
                        </div>
                        <div class="flash-sale-product mt-1 mx-2">
                            <p class="text-sm flash-sale-product-title">Probi yogurt drink low sugar bottle 130ml -24 bottles/carton yogurt</p>
                            <div class="flash-sale-product-price">
                                <p class="text-orange-500"><u class="text-orange-500">đ</u>82,000</p>
                                <p style="font-size: 13px;"><s class="opacity-50">đ99,000</s><span class="text-black ms-2">-17%</span></p>
                            </div>
                        </div>
                    </div>
                    <div class="flex" style="height: 16px;"></div>
                </a>
                <a href="#" class="mr-0">
                    <div class="flex flex-col hover:shadow-md hover:rounded-sm">
                        <div>
                            <img src="./Public/images/Probi.avif" alt="sanpham">
                        </div>
                        <div class="flash-sale-product mt-1 mx-2">
                            <p class="text-sm flash-sale-product-title">Probi yogurt drink low sugar bottle 130ml -24 bottles/carton yogurt</p>
                            <div class="flash-sale-product-price">
                                <p class="text-orange-500"><u class="text-orange-500">đ</u>82,000</p>
                                <p style="font-size: 13px;"><s class="opacity-50">đ99,000</s><span class="text-black ms-2">-17%</span></p>
                            </div>
                        </div>
                    </div>
                    <div class="flex" style="height: 16px;"></div>
                </a>
            </div>
        </div>
    </div>
    <div class="mt-4">
        <p class="text-lg">Categories</p>
        <div class="grid grid-cols-8 mt-3">
            <a href="#">
                <div class="flex flex-col bg-white border-b-2 border-r-2 border-gray-200 category">
                    <div class="w-full">
                        <div class="whr-category">
                            <img src="./Public/images/categories/wirelessandbluetooth.avif" alt="category" class="w-full">
                        </div>
                        <div class="whr-category-title mb-2">
                            <p class="text-sm mx-4 mt-1">Wireless and Bluetooth Speakers</p>
                        </div>
                    </div>
                </div>
            </a>
            <a href="#">
                <div class="flex flex-col bg-white border-b-2 border-r-2 border-gray-200 category">
                    <div class="w-full">
                        <div class="whr-category">
                            <img src="./Public/images/categories/wirelessandbluetooth.avif" alt="category" class="w-full">
                        </div>
                        <div class="whr-category-title mb-2">
                            <p class="text-sm mx-4 mt-1">Wireless and Bluetooth Speakers</p>
                        </div>
                    </div>
                </div>
            </a>
            <a href="#">
                <div class="flex flex-col bg-white border-b-2 border-r-2 border-gray-200 category">
                    <div class="w-full">
                        <div class="whr-category">
                            <img src="./Public/images/categories/wirelessandbluetooth.avif" alt="category" class="w-full">
                        </div>
                        <div class="whr-category-title mb-2">
                            <p class="text-sm mx-4 mt-1">Wireless and Bluetooth Speakers</p>
                        </div>
                    </div>
                </div>
            </a>
            <a href="#">
                <div class="flex flex-col bg-white border-b-2 border-r-2 border-gray-200 category">
                    <div class="w-full">
                        <div class="whr-category">
                            <img src="./Public/images/categories/wirelessandbluetooth.avif" alt="category" class="w-full">
                        </div>
                        <div class="whr-category-title mb-2">
                            <p class="text-sm mx-4 mt-1">Wireless and Bluetooth Speakers</p>
                        </div>
                    </div>
                </div>
            </a>
            <a href="#">
                <div class="flex flex-col bg-white border-b-2 border-r-2 border-gray-200 category">
                    <div class="w-full">
                        <div class="whr-category">
                            <img src="./Public/images/categories/wirelessandbluetooth.avif" alt="category" class="w-full">
                        </div>
                        <div class="whr-category-title mb-2">
                            <p class="text-sm mx-4 mt-1">Wireless and Bluetooth Speakers</p>
                        </div>
                    </div>
                </div>
            </a>
            <a href="#">
                <div class="flex flex-col bg-white border-b-2 border-r-2 border-gray-200 category">
                    <div class="w-full">
                        <div class="whr-category">
                            <img src="./Public/images/categories/wirelessandbluetooth.avif" alt="category" class="w-full">
                        </div>
                        <div class="whr-category-title mb-2">
                            <p class="text-sm mx-4 mt-1">Wireless and Bluetooth Speakers</p>
                        </div>
                    </div>
                </div>
            </a>
            <a href="#">
                <div class="flex flex-col bg-white border-b-2 border-r-2 border-gray-200 category">
                    <div class="w-full">
                        <div class="whr-category">
                            <img src="./Public/images/categories/wirelessandbluetooth.avif" alt="category" class="w-full">
                        </div>
                        <div class="whr-category-title mb-2">
                            <p class="text-sm mx-4 mt-1">Wireless and Bluetooth Speakers</p>
                        </div>
                    </div>
                </div>
            </a>
            <a href="#">
                <div class="flex flex-col bg-white border-b-2 border-r-2 border-gray-200 category">
                    <div class="w-full">
                        <div class="whr-category">
                            <img src="./Public/images/categories/wirelessandbluetooth.avif" alt="category" class="w-full">
                        </div>
                        <div class="whr-category-title mb-2">
                            <p class="text-sm mx-4 mt-1">Wireless and Bluetooth Speakers</p>
                        </div>
                    </div>
                </div>
            </a>
            <a href="#">
                <div class="flex flex-col bg-white border-b-2 border-r-2 border-gray-200 category">
                    <div class="w-full">
                        <div class="whr-category">
                            <img src="./Public/images/categories/wirelessandbluetooth.avif" alt="category" class="w-full">
                        </div>
                        <div class="whr-category-title mb-2">
                            <p class="text-sm mx-4 mt-1">Wireless and Bluetooth Speakers</p>
                        </div>
                    </div>
                </div>
            </a>
            <a href="#">
                <div class="flex flex-col bg-white border-b-2 border-r-2 border-gray-200 category">
                    <div class="w-full">
                        <div class="whr-category">
                            <img src="./Public/images/categories/wirelessandbluetooth.avif" alt="category" class="w-full">
                        </div>
                        <div class="whr-category-title mb-2">
                            <p class="text-sm mx-4 mt-1">Wireless and Bluetooth Speakers</p>
                        </div>
                    </div>
                </div>
            </a>
            <a href="#">
                <div class="flex flex-col bg-white border-b-2 border-r-2 border-gray-200 category">
                    <div class="w-full">
                        <div class="whr-category">
                            <img src="./Public/images/categories/wirelessandbluetooth.avif" alt="category" class="w-full">
                        </div>
                        <div class="whr-category-title mb-2">
                            <p class="text-sm mx-4 mt-1">Wireless and Bluetooth Speakers</p>
                        </div>
                    </div>
                </div>
            </a>
            <a href="#">
                <div class="flex flex-col bg-white border-b-2 border-r-2 border-gray-200 category">
                    <div class="w-full">
                        <div class="whr-category">
                            <img src="./Public/images/categories/wirelessandbluetooth.avif" alt="category" class="w-full">
                        </div>
                        <div class="whr-category-title mb-2">
                            <p class="text-sm mx-4 mt-1">Wireless and Bluetooth Speakers</p>
                        </div>
                    </div>
                </div>
            </a>
            <a href="#">
                <div class="flex flex-col bg-white border-b-2 border-r-2 border-gray-200 category">
                    <div class="w-full">
                        <div class="whr-category">
                            <img src="./Public/images/categories/wirelessandbluetooth.avif" alt="category" class="w-full">
                        </div>
                        <div class="whr-category-title mb-2">
                            <p class="text-sm mx-4 mt-1">Wireless and Bluetooth Speakers</p>
                        </div>
                    </div>
                </div>
            </a>
            <a href="#">
                <div class="flex flex-col bg-white border-b-2 border-r-2 border-gray-200 category">
                    <div class="w-full">
                        <div class="whr-category">
                            <img src="./Public/images/categories/wirelessandbluetooth.avif" alt="category" class="w-full">
                        </div>
                        <div class="whr-category-title mb-2">
                            <p class="text-sm mx-4 mt-1">Wireless and Bluetooth Speakers</p>
                        </div>
                    </div>
                </div>
            </a>
            <a href="#">
                <div class="flex flex-col bg-white border-b-2 border-r-2 border-gray-200 category">
                    <div class="w-full">
                        <div class="whr-category">
                            <img src="./Public/images/categories/wirelessandbluetooth.avif" alt="category" class="w-full">
                        </div>
                        <div class="whr-category-title mb-2">
                            <p class="text-sm mx-4 mt-1">Wireless and Bluetooth Speakers</p>
                        </div>
                    </div>
                </div>
            </a>
        </div>
    </div>
    <div class="mt-4">
        <p class="text-lg">Just For You</p>
        <div class="flex flex-col ">
            <div class="mt-3 grid grid-cols-6">
                <a href="#" class="mr-3 mb-4">
                    <div class="bg-white flex flex-col hover:shadow-md hover:rounded-sm">
                        <img src="./Public/images/Probi.avif" alt="">
                        <div class="px-2 mt-2 pb-3">
                            <p class="product-title text-sm">Probi yogurt drink low sugar bottle 130ml -24 bottles/carton yogurt</p>
                            <div class="flex items-center mt-2">
                                <p class="text-orange-500 mr-2"><u>đ</u>82,000</p>
                                <p class="text-sm" style="font-size: 12px;">-17%</p>
                            </div>
                        </div>
                    </div>
                </a>
                <a href="#" class="mr-3 mb-4">
                    <div class="bg-white flex flex-col hover:shadow-md hover:rounded-sm">
                        <img src="./Public/images/Probi.avif" alt="">
                        <div class="px-2 mt-2 pb-3">
                            <p class="product-title text-sm">Probi yogurt drink low sugar bottle 130ml -24 bottles/carton yogurt</p>
                            <div class="flex items-center mt-2">
                                <p class="text-orange-500 mr-2"><u>đ</u>82,000</p>
                                <p class="text-sm" style="font-size: 12px;">-17%</p>
                            </div>
                        </div>
                    </div>
                </a>
                <a href="#" class="mr-3 mb-4">
                    <div class="bg-white flex flex-col hover:shadow-md hover:rounded-sm">
                        <img src="./Public/images/Probi.avif" alt="">
                        <div class="px-2 mt-2 pb-3">
                            <p class="product-title text-sm">Probi yogurt drink low sugar bottle 130ml -24 bottles/carton yogurt</p>
                            <div class="flex items-center mt-2">
                                <p class="text-orange-500 mr-2"><u>đ</u>82,000</p>
                                <p class="text-sm" style="font-size: 12px;">-17%</p>
                            </div>
                        </div>
                    </div>
                </a>
                <a href="#" class="mr-3 mb-4">
                    <div class="bg-white flex flex-col hover:shadow-md hover:rounded-sm">
                        <img src="./Public/images/Probi.avif" alt="">
                        <div class="px-2 mt-2 pb-3">
                            <p class="product-title text-sm">Probi yogurt drink low sugar bottle 130ml -24 bottles/carton yogurt</p>
                            <div class="flex items-center mt-2">
                                <p class="text-orange-500 mr-2"><u>đ</u>82,000</p>
                                <p class="text-sm" style="font-size: 12px;">-17%</p>
                            </div>
                        </div>
                    </div>
                </a>
                <a href="#" class="mr-3 mb-4">
                    <div class="bg-white flex flex-col hover:shadow-md hover:rounded-sm">
                        <img src="./Public/images/Probi.avif" alt="">
                        <div class="px-2 mt-2 pb-3">
                            <p class="product-title text-sm">Probi yogurt drink low sugar bottle 130ml -24 bottles/carton yogurt</p>
                            <div class="flex items-center mt-2">
                                <p class="text-orange-500 mr-2"><u>đ</u>82,000</p>
                                <p class="text-sm" style="font-size: 12px;">-17%</p>
                            </div>
                        </div>
                    </div>
                </a>
                <a href="#" class="mr-3 mb-4">
                    <div class="bg-white flex flex-col hover:shadow-md hover:rounded-sm">
                        <img src="./Public/images/Probi.avif" alt="">
                        <div class="px-2 mt-2 pb-3">
                            <p class="product-title text-sm">Probi yogurt drink low sugar bottle 130ml -24 bottles/carton yogurt</p>
                            <div class="flex items-center mt-2">
                                <p class="text-orange-500 mr-2"><u>đ</u>82,000</p>
                                <p class="text-sm" style="font-size: 12px;">-17%</p>
                            </div>
                        </div>
                    </div>
                </a>
                <a href="#" class="mr-3 mb-4">
                    <div class="bg-white flex flex-col hover:shadow-md hover:rounded-sm">
                        <img src="./Public/images/Probi.avif" alt="">
                        <div class="px-2 mt-2 pb-3">
                            <p class="product-title text-sm">Probi yogurt drink low sugar bottle 130ml -24 bottles/carton yogurt</p>
                            <div class="flex items-center mt-2">
                                <p class="text-orange-500 mr-2"><u>đ</u>82,000</p>
                                <p class="text-sm" style="font-size: 12px;">-17%</p>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="mb-2 pt-3">
                <a href="#" class="load-more-product">Load more</a>
            </div>
        </div>
    </div>
    <!-- MODAL NOTIFICATION -->
    <!-- Open the modal using ID.showModal() method -->
    <!-- <button class="btn" onclick="my_modal_1.showModal()">open modal</button> -->
    <dialog id="my_modal_1" class="modal <?php if (Session::has('success')) {
                                                echo 'modal-open';
                                                Session::delete('success');
                                            } ?>">
        <div class="modal-box">
            <form method="dialog">
                <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2" id="btn-close-modal">✕</button>
            </form>
            <h3 class="text-lg font-bold border-b-2 border-gray-300 pb-2">Wildhorizon BookShop thông báo!</h3>
            <div class="flex justify-start items-start mt-3">
                <div class="p-2 flex items-center ">
                    <i class="fa-solid fa-circle-exclamation text-orange-400" style="font-size: 32px;"></i>
                </div>
                <div class="px-2 pt-3">
                    <p class="">Đề xuất cập nhật thông tin cá nhân!</p>
                    <div class="mt-3 px-3 flex items-center">
                        <p class="text-sm text-gray-400 align-middle flex items-center">Đi đến cập nhật thông tin<i class="fa-regular fa-hand-point-right ms-2" style="font-size: 25px;"></i></p>
                        <button type="button" class="py-2 px-3 bg-blue-500 rounded-md text-white ms-4"><a class="w-full h-full" href="<?php echo BASE_URL . '/profile/cap-nhat' ?>">Đi đến</a></button>
                    </div>
                </div>
            </div>
        </div>
    </dialog>
</div>
<?php
// Footer
include_once('layout/footer.php');
?>