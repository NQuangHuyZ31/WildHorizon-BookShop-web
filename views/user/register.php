<?php

use Core\Session;

if (Session::has('user') && Session::get('user')['role'] == 'customer') {

  header('location: ' . Session::get('current_url') . '');
}

if (!empty(Session::get('data'))) {
  $data = Session::get('data') ?? [];
}

// lấy dữ liệu form
$username = $data['username'] ?? '';
$email = $data['email'] ?? '';

// Xóa session
Core\Session::delete('data');

// Tạo token
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
  <link rel="stylesheet" href="<?php echo BASE_URL ?>/Public/fontawesome/css/fontawesome.min.css">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet" />
  <link href="<?php echo BASE_URL ?>/Public/css/output.css?v=<?php echo rand() ?>" rel="stylesheet">
  <title>Register</title>
</head>

<body>
  <div class="register-content">
    <div class="container-fuild mx-auto">
      <div class="flex justify-center items-center p-6">
        <div class="bg-white whr-register rounded-xl shadow-2 pb-3 pt-5">
          <div class="mb-1 text-center border-b-2 border-gray-200 shadow-sm pb-2">
            <p class="font-bold text-orange-400 text-2xl mb-2">Đăng Ký Tài Khoản </p>
            <div class="flex justify-center items-center">
              <a class="flex justify-center items-center" href="<?php echo BASE_URL . '/' ?>">
                <img src="./Public/images/icon.jpg" alt="icon" style="width: 35px;height: 35px;">
                <p class="text-sm ms-2 text-gray-500">WildHorizon BookShop</p>
              </a>
            </div>
          </div>
          <div class="px-9">
            <form action="<?php echo BASE_URL . '/dang-ky' ?>" method="post">
              <input type="hidden" name="csrf_token" value="<?php echo $csrf_token ?>">
              <div class="py-1 mb-1">
                <label class="block">
                  <span class="after:content-['*'] after:ml-0.5 after:text-red-500 block text-sm font-medium text-gray-500 ms-2">
                    Tên người dùng
                  </span>
                  <input type="text" name="username"
                    class="mt-1 px-3 py-2 bg-white border shadow-sm border-slate-300 placeholder-slate-400 focus:outline-none focus:border-sky-500 focus:ring-sky-500 block w-full rounded-md sm:text-sm focus:ring-1"
                    value="<?php echo htmlspecialchars($username);  ?>"
                    placeholder="Ví dụ: Nguyễn Quang Huy" />
                  <!-- <?php if (!empty($usernameError)) { ?>
                    <span class="text-sm text-red-700 ps-4 mt-1"><?php echo htmlspecialchars($usernameError) ?></span>
                  <?php } ?> -->
                </label>
              </div>
              <div class="py-1 mb-1">
                <label class="block">
                  <span class="after:content-['*'] after:ml-0.5 after:text-red-500 block text-sm font-medium text-gray-500 ms-2">
                    Email
                  </span>
                  <input type="email" name="email"
                    class="mt-1 px-3 py-2 bg-white border shadow-sm border-slate-300 placeholder-slate-400 focus:outline-none focus:border-sky-500 focus:ring-sky-500 block w-full rounded-md sm:text-sm focus:ring-1"
                    value="<?php echo htmlspecialchars($email); ?>"
                    placeholder="ví dụ: nguyenvana@gmail.com" />
                  <!-- <?php if (!empty($emailError)) { ?>
                    <span class="text-sm text-red-700 ps-4 mt-1"><?php echo htmlspecialchars($emailError) ?></span>
                  <?php } ?> -->
                </label>
              </div>
              <div class="py-1 mb-1">
                <label class="block">
                  <span class="after:content-['*'] after:ml-0.5 after:text-red-500 block text-sm font-medium text-gray-500 ms-2">
                    Password
                  </span>
                  <div class="relative">
                    <input type="password"
                      id="whr-login-password"
                      name="password"
                      class="mt-1 px-3 py-2 bg-white border shadow-sm border-slate-300 placeholder-slate-400 focus:outline-none focus:border-sky-500 focus:ring-sky-500 block w-full rounded-md sm:text-sm focus:ring-1"
                      placeholder="Ví dụ: NQH@!123" />
                    <div class="whr-show-hidden-pw-icon flex z-50">
                      <div class="cursor-pointer flex items-center justify-center" style="width: 24px;height: 24px;" id="togglePassword">
                        <div class="whr-show-pw-icon">
                          <i class="fa-regular fa-eye"></i>
                        </div>
                        <div class="whr-hidden-pw-icon hidden">
                          <i class="fa-regular fa-eye-slash"></i>
                        </div>
                      </div>
                    </div>
                  </div>
                  <!-- <?php if (!empty($passwordError)) { ?>
                    <span class="text-sm text-red-700 ps-4 mt-1"><?php echo htmlspecialchars($passwordError) ?></span>
                  <?php } ?> -->
                </label>
              </div>
              <div class="py-1 mb-1">
                <label class="block">
                  <span class="after:content-['*'] after:ml-0.5 after:text-red-500 block text-sm font-medium text-gray-500 ms-2">
                    Confirm Password
                  </span>
                  <div class="relative">
                    <input type="password" id="whr-login-cfpassword" name="cfpassword" class="mt-1 px-3 py-2 bg-white border shadow-sm border-slate-300 placeholder-slate-400 focus:outline-none focus:border-sky-500 focus:ring-sky-500 block w-full rounded-md sm:text-sm focus:ring-1" placeholder="Please enter your confirm password" />

                    <div class="whr-show-hidden-pw-icon flex z-50">
                      <div class="cursor-pointer flex items-center justify-center" style="width: 24px;height: 24px;" id="togglePassword">
                        <div class="whr-show-cfpw-icon">
                          <i class="fa-regular fa-eye"></i>
                        </div>
                        <div class="whr-hidden-cfpw-icon hidden">
                          <i class="fa-regular fa-eye-slash"></i>
                        </div>
                      </div>
                    </div>
                  </div>
                  <!-- <?php if (!empty($cfpasswordError)) { ?>
                    <span class="text-sm text-red-700 ps-4 mt-1"><?php echo htmlspecialchars($cfpasswordError) ?></span>
                  <?php } ?> -->
                </label>
              </div>
              <div class="flex justify-start my-1 pb-4">
                <label for="example-checkbox" class="inline-flex items-center space-x-2">
                  <input type="checkbox" id="example-checkbox" class="form-checkbox h-3 w-3 text-blue-600 border-gray-300 rounded focus:ring-2 focus:ring-blue-500" checked>
                  <span class="text-gray-400 text-sm">I agree to the terms and conditions</span>
                </label>
              </div>
              <div class="bg-purple-500 p-2 text-center rounded-full">
                <button type="submit" class="uppercase font-bold text-white w-full">register</button>
              </div>
            </form>
          </div>
          <div class="flex justify-center mt-3">
            <span class="text-sm text-gray-400">I have an account? <a href="<?php echo BASE_URL . '/dang-nhap' ?>" class="text-sky-500">Sign in</a></span>
          </div>
          <div class="flex flex-col items-center mt-3 pb-3">
            <span class="text-gray-400 text-sm">Or, log in with</span>
            <div class="flex justify-center mt-3">
              <div class="flex items-center text-sm text-gray-500 mr-4 cursor-pointer">
                <img src="./Public/images/icon/google-logo-6278331_960_720.webp" alt="" style="width: 22px;height: 22px;">
                <span class="ms-2">Google</span>
              </div>
              <div class="flex items-center text-sm text-gray-500 cursor-pointer">
                <img src="./Public/images/icon/2023_Facebook_icon.svg.png" alt="" style="width: 22px;height: 22px;">
                <span class="ms-2">Facebook</span>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <script src="<?php echo BASE_URL ?>/Public/fontawesome/js/all.min.js"></script>
  <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick.min.js" integrity="sha512-HGOnQO9+SP1V92SrtZfjqxxtLmVzqZpjFFekvzZVWoiASSQgSr4cw9Kqd2+l8Llp4Gm0G8GIFJ4ddwZilcdb8A==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
  <script src="<?php echo BASE_URL ?>/Public/js/bootstrap.bundle.min.js"></script>
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