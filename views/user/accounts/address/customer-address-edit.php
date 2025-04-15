<?php include_once VIEW_PATH_USER_LAYOUT . 'header.php'; ?>

<div class="container-fuild mx-auto">
  <div class="w-full mt-3 mb-3">
    <div class="flex w-full">
      <?php include_once VIEW_PATH_USER_LAYOUT . 'sidebar-customer.php' ?>
      <div class="flex-1 ms-4">
        <div class="w-full bg-white rounded-md shadow-md pb-4">
          <div class="p-4">
            <p class="text-lg font-bold text-slate-500">Chỉnh sửa thông tin địa chỉ</p>
            <input type="hidden" name="csrf_token" value="<?php echo $csrf_token ?>">
            <div class="pb-4 border-b border-slate-200">
              <div class="w-full flex items-center py-3">
                <div class="profile-label text-sm text-gray-500 after:content-['*'] after:ml-0.5 after:text-red-500 py-1">Họ tên</div>
                <input type="text" name="username" id="username" value="<?php echo $address['username'] ?>" class="w-2/3 px-3 py-2 bg-white border shadow-sm border-slate-300 placeholder-slate-400 focus:outline-none focus:border-sky-500 focus:ring-sky-500 block rounded-md sm:text-sm focus:ring-1" placeholder="ví dụ: Nguyễn Văn A">
              </div>
              <div class="w-full flex items-center py-3">
                <div class="profile-label text-sm text-gray-500 after:content-['*'] after:ml-0.5 after:text-red-500 py-1">Số điện thoại</div>
                <input type="text" name="phone" id="phone" value="<?php echo $address['phone'] ?>" class="w-2/3 px-3 py-2 bg-white border shadow-sm border-slate-300 placeholder-slate-400 focus:outline-none focus:border-sky-500 focus:ring-sky-500 block rounded-md sm:text-sm focus:ring-1" placeholder="ví dụ: 0366465273">
              </div>
              <div class="w-full flex items-center py-3">
                <div class="profile-label text-sm text-gray-500 after:content-['*'] after:ml-0.5 after:text-red-500 py-1">Tỉnh/Thành phố</div>
                <select
                  name="province"
                  id="province"
                  data-province="<?php echo $address['province'] ?>"
                  class="w-2/3 px-3 py-2 bg-white border shadow-sm border-slate-300 placeholder-slate-400 focus:outline-none focus:border-sky-500 focus:ring-sky-500 block rounded-md sm:text-sm focus:ring-1">
                  <option value="">Chọn tỉnh/thành phố</option>
                </select>
              </div>
              <div class="w-full flex items-center py-3">
                <div class="profile-label text-sm text-gray-500 after:content-['*'] after:ml-0.5 after:text-red-500 py-1">Quận/huyện</div>
                <select
                  name="district"
                  id="district"
                  data-district="<?php echo $address['district'] ?>"
                  class="w-2/3 px-3 py-2 bg-white border shadow-sm border-slate-300 placeholder-slate-400 focus:outline-none focus:border-sky-500 focus:ring-sky-500 block rounded-md sm:text-sm focus:ring-1">
                  <option value="">Chọn quận/huyện</option>
                </select>
              </div>
              <div class="w-full flex items-center py-3">
                <div class="profile-label text-sm text-gray-500 after:content-['*'] after:ml-0.5 after:text-red-500 py-1">Phường/xã</div>
                <select
                  name="ward"
                  id="ward"
                  data-ward="<?php echo $address['ward'] ?>"
                  class="w-2/3 px-3 py-2 bg-white border shadow-sm border-slate-300 placeholder-slate-400 focus:outline-none focus:border-sky-500 focus:ring-sky-500 block rounded-md sm:text-sm focus:ring-1">
                  <option value="">Chọn phường/xã</option>
                </select>
              </div>
              <div class="w-full flex items-center py-3">
                <div class="profile-label text-sm text-gray-500 after:content-['*'] after:ml-0.5 after:text-red-500 py-1">Địa chỉ</div>
                <input
                  type="text"
                  name="address"
                  id="address"
                  data-id="<?php echo $address['id'] ?>"
                  value="<?php echo $address['address'] ?>"
                  class="w-2/3 px-3 py-2 bg-white border shadow-sm border-slate-300 placeholder-slate-400 focus:outline-none focus:border-sky-500 focus:ring-sky-500 block rounded-md sm:text-sm focus:ring-1" placeholder="ví dụ: 123 nguyễn văn bảo">
              </div>
            </div>
            <div class="mt-2">
              <div class="flex items-center">
                <input type="checkbox" value="1" name="default_address" <?php echo $address['default_address'] == 1 ? 'checked disabled' : '' ?>>
                <div class="ms-2 text-sm text-gray-400">Đặt làm địa chỉ mặt định</div>
              </div>
              <div class="flex justify-end mt-3 text-center">
                <button type="button" id="btn-update-address" class="px-14 py-2 text-white bg-red-700 rounded-lg font-semibold">Lưu thay đổi</button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<?php include_once VIEW_PATH_USER_LAYOUT . 'footer.php'; ?>