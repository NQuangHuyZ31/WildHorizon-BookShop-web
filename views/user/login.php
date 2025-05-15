<?php

use Core\CSRF;
use Core\Session;

if (Session::has('user') && Session::get('user')['role'] == 'customer') {

  header('location: ' . Session::get('current_url') . '');
}

CSRF::destroyToken();
$csrf_token = Core\CSRF::generateToken();

$errors = Session::get('message')['error'] ?? [];
$failLogin = Session::get('failLogin') ?? '';

$errorEmail = $errors['email'] ?? '';
$errorPassword = $errors['password'] ?? '';

Session::delete('message');
Session::delete('failLogin');
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="<?php echo BASE_URL ?>/Public/css/app.css?v=<?php echo rand() ?>">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="icon" type="jpg" href="<?php echo BASE_URL ?>/Public//images//icon.jpg">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick.min.css" integrity="sha512-yHknP1/AwR+yx26cB1y0cjvQUMvEa2PFzt1c9LlS4pRQ5NOTZFWbhBig+X9G9eYW/8m0/4OXNx8pxJ6z57x0dw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick-theme.min.css" integrity="sha512-17EgCFERpgZKcm0j0fEq1YCJuyAWdz9KUtv1EjVuaOz8pDnh/0nZxmU6BBXwaaxqoi9PQXnRWqlcDB027hgv9A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link href="https://fonts.googleapis.com/css2?family=Noto+Sans:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
  <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet" />
  <link href="<?php echo BASE_URL ?>/Public/css/output.css?v=<?php echo rand() ?>" rel="stylesheet">
  <title>Đăng nhập</title>
</head>

<body>
  <div class="login-content min-h-screen bg-cover bg-no-repeat px-3">
    <div class="container-fuild flex items-center justify-center px-3 min-h-screen mx-auto">
      <div class="bg-white whr-login w-full rounded-xl shadow-2 pb-3 pt-5">
        <div class="mb-1 text-center border-b-2 border-gray-200 shadow-sm pb-2">
          <p class="font-bold text-orange-400 text-lg xl:text-2xl mb-2">Đăng Nhập </p>
          <div class="flex justify-center items-center">
            <a class="flex justify-center items-center" href="<?php echo BASE_URL . '/' ?>">
              <img src="./Public/images/icon.jpg" alt="icon" style="width: 35px;height: 35px;">
              <p class="text-[12px] xl:text-sm ms-2 text-gray-500">WildHorizon BookShop</p>
            </a>
          </div>
        </div>
        <div class="px-9 mt-3">
          <form action="<?php echo BASE_URL . '/dang-nhap' ?>" method="post">
            <input type="hidden" name="csrf_token" value="<?php echo $csrf_token; ?>">
            <div class="py-1 mb-5">
              <label class="block">
                <span class="after:content-['*'] after:ml-0.5 after:text-red-500 block text-[12px] xl:text-sm font-medium text-slate-500 ms-2">
                  Email
                </span>
                <input
                  type="email"
                  name="email"
                  class="mt-1 px-3 py-2 bg-white border shadow-sm border-slate-300 placeholder-slate-400 focus:outline-none focus:border-sky-500 focus:ring-sky-500 block w-full rounded-md focus:ring-1 text-[12px] xl:text-sm"
                  placeholder="nguyenvana@gmail.com" />
              </label>
            </div>
            <div>
              <label class="block">
                <span class="after:content-['*'] after:ml-0.5 after:text-red-500 block text-[12px] xl:text-sm font-medium text-slate-500 ms-2">
                  Mật khẩu
                </span>
                <div class="relative">
                  <input
                    type="password"
                    id="whr-login-password"
                    name="password"
                    class="mt-1 px-3 py-2 bg-white border shadow-sm border-slate-300 placeholder-slate-400 focus:outline-none focus:border-sky-500 focus:ring-sky-500 block w-full rounded-md focus:ring-1 text-[12px] xl:text-sm"
                    placeholder="NQH@123" />
                  <div class="whr-show-hidden-pw-icon flex z-50 absolute right-3 top-1/2 transform -translate-y-1/2">
                    <div class="cursor-pointer flex items-center justify-center" style="width: 24px;height: 24px;" id="togglePassword">
                      <div class="whr-show-pw-icon text-[12px] xl:text-[15px]">
                        <i class="fa-regular fa-eye"></i>
                      </div>
                      <div class="whr-hidden-pw-icon hidden text-[12px] xl:text-[15px]">
                        <i class="fa-regular fa-eye-slash"></i>
                      </div>
                    </div>
                  </div>
                </div>
              </label>
              <div class="flex justify-end my-2 xl:pb-4">
                <span class="text-[12px] xl:text-sm text-gray-400"><a href="#">Quên mật khẩu</a></span>
              </div>
            </div>
            <div class="bg-purple-500 p-2 text-center rounded-full">
              <button type="submit" class="uppercase font-bold text-white w-full text-[14px]">Đăng nhập</button>
            </div>
          </form>
        </div>
        <div class="flex justify-center mt-3">
          <span class="text-[11px] xl:text-sm text-gray-400">Bạn chưa có tài khoản? <a href="<?php echo BASE_URL . '/dang-ky' ?>" class="text-sky-500">Đăng ký ngay</a></span>
        </div>
        <div class="flex flex-col items-center mt-3 pb-3 justify-center">
          <span class="text-gray-400 text-[11px] xl:text-sm">Hoặc, đăng nhập với</span>
          <div class="flex justify-center mt-3">
            <div class="flex items-center text-[11px] xl:text-sm text-gray-500 mr-4 cursor-pointer xl:p-2 hover:text-orange-400 ">
              <a href="<?php echo BASE_URL ?>/dang-nhap/google" class="flex items-center">
                <img src="https://res.cloudinary.com/whr-clound/image/upload/v1745417547/ax1vudmlwi60dp4wqjaf.webp" alt="" style="width: 22px;height: 22px;">
                <span class="ms-2">Google</span>
              </a>
            </div>
            <div class="flex items-center text-[11px] xl:text-sm text-gray-500 mr-4 cursor-pointer xl:p-2 hover:text-orange-400 ">
              <a href="<?php echo BASE_URL ?>/dang-nhap/facebook" class="flex items-center">
                <img src="https://res.cloudinary.com/whr-clound/image/upload/v1745417547/js8t7yjmysggys22xrpg.png" alt="" style="width: 22px;height: 22px;">
                <span class="ms-2">Facebook</span>
              </a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <script src="https://kit.fontawesome.com/3991b54e5c.js" crossorigin="anonymous"></script>
  <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick.min.js" integrity="sha512-HGOnQO9+SP1V92SrtZfjqxxtLmVzqZpjFFekvzZVWoiASSQgSr4cw9Kqd2+l8Llp4Gm0G8GIFJ4ddwZilcdb8A==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script src="https://cdn.jsdelivr.net/npm/js-loading-overlay@1.1.0/dist/js-loading-overlay.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js?v=<?php echo rand() ?>"></script>
  <script src="<?php echo BASE_URL ?>/Public/js/app.js?v=<?php echo rand() ?>"></script>
  <script src="<?php echo BASE_URL ?>/Public/js/cart.js?v=<?php echo rand() ?>"></script>
  <script src="<?php echo BASE_URL ?>/Public/js/product-detail.js?v=<?php echo rand() ?>"></script>
  <script src="<?php echo BASE_URL ?>/Public/js/checkout.js?v=<?php echo rand() ?>"></script>
  <script src="<?php echo BASE_URL ?>/Public/js/product.js?v=<?php echo rand() ?>"></script>

  <!--  -->
  <?php
  $success = Session::get('success');
  $status = is_array($success) && isset($success['status']) ? $success['status'] : '';
  $msg = is_array($success) && isset($success['msg']) ? $success['msg'] : '';
  Session::delete('success'); // Xóa flash sau khi dùng
  ?>

  <!-- Config notify -->
  <script>
    const status = "<?= addslashes($status) ?>";
    const msg = "<?= addslashes($msg) ?>";
    toastr.options = {
      "closeButton": true,
      "positionClass": "toast-top-right",
      "onclick": null,
      "showDuration": "500",
      "hideDuration": "500",
      "timeOut": "1000",
      // "extendedTimeOut": "1000000",
      "showEasing": "swing",
      "hideEasing": "linear",
      "showMethod": "fadeIn",
      "hideMethod": "fadeOut"
    }
    if (status != "" && status == 1) {
      toastr["success"](msg)
    }

    if (status != "" && status == 0) {
      toastr["error"](msg)
    }
  </script>
</body>

</html>