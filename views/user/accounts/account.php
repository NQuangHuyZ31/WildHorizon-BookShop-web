<?php

use Helpers\Format;

include_once VIEW_PATH_USER_LAYOUT . 'header.php'; ?>

<div class="w-full xl:max-w-screen-xl xl:mx-auto">
  <div class="w-full mt-3 mb-3 min-h-[550px]">
    <div class="flex flex-col xl:mb-0 xl:flex-row w-full">
      <div class="xl:w-1/4">
        <?php include_once VIEW_PATH_USER_LAYOUT . 'sidebar-customer.php' ?>
      </div>
      <div class="flex-1 xl:ms-4">
        <div class="w-full bg-white rounded-md shadow-sm xl:shadow-md pb-4">
          <div class="img-account-content w-full">
            <img src="https://res.cloudinary.com/whr-clound/image/upload/v1745418122/twahnebk6fnag8thhydz.png" alt="" class="w-full h-full rounded-md">
          </div>
          <div class="grid grid-cols-1 xl:grid-cols-2 px-4 mt-2 w-full gap-2">
            <div class="bg-white rounded-md shadow-sm xl:shadow-lg mx-2 w-full p-4 border border-gray-100">
              <p class="text-[14px] xl:text-lg font-bold">Ưu đãi hiện tại</p>
              <div class="flex justify-between w-full mt-4">
                <div class="flex flex-col bg-slate-300/30 rounded-lg p-2 w-1/2 mx-2">
                  <p class="text-[12px] px-1 py-2 text-black">Voucher hiện có</p>
                  <p class="text-[14px] xl:text-lg p-1 text-red-600 font-semibold"><?php echo $countVoucher ?></p>
                </div>
                <div class="flex flex-col bg-slate-300/30 rounded-lg p-2 w-1/2 mx-2">
                  <p class="text-[12px] px-1 py-2 text-black">Freeship hiện có</p>
                  <p class="text-[14px] xl:text-lg p-1 text-red-600 font-semibold"><?php echo $countVoucherFreeShip ?></p>
                </div>
                <div>
                </div>
              </div>
            </div>
            <div class="bg-white rounded-md shadow-sm xl:shadow-lg mx-2 w-full gap-1 p-4 border border-gray-100">
              <p class="text-[14px] xl:text-lg font-bold">Thành tích năm <?php echo date('Y') ?></p>
              <div class="flex justify-between w-full mt-4">
                <div class="flex flex-col bg-slate-300/30 rounded-lg p-2 w-1/2 mx-2">
                  <p class="text-[12px] px-1 py-2 text-black">Đơn hàng đã đặt</p>
                  <p class="text-[14px] xl:text-lg p-1 text-red-600 font-semibold"><?php echo !empty($countOrder['countorder']) ? $countOrder['countorder'] : 0 ?> đơn hàng</p>
                </div>
                <div class="flex flex-col bg-slate-300/30 rounded-lg p-2 w-1/2 mx-2">
                  <p class="text-[12px] px-1 py-2 text-black">Tổng tiền đã tiêu</p>
                  <p class="text-[14px] xl:text-lg p-1 text-red-600 font-semibold"><?php echo $sumTotalOrder['totalprice'] != null ? Format::forMatPrice($sumTotalOrder['totalprice']) : 0 ?> đ</p>
                </div>
                <div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="w-full bg-white rounded-md shadow-sm xl:shadow-md p-4 mt-3">
          <input type="hidden" name="csrf_token" value="<?php echo $csrf_token ?>">
          <p class="text-[14px] xl:text-xl text-gray-500 font-bold">Hồ sơ cá nhân</p>
          <div class="w-full mt-3">
            <div class="w-full flex items-center py-3">
              <div class="profile-label text-[11px] xl:text-[12px] text-gray-500 after:content-['*'] after:ml-0.5 after:text-red-500 py-1">Họ tên</div>
              <input type="text" name="username" id="username" value="<?php echo $customer['username'] ?>" class="w-2/3 px-3 py-2 bg-white border shadow-sm border-slate-300 placeholder-slate-400 focus:outline-none focus:border-sky-500 focus:ring-sky-500 block rounded-md text-[11px] xl:text-sm focus:ring-1" placeholder="ví dụ: Nguyễn Văn A">
            </div>
            <div class="w-full flex items-center py-3">
              <div class="profile-label text-[11px] xl:text-[12px] text-gray-500 after:content-['*'] after:ml-0.5 after:text-red-500 py-1">Số điện thoại</div>
              <input type="text" name="phone" id="phone" value="<?php echo $customer['phone'] != null ? $customer['phone'] : '' ?>" class="w-2/3 px-3 py-2 bg-white border shadow-sm border-slate-300 placeholder-slate-400 focus:outline-none focus:border-sky-500 focus:ring-sky-500 block rounded-md text-[11px] xl:text-sm focus:ring-1" placeholder="ví dụ: 0366.465.273">
            </div>
            <div class="w-full flex items-center py-3">
              <div class="profile-label text-[11px] xl:text-[12px] text-gray-500 after:content-['*'] after:ml-0.5 after:text-red-500 py-1">Giới tính</div>
              <div class="flex">
                <input type="radio" name="gender" value="0" class="w-2/3 px-3 py-2 bg-white border shadow-sm border-slate-300 placeholder-slate-400" <?php echo $customer['gender'] !== null && $customer['gender'] == 0 ? 'checked' : ''; ?>>
                <label class="text-gray-500 ms-3 text-[11px] xl:text-[12px]">Nam</label>
              </div>
              <div class="flex ms-4">
                <input type="radio" name="gender" value="1" class="w-2/3 px-3 py-2 bg-white border shadow-sm border-slate-300 placeholder-slate-400" <?php echo $customer['gender'] !== null && $customer['gender'] == 1 ? 'checked' : ''; ?>>
                <label class="text-gray-500 ms-3 text-[11px] xl:text-[12px]">Nữ</label>
              </div>
            </div>
            <div class="w-full flex items-center py-3">
              <div class="profile-label text-[11px] xl:text-[12px] text-gray-500 after:content-['*'] after:ml-0.5 after:text-red-500 py-1">Ngày sinh</div>
              <div class="w-2/3 flex justify-around items-center text-center">
                <input
                  type="number"
                  min="1"
                  max="31"
                  name="day"
                  value="<?php echo $customer['birthday'] != null ? $day : '' ?>"
                  class="w-1/3 px-3 py-2 bg-white border shadow-sm border-slate-300 placeholder-slate-400 focus:outline-none focus:border-sky-500 focus:ring-sky-500 block rounded-md text-[11px] xl:text-[12px] focus:ring-1 mr-2"
                  placeholder="08"
                  <?php echo $customer['birthday'] != null ? 'readonly' : '' ?>>
                <input
                  type="number"
                  min="1"
                  max="12"
                  name="mounth"
                  value="<?php echo $customer['birthday'] != null ? $month : '' ?>"
                  class="w-1/3 px-3 py-2 bg-white border shadow-sm border-slate-300 placeholder-slate-400 focus:outline-none focus:border-sky-500 focus:ring-sky-500 block rounded-md text-[11px] xl:text-[12px] focus:ring-1 mr-2"
                  placeholder="08"
                  <?php echo $customer['birthday'] != null ? 'readonly' : '' ?>>
                <input
                  type="number"
                  name="year"
                  value="<?php echo $customer['birthday'] != null ? $year : '' ?>"
                  class="w-1/3 px-3 py-2 bg-white border shadow-sm border-slate-300 placeholder-slate-400 focus:outline-none focus:border-sky-500 focus:ring-sky-500 block rounded-md text-[11px] xl:text-[12px] focus:ring-1"
                  placeholder="2003"
                  <?php echo $customer['birthday'] != null ? 'readonly' : '' ?>>
              </div>
            </div>
          </div>
          <div class="w-full text-center mt-2 p-2">
            <button type="button" id="btn-update-customer" class="px-11 py-2 text-[12px] xl:text-[15px] text-white bg-red-700 rounded-lg font-semibold xl:px-14">Lưu thay đổi</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<?php include_once VIEW_PATH_USER_LAYOUT . 'footer.php'; ?>