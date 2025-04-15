<?php include_once VIEW_PATH_USER_LAYOUT . 'header.php' ?>

<div class="container-fuild mx-auto">
  <div class="w-full mt-3 mb-3">
    <div class="flex w-full">
      <?php include_once VIEW_PATH_USER_LAYOUT . 'sidebar-customer.php' ?>
      <div class="flex-1 ms-4">
        <div class="bg-white rounded-md shadow-lg mx-2 w-full p-4 border border-gray-100">
          <p class="text-lg font-bold">Đổi mật khẩu</p>
          <div class="mt-3">
            <input type="hidden" name="csrf_token" value="<?php echo $csrf_token ?>">
            <div class="w-full flex items-center py-3">
              <div class="profile-label text-[12px] text-gray-500 after:content-['*'] after:ml-0.5 after:text-red-500 py-1">Mật khẩu hiện tại</div>
              <input
                type="password"
                name="old_password"
                id="old_password"
                value=""
                class="w-2/3 px-3 py-2 bg-white border shadow-sm border-slate-300 placeholder-slate-400 focus:outline-none focus:border-sky-500 focus:ring-sky-500 block rounded-md sm:text-[12px] focus:ring-1"
                placeholder="Mật khẩu hiện tại">
            </div>
            <div class="w-full flex items-center py-3">
              <div class="profile-label text-[12px] text-gray-500 after:content-['*'] after:ml-0.5 after:text-red-500 py-1">Mật khẩu mới</div>
              <input
                type="password"
                name="new_password"
                id="new_password"
                value=""
                class="w-2/3 px-3 py-2 bg-white border shadow-sm border-slate-300 placeholder-slate-400 focus:outline-none focus:border-sky-500 focus:ring-sky-500 block rounded-md sm:text-[12px] focus:ring-1"
                placeholder="Mật khẩu mới">
            </div>
            <div class="w-full flex items-center py-3">
              <div class="profile-label text-[12px] text-gray-500 after:content-['*'] after:ml-0.5 after:text-red-500 py-1">Nhập lại mật khẩu mới</div>
              <input
                type="password"
                name="confirm_new_password"
                id="confirm_new_password"
                value=""
                class="w-2/3 px-3 py-2 bg-white border shadow-sm border-slate-300 placeholder-slate-400 focus:outline-none focus:border-sky-500 focus:ring-sky-500 block rounded-md sm:text-[12px] focus:ring-1"
                placeholder="Nhập lại mật khẩu mới">
            </div>
          </div>
          <div class="flex justify-end mt-3 text-center">
            <button type="button" id="btn-changepw" class="px-14 py-2 text-[14px] text-white bg-red-700 rounded-lg font-semibold">
              Lưu thay đổi
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<?php include_once VIEW_PATH_USER_LAYOUT . 'footer.php'; ?>