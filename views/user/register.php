<?php

use Core\Session;

if(Session::has('user') && Session::get('user')['role'] == 'customer'){

  header('location: '.Session::get('current_url').'');
}

if (!empty($_SESSION['error'])) {
  $errors = $_SESSION['error'] ?? [];
}

if (!empty($_SESSION['data'])) {
  $data = $_SESSION['data'] ?? [];
}

// lấy dữ liệu form
$username_hodem = $data['hodem'] ?? '';
$username = $data['username'] ?? '';
$email = $data['email'] ?? '';
// Lấy lỗi 
$usernameError = $errors['username'] ?? '';
$username_hodemError = $errors['hodem'] ?? '';
$emailError = $errors['email'] ?? '';
$passwordError = $errors['password'] ?? '';
$cfpasswordError = $errors['cfpassword'] ?? '';
// Xóa session
Core\Session::delete('error');
Core\Session::delete('data');
// Tạo token

$csrf_token = Core\CSRF::generateToken();

?>

<?php include_once('layout/header-no-content.php') ?>
<div class="container-fuild mx-auto">
  <div class="flex justify-center items-center py-10 p-6">
    <div class="bg-white whr-register rounded-md shadow-lg py-5">
      <div class="mb-3 text-center border-b-2 border-gray-200 shadow-sm pb-2">
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
          <div class="py-1 mb-3 flex">
            <label class="block mr-2">
              <span class="after:content-['*'] after:ml-0.5 after:text-red-500 block text-sm font-medium text-slate-700">
                Họ đệm
              </span>
              <input type="text" name="hodem"
                class="mt-1 px-3 py-2 bg-white border shadow-sm border-slate-300 placeholder-slate-400 focus:outline-none focus:border-sky-500 focus:ring-sky-500 block w-full rounded-md sm:text-sm focus:ring-1"
                value="<?php echo htmlspecialchars($username_hodem);  ?>"
                placeholder="Please enter your name" />
              <?php if (!empty($username_hodemError)) { ?>
                <span class="text-sm text-red-700 ps-4 mt-1"><?php echo htmlspecialchars($username_hodemError) ?></span>
              <?php } ?>
            </label>
            <label class="block">
              <span class="after:content-['*'] after:ml-0.5 after:text-red-500 block text-sm font-medium text-slate-700">
                Tên người dùng
              </span>
              <input type="text" name="username"
                class="mt-1 px-3 py-2 bg-white border shadow-sm border-slate-300 placeholder-slate-400 focus:outline-none focus:border-sky-500 focus:ring-sky-500 block w-full rounded-md sm:text-sm focus:ring-1"
                value="<?php echo htmlspecialchars($username);  ?>"
                placeholder="Please enter your name" />
              <?php if (!empty($usernameError)) { ?>
                <span class="text-sm text-red-700 ps-4 mt-1"><?php echo htmlspecialchars($usernameError) ?></span>
              <?php } ?>
            </label>
          </div>
          <div class="py-1 mb-3">
            <label class="block">
              <span class="after:content-['*'] after:ml-0.5 after:text-red-500 block text-sm font-medium text-slate-700">
                Email
              </span>
              <input type="email" name="email"
                class="mt-1 px-3 py-2 bg-white border shadow-sm border-slate-300 placeholder-slate-400 focus:outline-none focus:border-sky-500 focus:ring-sky-500 block w-full rounded-md sm:text-sm focus:ring-1"
                value="<?php echo htmlspecialchars($email); ?>"
                placeholder="Please enter your email" />
              <?php if (!empty($emailError)) { ?>
                <span class="text-sm text-red-700 ps-4 mt-1"><?php echo htmlspecialchars($emailError) ?></span>
              <?php } ?>
            </label>
          </div>
          <div class="py-1 mb-3">
            <label class="block">
              <span class="block text-sm font-medium text-slate-700">
                Password
              </span>
              <div class="relative">
                <input type="password" id="whr-login-password" name="password" class="mt-1 px-3 py-2 bg-white border shadow-sm border-slate-300 placeholder-slate-400 focus:outline-none focus:border-sky-500 focus:ring-sky-500 block w-full rounded-md sm:text-sm focus:ring-1" placeholder="Please enter your password" />

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
              <?php if (!empty($passwordError)) { ?>
                <span class="text-sm text-red-700 ps-4 mt-1"><?php echo htmlspecialchars($passwordError) ?></span>
              <?php } ?>
            </label>
          </div>
          <div class="py-1 mb-3">
            <label class="block">
              <span class="block text-sm font-medium text-slate-700">
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
              <?php if (!empty($cfpasswordError)) { ?>
                <span class="text-sm text-red-700 ps-4 mt-1"><?php echo htmlspecialchars($cfpasswordError) ?></span>
              <?php } ?>
            </label>
          </div>
          <div class="flex justify-start my-1 pb-4">
            <label for="example-checkbox" class="inline-flex items-center space-x-2">
              <input type="checkbox" id="example-checkbox" class="form-checkbox h-3 w-3 text-blue-600 border-gray-300 rounded focus:ring-2 focus:ring-blue-500" checked>
              <span class="text-gray-400 text-sm">I agree to the terms and conditions</span>
            </label>
          </div>
          <div class="bg-orange-500 p-2 text-center rounded-md">
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


<?php include_once('layout/footer.php') ?>