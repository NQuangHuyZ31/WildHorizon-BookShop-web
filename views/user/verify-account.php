<?php

use Core\CSRF;
use Core\Session;

if (Session::has('user') && Session::get('user')['role'] == 'customer') {

  header('location: ' . Session::get('current_url') . '');
}

CSRF::destroyToken();
$csrf_token = Core\CSRF::generateToken();
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
  <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css?v=<?php echo rand() ?>" />
  <link href="<?php echo BASE_URL ?>/Public/css/output.css?v=<?php echo rand() ?>" rel="stylesheet">
  <title>Verify account</title>
</head>

<body>
  <div class="login-content">
    <div class="container-fuild mx-auto my-auto">
      <main class="relative min-h-screen flex flex-col justify-center overflow-hidden">
        <div class="w-full max-w-6xl mx-auto px-4 md:px-6 py-24">
          <div class="flex justify-center">
            <div class="max-w-md mx-auto text-center bg-white px-4 sm:px-8 py-10 rounded-xl shadow">
              <header class="mb-8">
                <h1 class="text-lg xl:text-2xl font-bold mb-1">Xác thực tài khoản của bạn</h1>
                <p class="text-[13px] xl:text-[15px] text-slate-500">Vui lòng nhập 4 số được gửi về email bạn đăng ký tài khoản</p>
              </header>
              <form id="form-verify-account" action="<?php echo BASE_URL ?>/dang-ky/verify-account" method="post">
                <input type="hidden" name="csrf_token" value="<?php echo $csrf_token ?>">
                <div class="flex items-center justify-center gap-3">
                  <input
                    type="text"
                    class="w-11 h-11 xl:w-14 xl:h-14 text-center text-lg xl:text-2xl font-extrabold text-slate-900 bg-slate-100 border border-transparent hover:border-slate-200 appearance-none rounded p-4 outline-none focus:bg-white focus:border-indigo-400 focus:ring-2 focus:ring-indigo-100"
                    pattern="\d*" maxlength="1"
                    name="code_verify[]" />

                  <input
                    type="text"
                    class="w-11 h-11 xl:w-14 xl:h-14 text-center text-lg xl:text-2xl font-extrabold text-slate-900 bg-slate-100 border border-transparent hover:border-slate-200 appearance-none rounded p-4 outline-none focus:bg-white focus:border-indigo-400 focus:ring-2 focus:ring-indigo-100"
                    maxlength="1"
                    name="code_verify[]" />
                  <input
                    type="text"
                    class="w-11 h-11 xl:w-14 xl:h-14 text-center text-lg xl:text-2xl font-extrabold text-slate-900 bg-slate-100 border border-transparent hover:border-slate-200 appearance-none rounded p-4 outline-none focus:bg-white focus:border-indigo-400 focus:ring-2 focus:ring-indigo-100"
                    maxlength="1"
                    name="code_verify[]" />
                  <input
                    type="text"
                    class="w-11 h-11 xl:w-14 xl:h-14 text-center text-lg xl:text-2xl font-extrabold text-slate-900 bg-slate-100 border border-transparent hover:border-slate-200 appearance-none rounded p-4 outline-none focus:bg-white focus:border-indigo-400 focus:ring-2 focus:ring-indigo-100"
                    maxlength="1"
                    name="code_verify[]" />
                </div>
                <div class="max-w-[260px] mx-auto mt-4">
                  <button type="button" id="btn-verify-account"
                    class="w-full inline-flex justify-center whitespace-nowrap rounded-lg bg-indigo-500 px-3.5 py-2.5 text-[14px] xl:text-sm font-medium text-white shadow-sm shadow-indigo-950/10 hover:bg-indigo-600 focus:outline-none focus:ring focus:ring-indigo-300 focus-visible:outline-none focus-visible:ring focus-visible:ring-indigo-300 transition-colors duration-150">
                    Xác thực tài khoản
                  </button>
                </div>
              </form>
              <div class="text-[12px] xl:text-sm text-slate-500 mt-4">Bạn chưa nhận được code?
                <button type="button" id="btn-resend-verify-account" class="font-medium text-indigo-500 hover:text-indigo-600 cursor-pointer">Gửi lại</button>
              </div>
              <div class="flex justify-start items-center mt-2">
                <i class="fa-solid fa-arrow-left"></i>
                <a href="<?php echo BASE_URL ?>" class="text-[13px] xl:text-sm ms-2 text-blue-500">Trở về trang chủ</a>
              </div>
            </div>
          </div>
        </div>
      </main>
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
      "positionClass": "toast-bottom-right",
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