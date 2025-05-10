<?php

use Core\CSRF;
use Core\Session;

$user = Session::has('user') ? Session::get('user') : [];
Session::set('current_url', $_SERVER['REQUEST_URI']);
CSRF::destroyToken();
$csrf_token = Core\CSRF::generateToken();
// var_dump($_SESSION);
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta name="csrf_token" content="<?php echo $csrf_token ?>">
  <link rel="stylesheet" href="<?php echo BASE_URL ?>/Public/css/app.css?v=<?php echo rand() ?>">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="icon" type="jpg" href="<?php echo BASE_URL ?>/Public//images//icon.jpg">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick.min.css" integrity="sha512-yHknP1/AwR+yx26cB1y0cjvQUMvEa2PFzt1c9LlS4pRQ5NOTZFWbhBig+X9G9eYW/8m0/4OXNx8pxJ6z57x0dw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick-theme.min.css" integrity="sha512-17EgCFERpgZKcm0j0fEq1YCJuyAWdz9KUtv1EjVuaOz8pDnh/0nZxmU6BBXwaaxqoi9PQXnRWqlcDB027hgv9A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
  <link href="https://fonts.googleapis.com/css2?family=Noto+Sans:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="<?php echo BASE_URL ?>/Public/css/lity.min.css?v=<?php echo rand() ?>">
  <!-- <link rel="stylesheet" href="./Public/css/bootstrap.min.css"> -->
  <link href="<?php echo BASE_URL ?>/Public/css/output.css?v=<?php echo rand() ?>" rel="stylesheet">
  <title><?php echo $pageName ?> - wildhorizonBS.com</title>
</head>

<body style="background-color: #f5f5f5;">
  <?php if (isset($homePage) && $banner_top_headers != null) { ?>
    <div class=" banner-top w-screen bg-banner-top py-2" style="height: 80px;">
      <!-- <div class="flex align-middle relative h-full" style="background: url(<?php echo BASE_URL ?>/Public/images/DESK.gif); background-repeat: no-repeat;">
      </div> -->
      <div class="flex align-middle relative h-full">
        <?php foreach ($banner_top_headers as $banner) { ?>
          <img class="mx-auto" src="<?php echo $banner['image'] ?>" alt="banner-top">
        <?php } ?>
      </div>
      <div class="absolute z-50 cursor-pointer hover:opacity-60" style="top: 15px;right: 10%" id="banner-top-ee">
        <i class="fa-solid fa-xmark text-lg text-white"></i>
      </div>
    </div>
  <?php } ?>
  <div class="w-full mx-auto relative">
    <div class="container-fuild m-auto ">
      <ul class="hidden py-1 lg:flex lg:justify-around" style="font-size: 12px;margin-left: 100px;">
        <li class=""><a href="<?php echo BASE_URL . '/feedback' ?>" class="text-blue-900 hover:text-orange-400 uppercase">Góp ý</a></li>
        <li class=""><a href="#" class="text-blue-900 hover:text-orange-400 uppercase">Tiết kiệm hơn với ứng dụng</a></li>
        <li class=""><a href="#" class="text-blue-900 hover:text-orange-400 uppercase">Bán hàng cùng WHR shop</a></li>
        <li class=""><a href="#" class="text-blue-900 hover:text-orange-400 uppercase">Chăm sóc khách hàng</a></li>
        <li class=""><a href="#" class="text-gray-400 hover:text-orange-400 uppercase">Kiểm tra đơn hàng</a></li>
        <?php if (!empty($user)) { ?>
          <li class="whr-menu-user-popup text-gray-400 uppercase cursor-pointer relative" id="whr-menu-user">
            <p><?php echo htmlspecialchars($user['username']); ?></p>
            <div class="pt-2 absolute whr-menu-user">
              <div class="relative bg-white border border-gray-300 z-50 shadow-sm px-4 pt-3 pb-2 text-[11px]">
                <div class="whr-meu-user-content top-content">
                  <ul class="mt-2 text-nowrap">
                    <li class="px-2 mt-1 my-3">
                      <a href="<?php echo BASE_URL . '/customer/account' ?>" class="flex items-center">
                        <span class="text-2xl text-gray-400"><i class="text-[20px] fa-regular fa-face-smile"></i></span>
                        <p class="ms-2 hover:text-orange-400 hover:underline-offset-1 hover:underline">Quản lí tài khoản</p>
                      </a>
                    </li>
                    <li class="ps-2 mt-1 my-3">
                      <a href="<?php echo BASE_URL ?>/customer/order" class="flex items-center">
                        <span class="text-2xl text-gray-400"><i class="text-[20px] fa-regular fa-gem"></i></span>
                        <p class="ms-2 hover:text-orange-400 hover:underline-offset-1 hover:underline">Đơn hàng của tôi</p>
                      </a>
                    </li>
                    <li class="ps-2 mt-1 my-3">
                      <a href="<?php echo BASE_URL ?>/customer/wishlist" class="flex items-center">
                        <span class="text-2xl text-gray-400"><i class="text-[20px] fa-regular fa-heart"></i></i></span>
                        <p class="ms-2 hover:text-orange-400 hover:underline-offset-1 hover:underline">Danh sách yêu thích</p>
                      </a>
                    </li>
                    <li class="ps-2 mt-1 my-3">
                      <a href="<?php echo BASE_URL ?>/customer/review" class="flex items-center">
                        <span class="text-2xl text-gray-400"><i class="text-[20px] fa-regular fa-star"></i></span>
                        <p class="ms-2 hover:text-orange-400 hover:underline-offset-1 hover:underline">Nhận xét của tôi</p>
                      </a>
                    </li>
                    <li class="ps-2 mt-1 my-3">
                      <form action="<?php echo BASE_URL . '/dang-xuat' ?>" method="post">
                        <input type="hidden" name="csrf_token" value="<?php echo $csrf_token ?>">
                        <button type="submit" class="flex items-center">
                          <span class="text-2xl text-gray-400"><i class="text-[20px] fa-solid fa-arrow-right-from-bracket"></i></span>
                          <p class="ms-2 hover:text-orange-400 hover:underline-offset-1 hover:underline uppercase">Đăng xuất</p>
                        </button>
                      </form>
                    </li>
                  </ul>
                </div>
              </div>
            </div>
          </li>
        <?php } else { ?>
          <li class=""><a href="<?php echo BASE_URL . '/dang-nhap' ?>" class="text-gray-400 hover:text-orange-400 uppercase">Đăng nhập</a></li>
          <li class=""><a href="<?php echo BASE_URL . '/dang-ky' ?>" class="text-gray-400 hover:text-orange-400 uppercase">Đăng kí</a></li>
        <?php } ?>

        <li class=""><a href="#" class="text-gray-400 hover:text-orange-400 uppercase">THAY ĐỔI NGÔN NGỮ</a></li>
    </div>
    <div class="w-full pt-2 bg-white header-content lg:h-[80px]">
      <div class="grid grid-cols-3 h-full items-center lg:mx-auto container-fuild lg:grid-cols-4 ">
        <div class="header-logo col-span-4 flex justify-center w-full lg:col-span-1">
          <a href="<?php echo BASE_URL . '/' ?>">
            <img src="<?php echo BASE_URL ?>/Public/images/logo.jpg" alt="" class="max-w-[130px] max-h-[40px] lg:max-w-[100%] lg:max-h-[60px]">
          </a>
        </div>
        <div class="col-span-2 mx-3 lg:col-span-2 <?php if (isset($nosearch)) {
                                                    echo 'pointer-events-none';
                                                  }; ?>">
          <form action="<?php echo BASE_URL . '/product' ?>" class="w-full" method="get">
            <div class="w-full flex  relative">
              <input type="text" name="search" id="search" class="w-full header-input-search py-3 px-3 rounded-lg text-[11px] lg:text-sm" value="<?php echo isset($keyword) ? $keyword : '' ?>" placeholder="search in wildhorizon shop">
              <div class="hidden header-search-icon hover:opacity-80 rounded-lg lg:flex">
                <button type="submit" id="btn-header-search"><i class="fa-solid fa-magnifying-glass p-3 text-lg"></i></button>
              </div>
            </div>
          </form>
        </div>
        <div class="lg:ms-6 flex items-center justify-around col-span-1">
          <a href="<?php echo BASE_URL . '/gio-hang' ?>"><i class="fa-solid fa-cart-shopping cursor-pointer" style="height: 26px;"></i></a>
          <a href="<?php echo BASE_URL . '/customer/account' ?>" class="block lg:hidden"><i class="fa-solid fa-user cursor-pointer" style="height: 26px;"></i></a>
          <div class="ms-6 lg:block hidden" style="height: 45px;">
            <a href="#"><img src="<?php echo BASE_URL ?>/Public/images/658519f4-fceb-4e33-8895-70cb806e7efa_VN-376-90.png" alt="" width="188" height="45"></a>
          </div>
        </div>

      </div>
    </div>