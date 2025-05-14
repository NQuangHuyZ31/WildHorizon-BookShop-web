<?php

use Core\Session;

// var_dump($_SESSION);
include_once VIEW_PATH_USER_LAYOUT . 'header.php'; ?>

<div class="w-full xl:max-w-screen-xl xl:mx-auto">
  <div class="w-full mt-3 mb-3 min-h-[550px]">
    <div class="flex flex-col xl:mb-0 xl:flex-row w-full">
      <div class="hidden xl:block xl:w-1/4">
        <?php include_once VIEW_PATH_USER_LAYOUT . 'sidebar-customer.php' ?>
      </div>
      <div class="flex-1 px-1 xl:ms-4">
        <div class="bg-white rounded-md shadow-sm xl:shadow-lg xl:mx-2 w-full p-4 border border-gray-100">
          <p class="text-[14px] xl:text-lg font-bold">Xác nhận đổi mật khẩu</p>
          <div class="mt-3">
            <form action="<?php echo BASE_URL ?>/customer/changepassword/verify" method="post">
              <input type="hidden" name="csrf_token" value="<?php echo $csrf_token ?>">
              <div class="w-full flex items-center py-3">
                <div class="profile-label text-[11px] xl:text-[13px] text-gray-500 after:content-['*'] after:ml-0.5 after:text-red-500 py-1 mr-2">Mật khẩu mới</div>
                <input
                  type="password"
                  name="new_password"
                  value="<?php echo Session::get('data')['new_password'] != null ? Session::get('data')['new_password'] : '' ?>"
                  class="w-2/3 px-3 py-2 bg-white border shadow-sm border-slate-300 placeholder-slate-400 focus:outline-none focus:border-sky-500 focus:ring-sky-500 block rounded-md text-[11px] xl:text-[13px] focus:ring-1"
                  placeholder="Mật khẩu mới"
                  readonly>
              </div>
              <div class="w-full flex items-center py-3">
                <div class="profile-label text-[11px] xl:text-[13px] text-gray-500 after:content-['*'] after:ml-0.5 after:text-red-500 py-1 mr-2">Nhập lại mật khẩu mới</div>
                <input
                  type="password"
                  name="confirm_new_password"
                  value="<?php echo Session::get('data')['cf_new_passowrd'] != null ? Session::get('data')['cf_new_passowrd'] : '' ?>"
                  class="w-2/3 px-3 py-2 bg-white border shadow-sm border-slate-300 placeholder-slate-400 focus:outline-none focus:border-sky-500 focus:ring-sky-500 block rounded-md text-[11px] xl:text-[13px] focus:ring-1"
                  placeholder="Nhập lại mật khẩu mới"
                  readonly>
              </div>
              <div class="w-full flex items-center py-3">
                <div class="profile-label text-[11px] xl:text-[13px] text-gray-500 after:content-['*'] after:ml-0.5 after:text-red-500 py-1 mr-2">Nhập mã xác nhận</div>
                <div class="p-1">
                  <div class="flex items-center gap-3">
                    <input
                      type="text"
                      name="code_verify[]"
                      class="w-10 h-10 text-center text-[12px] xl:text-[14px] font-extrabold text-slate-900 bg-slate-100 border border-transparent hover:border-slate-200 appearance-none rounded p-2 outline-none focus:bg-white focus:border-indigo-400 focus:ring-2 focus:ring-indigo-100"
                      maxlength="1" />
                    <input
                      type="text"
                      name="code_verify[]"
                      class="w-10 h-10 text-center text-[12px] xl:text-[14px] font-extrabold text-slate-900 bg-slate-100 border border-transparent hover:border-slate-200 appearance-none rounded p-2 outline-none focus:bg-white focus:border-indigo-400 focus:ring-2 focus:ring-indigo-100"
                      maxlength="1" />
                    <input
                      type="text"
                      name="code_verify[]"
                      class="w-10 h-10 text-center text-[12px] xl:text-[14px] font-extrabold text-slate-900 bg-slate-100 border border-transparent hover:border-slate-200 appearance-none rounded p-2 outline-none focus:bg-white focus:border-indigo-400 focus:ring-2 focus:ring-indigo-100"
                      maxlength="1" />
                    <input
                      type="text"
                      name="code_verify[]"
                      class="w-10 h-10 text-center text-[12px] xl:text-[14px] font-extrabold text-slate-900 bg-slate-100 border border-transparent hover:border-slate-200 appearance-none rounded p-2 outline-none focus:bg-white focus:border-indigo-400 focus:ring-2 focus:ring-indigo-100"
                      maxlength="1" />
                  </div>
                </div>
              </div>
              <div class="mt-2">
                <p class="p-1 text-[11px] xl:text-[13px] text-gray-400">Mã xác minh được gửi về email bạn đăng ký tài khoản. Vui lòng kiểm tra.</p>
                <p class="p-1 text-[11px] xl:text-[13px] text-gray-400">Bạn chưa nhận được mã?
                  <span class="text-[12px] xl:text-[14px] text-blue-700 font-semibold cursor-pointer" id="btn-otp-resend">
                    Gửi lại
                  </span>
                </p>
              </div>
              <div class="flex justify-end text-center">
                <button type="submit" class="px-11 py-2 text-[12px] xl:text-[15px] text-white bg-red-700 rounded-lg font-semibold xl:px-14">
                  Xác nhận
                </button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<?php include_once VIEW_PATH_USER_LAYOUT . 'footer.php'; ?>


<!-- <div class="container-fuild mx-auto">
  <div class="flex-1 ms-3">
    <div class="flex justify-center">
      <div class="max-w-md mx-auto text-center bg-white px-4 sm:px-8 py-10 rounded-xl shadow">
        <header class="mb-8">
          <h1 class="text-2xl font-bold mb-1">Mobile Phone Verification</h1>
          <p class="text-[15px] text-slate-500">Enter the 4-digit verification code that was sent to your phone number.</p>
        </header>
        <form id="otp-form">
          <div class="flex items-center justify-center gap-3">
            <input
              type="text"
              class="w-14 h-14 text-center text-2xl font-extrabold text-slate-900 bg-slate-100 border border-transparent hover:border-slate-200 appearance-none rounded p-4 outline-none focus:bg-white focus:border-indigo-400 focus:ring-2 focus:ring-indigo-100"
              pattern="\d*" maxlength="1" />
            <input
              type="text"
              class="w-14 h-14 text-center text-2xl font-extrabold text-slate-900 bg-slate-100 border border-transparent hover:border-slate-200 appearance-none rounded p-4 outline-none focus:bg-white focus:border-indigo-400 focus:ring-2 focus:ring-indigo-100"
              maxlength="1" />
            <input
              type="text"
              class="w-14 h-14 text-center text-2xl font-extrabold text-slate-900 bg-slate-100 border border-transparent hover:border-slate-200 appearance-none rounded p-4 outline-none focus:bg-white focus:border-indigo-400 focus:ring-2 focus:ring-indigo-100"
              maxlength="1" />
            <input
              type="text"
              class="w-14 h-14 text-center text-2xl font-extrabold text-slate-900 bg-slate-100 border border-transparent hover:border-slate-200 appearance-none rounded p-4 outline-none focus:bg-white focus:border-indigo-400 focus:ring-2 focus:ring-indigo-100"
              maxlength="1" />
          </div>
          <div class="max-w-[260px] mx-auto mt-4">
            <button type="submit"
              class="w-full inline-flex justify-center whitespace-nowrap rounded-lg bg-indigo-500 px-3.5 py-2.5 text-sm font-medium text-white shadow-sm shadow-indigo-950/10 hover:bg-indigo-600 focus:outline-none focus:ring focus:ring-indigo-300 focus-visible:outline-none focus-visible:ring focus-visible:ring-indigo-300 transition-colors duration-150">Verify
              Account</button>
          </div>
        </form>
        <div class="text-sm text-slate-500 mt-4">Didn't receive code? <a class="font-medium text-indigo-500 hover:text-indigo-600" href="#0">Resend</a></div>
      </div>
    </div>
  </div>
</div> -->