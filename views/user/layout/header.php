<?php

use Core\Session;

$user = Session::get('user');
Session::set('current_url', $_SERVER['REQUEST_URI']);
$csrf_token = Core\CSRF::generateToken();
// var_dump($_SESSION);
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="csrf-token" content="<?php echo $csrf_token ?>">
  <link rel="stylesheet" href="<?php echo BASE_URL_NAME ?>/Public/css/app.css?v=<?php echo rand() ?>">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="icon" type="jpg" href="<?php echo BASE_URL_NAME ?>/Public//images//icon.jpg">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick.min.css" integrity="sha512-yHknP1/AwR+yx26cB1y0cjvQUMvEa2PFzt1c9LlS4pRQ5NOTZFWbhBig+X9G9eYW/8m0/4OXNx8pxJ6z57x0dw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick-theme.min.css" integrity="sha512-17EgCFERpgZKcm0j0fEq1YCJuyAWdz9KUtv1EjVuaOz8pDnh/0nZxmU6BBXwaaxqoi9PQXnRWqlcDB027hgv9A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link href="https://fonts.googleapis.com/css2?family=Noto+Sans:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="<?php echo BASE_URL_NAME ?>/Public/fontawesome/css/fontawesome.min.css">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet" />
  <!-- <link rel="stylesheet" href="./Public/css/bootstrap.min.css"> -->
  <link href="<?php echo BASE_URL_NAME ?>/Public/css/output.css?v=<?php echo rand() ?>" rel="stylesheet">
  <title>WildHorizon BookShop</title>
</head>

<body style="background-color: #f5f5f5;">
  <?php if (isset($homePage)) { ?>
    <div class=" banner-top w-screen bg-banner-top py-2" style="height: 80px;">
      <div class="flex align-middle relative h-full">
        <img class="mx-auto" src="<?php echo BASE_URL_NAME ?>/Public//images/banners/1fa52232-27a7-427f-93c5-c8ed1cb0e0ca_VN-1188-80.gif_2200x2200q80.gif_.webp" alt="banner-top">
      </div>
      <div class="absolute z-50 cursor-pointer hover:opacity-60" style="top: 15px;right: 10%" id="banner-top-ee">
        <i class="fa-solid fa-xmark text-lg text-white"></i>
      </div>
    </div>
  <?php } ?>
  <div class="container mx-auto relative">
    <div class="container-fuild mx-auto">
      <ul class="flex justify-around py-1" style="font-size: 12px;margin-left: 200px;">
        <li class=""><a href="<?php echo BASE_URL . '/feedback' ?>" class="text-blue-900 hover:text-orange-400 uppercase">feedback</a></li>
        <li class=""><a href="#" class="text-blue-900 hover:text-orange-400 uppercase">SAVE MORE ON APP</a></li>
        <li class=""><a href="#" class="text-blue-900 hover:text-orange-400 uppercase">sell on shop</a></li>
        <li class=""><a href="#" class="text-blue-900 hover:text-orange-400 uppercase">CUSTOMER CARE</a></li>
        <li class=""><a href="#" class="text-gray-400 hover:text-orange-400 uppercase">Track my order</a></li>
        <?php if (!empty($user)) { ?>
          <li class="whr-menu-user-popup text-gray-400 uppercase cursor-pointer relative" id="whr-menu-user">
            <p><?php echo htmlspecialchars($user['name']); ?></p>
            <div class="pt-2 absolute whr-menu-user">
              <div class="relative bg-white border border-gray-300 z-50 shadow-sm px-6 pt-3 pb-2">
                <div class="whr-meu-user-content top-content">
                  <ul class="mt-2 text-nowrap">
                    <li class="px-2 mt-1 my-3">
                      <a href="" class="flex items-center">
                        <span class="text-2xl text-gray-400"><i class="fa-regular fa-face-smile"></i></span>
                        <p class="ms-2 hover:text-orange-400 hover:underline-offset-1 hover:underline">Manage My Account</p>
                      </a>
                    </li>
                    <li class="ps-2 mt-1 my-3">
                      <a href="" class="flex items-center">
                        <span class="text-2xl text-gray-400"><i class="fa-regular fa-gem"></i></span>
                        <p class="ms-2 hover:text-orange-400 hover:underline-offset-1 hover:underline">My Order</p>
                      </a>
                    </li>
                    <li class="ps-2 mt-1 my-3">
                      <a href="" class="flex items-center">
                        <span class="text-2xl text-gray-400"><i class="fa-regular fa-heart"></i></i></span>
                        <p class="ms-2 hover:text-orange-400 hover:underline-offset-1 hover:underline">My Wishlist & Followed Stores</p>
                      </a>
                    </li>
                    <li class="ps-2 mt-1 my-3">
                      <a href="" class="flex items-center">
                        <span class="text-2xl text-gray-400"><i class="fa-regular fa-star"></i></span>
                        <p class="ms-2 hover:text-orange-400 hover:underline-offset-1 hover:underline">My Reviews</p>
                      </a>
                    </li>
                    <li class="ps-2 mt-1 my-3">
                      <form action="<?php echo BASE_URL . '/dang-xuat' ?>" method="post">
                        <input type="hidden" name="csrf_token" value="<?php echo $csrf_token ?>">
                        <button type="submit" class="flex items-center">
                          <span class="text-2xl text-gray-400"><i class="fa-solid fa-arrow-right-from-bracket"></i></span>
                          <p class="ms-2 hover:text-orange-400 hover:underline-offset-1 hover:underline">Log out</p>
                        </button>
                      </form>
                    </li>
                  </ul>
                </div>
              </div>
            </div>
          </li>
        <?php } else { ?>
          <li class=""><a href="<?php echo BASE_URL . '/dang-nhap' ?>" class="text-gray-400 hover:text-orange-400 uppercase">login</a></li>
          <li class=""><a href="<?php echo BASE_URL . '/dang-ky' ?>" class="text-gray-400 hover:text-orange-400 uppercase">signup</a></li>
        <?php } ?>

        <li class=""><a href="#" class="text-gray-400 hover:text-orange-400 uppercase">THAY ĐỔI NGÔN NGỮ</a></li>
    </div>
    <div class="w-full pt-2 bg-white header-content">
      <div class="container-fuild mx-auto flex justify-start items-center">
        <div class="header-logo">
          <a href="<?php echo BASE_URL . '/' ?>"><img src="<?php echo BASE_URL_NAME ?>/Public/images/logo.jpg" alt="" height="75" width="180"></a>
        </div>
        <div class="flex-1 <?php if (isset($nosearch)) {
                              echo 'pointer-events-none';
                            }; ?>">
          <form action="<?php echo BASE_URL . '/product' ?>" class="w-full" method="get">
            <div class="w-full flex header-search relative">
              <input type="text" name="search" id="search" class="w-full header-input-search py-3 px-3" value="<?php echo isset($keyword) ? $keyword : '' ?>" placeholder="search in wildhorizon shop">
              <div class="header-search-icon hover:opacity-80 rounded-r-sm">
                <button type="submit" id="btn-header-search"><i class="fa-solid fa-magnifying-glass p-3"></i></button>
              </div>
            </div>
          </form>
        </div>
        <div class="ms-6">
          <a href="<?php echo BASE_URL . '/gio-hang' ?>"><i class="fa-solid fa-cart-shopping cursor-pointer" style="height: 26px;"></i></a>
        </div>
        <div class="ms-6" style="height: 45px;">
          <a href="#"><img src="<?php echo BASE_URL_NAME ?>/Public/images/banners/O1CN01yOpioK1Qz7NKPWfkw_!!6000000002046-2-tps-376-90.avif" alt="" width="188" height="45"></a>
        </div>
      </div>
    </div>