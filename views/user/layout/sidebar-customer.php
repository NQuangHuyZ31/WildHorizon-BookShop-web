<div class="c-sidebar bg-white w-1/4 rounded-lg shadow-md py-3">
  <div class="text-center mt-3 border-b border-gray-200 p-3">
    <div class="w-full align-middle">
      <img src="<?php echo BASE_URL ?>/Public/images/icon/user.png" alt="" class="customer-icon mx-auto opacity-75">
    </div>
    <div class="p-2 mt-2">
      <p class="font-bold tracking-wide text-lg"><?php echo $customer['username'] ?></p>
    </div>
  </div>
  <div class="mt-2">
    <div class="py-2">
      <li class="list-none border-s-6  flex items-center <?php echo in_array(basename($_SERVER['REQUEST_URI']), ['account', 'changepassword', 'address', 'specialoffer']) ? 'border-red-700' : 'border-white' ?>">
        <div class="flex items-center">
          <div class="mx-2 text-center text-lg text-gray-500" style="height: 24px;width: 24px;">
            <i class="fa-solid fa-user"></i>
          </div>
          <a href="<?php echo BASE_URL ?>/customer/account">
            <p class="text-sm pt-1 mx-2 hover:text-orange-400 <?php echo in_array(basename($_SERVER['REQUEST_URI']), ['account', 'changepassword', 'address', 'specialoffer']) ? 'text-red-700 font-bold' : '' ?>">Thông tin tài khoản</p>
          </a>
          <i class="fa-solid fa-chevron-down pt-1 text-gray-500"></i>
        </div>
      </li>
    </div>
    <div class="<?php echo in_array(basename($_SERVER['REQUEST_URI']), ['account', 'changepassword', 'address', 'specialoffer']) ? 'block' : 'hidden' ?>">
      <div class="py-2">
        <li class="list-none border-s-6 border-white flex items-center ">
          <div class="flex items-center">
            <div class="mx-2 text-center text-lg text-gray-500" style="height: 24px;width: 24px;">
            </div>
            <a href="<?php echo BASE_URL ?>/customer/account">
              <p class="text-sm pt-1 mx-2 hover:text-orange-400 <?php echo basename($_SERVER['REQUEST_URI']) == 'account' ? 'text-red-700' : 'text-gray-600' ?>">Hồ sơ cá nhân</p>
            </a>
          </div>
        </li>
      </div>
      <div class="py-2">
        <li class="list-none border-s-6 border-white flex items-center ">
          <div class="flex items-center">
            <div class="mx-2 text-center text-lg text-gray-500" style="height: 24px;width: 24px;">
            </div>
            <a href="<?php echo BASE_URL ?>/customer/address">
              <p class="text-sm pt-1 mx-2 hover:text-orange-400 <?php echo basename($_SERVER['REQUEST_URI']) == 'address' ? 'text-red-700' : 'text-gray-600' ?>">Sổ địa chỉ</p>
            </a>
          </div>
        </li>
      </div>
      <div class="py-2">
        <li class="list-none border-s-6 border-white flex items-center ">
          <div class="flex items-center">
            <div class="mx-2 text-center text-lg text-gray-500" style="height: 24px;width: 24px;">
            </div>
            <a href="<?php echo BASE_URL ?>/customer/changepassword">
              <p class="text-sm pt-1 mx-2 hover:text-orange-400 <?php echo basename($_SERVER['REQUEST_URI']) == 'changepassword' ? 'text-red-700' : 'text-gray-600' ?>">Đổi mật khẩu</p>
            </a>
          </div>
        </li>
      </div>
      <div class="py-2">
        <li class="list-none border-s-6 border-white flex items-center ">
          <div class="flex items-center">
            <div class="mx-2 text-center text-lg text-gray-500" style="height: 24px;width: 24px;">
            </div>
            <a href="<?php echo BASE_URL ?>/customer/specialoffer">
              <p class="text-sm pt-1 mx-2 hover:text-orange-400 <?php echo basename($_SERVER['REQUEST_URI']) == 'specialoffer' ? 'text-red-700' : 'text-gray-600' ?>">Ưu đãi</p>
            </a>
          </div>
        </li>
      </div>
    </div>
  </div>
  <div class="py-2">
    <li class="list-none border-s-6 flex items-center <?php echo basename($_SERVER['REQUEST_URI']) == 'order' ? 'border-red-700' : 'border-white' ?>">
      <div class="flex items-center">
        <div class="mx-2 text-center text-lg text-gray-500" style="height: 24px;width: 24px;">
          <i class="fa-solid fa-box"></i>
        </div>
        <a href="<?php echo BASE_URL ?>/customer/order">
          <p class="text-sm pt-1 mx-2 hover:text-orange-400 <?php echo basename($_SERVER['REQUEST_URI']) == 'order' ? 'text-red-700 font-bold' : 'text-gray-600' ?>">Đơn hàng của tôi</p>
        </a>
      </div>
    </li>
  </div>
  <div class="py-2">
    <li class="list-none border-s-6 flex items-center <?php echo basename($_SERVER['REQUEST_URI']) == 'voucher' ? 'border-red-700' : 'border-white' ?>">
      <div class="flex items-center">
        <div class="mx-2 text-center text-lg text-gray-500" style="height: 24px;width: 24px;">
          <i class="fa-solid fa-ticket"></i>
        </div>
        <a href="<?php echo BASE_URL ?>/customer/voucher">
          <p class="text-sm pt-1 mx-2 hover:text-orange-400 <?php echo basename($_SERVER['REQUEST_URI']) == 'voucher' ? 'text-red-700 font-bold' : 'text-gray-600' ?>">Ví voucher</p>
        </a>
      </div>
    </li>
  </div>
  <div class="py-2">
    <li class="list-none border-s-6 flex items-center <?php echo basename($_SERVER['REQUEST_URI']) == 'wishlist' ? 'border-red-700' : 'border-white' ?>">
      <div class="flex items-center">
        <div class="mx-2 text-center text-lg text-gray-500" style="height: 24px;width: 24px;">
          <i class="fa-solid fa-heart"></i>
        </div>
        <a href="<?php echo BASE_URL ?>/customer/wishlist">
          <p class="text-sm pt-1 mx-2 hover:text-orange-400 <?php echo basename($_SERVER['REQUEST_URI']) == 'wishlist' ? 'text-red-700 font-bold' : 'text-gray-600' ?>">Sản phẩm yêu thích</p>
        </a>
      </div>
    </li>
  </div>
  <div class="py-2">
    <li class="list-none border-s-6 flex items-center <?php echo basename($_SERVER['REQUEST_URI']) == 'review' ? 'border-red-700' : 'border-white' ?>">
      <div class="flex items-center">
        <div class="mx-2 text-center text-lg text-gray-500" style="height: 24px;width: 24px;">
          <i class="fa-solid fa-star"></i>
        </div>
        <a href="<?php echo BASE_URL ?>/customer/review">
          <p class="text-sm pt-1 mx-2 hover:text-orange-400 <?php echo basename($_SERVER['REQUEST_URI']) == 'review' ? 'text-red-700 font-bold' : 'text-gray-600' ?>">Nhận xét của tôi</p>
        </a>
      </div>
    </li>
  </div>
</div>