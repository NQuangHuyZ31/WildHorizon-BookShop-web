<div class="c-sidebar bg-white mb-3 py-3 xl:mb-0 xl:w-full rounded-lg xl:shadow-md">
  <div class="">
    <div class="text-center mt-3 border-b border-gray-200 p-3">
      <div class="w-full align-middle">
        <img src="https://res.cloudinary.com/whr-clound/image/upload/v1745417547/okynapkvmccrm57mo7wf.png" alt="" class="customer-icon mx-auto opacity-75">
      </div>
      <div class="p-2 mt-2">
        <p class="font-bold tracking-wide text-sm xl:text-lg"><?php echo $customer['username'] ?></p>
      </div>
    </div>
    <ul class="menu w-full">
      <li>
        <details>
          <summary class="ps-0 border-s-4 <?php echo in_array(basename($_SERVER['REQUEST_URI']), ['account', 'changepassword', 'specialevent'])
                                            || strpos($_SERVER['REQUEST_URI'], '/address') !== false
                                            || strpos($_SERVER['REQUEST_URI'], '/changepassword') !== false ? 'border-red-700' : 'border-white' ?>">
            <div class="flex items-center ps-0">
              <div class="mx-2 text-center text-lg text-gray-500" style="height: 24px;width: 24px;">
                <i class="fa-solid fa-user"></i>
              </div>
              <!-- <a class="w-full" href="<?php echo BASE_URL ?>/customer/account"> -->
              <p class="text-[12px] xl:text-sm pt-1 mx-2 hover:text-orange-400 
            <?php echo in_array(basename($_SERVER['REQUEST_URI']), ['account', 'changepassword', 'specialevent'])
              || strpos($_SERVER['REQUEST_URI'], '/address')
              || strpos($_SERVER['REQUEST_URI'], '/changepassword') !== false ? 'text-red-700 font-bold' : '' ?>">Thông tin tài khoản</p>
              <!-- </a> -->
              <!-- <i class="fa-solid fa-chevron-down pt-1 text-gray-500"></i> -->
            </div>
          </summary>
          <ul>
            <li>
              <div class="flex items-center ps-0">
                <div class="mx-2 text-center text-lg text-gray-500" style="height: 24px;width: 24px;">
                </div>
                <a class="w-full" href="<?php echo BASE_URL ?>/customer/account">
                  <p class="text-[12px] xl:text-sm pt-1 mx-2 hover:text-orange-400 <?php echo strpos($_SERVER['REQUEST_URI'], '/account') !== false ? 'text-red-700' : 'text-gray-600' ?>">Hồ sơ cá nhân</p>
                </a>
              </div>
            </li>
            <li>
              <div class="flex items-center ps-0">
                <div class="mx-2 text-center text-lg text-gray-500" style="height: 24px;width: 24px;">
                </div>
                <a class="w-full" href="<?php echo BASE_URL ?>/customer/address">
                  <p class="text-[12px] xl:text-sm pt-1 mx-2 hover:text-orange-400 
              <?php echo strpos($_SERVER['REQUEST_URI'], '/address') !== false ? 'text-red-700' : 'text-gray-600' ?>">Sổ địa chỉ</p>
                </a>
              </div>
            </li>
            <li>
              <div class="flex items-center ps-0">
                <div class="mx-2 text-center text-lg text-gray-500" style="height: 24px;width: 24px;">
                </div>
                <a class="w-full" href="<?php echo BASE_URL ?>/customer/changepassword">
                  <p class="text-[12px] xl:text-sm pt-1 mx-2 hover:text-orange-400 
              <?php echo strpos($_SERVER['REQUEST_URI'], '/changepassword') !== false ? 'text-red-700' : 'text-gray-600' ?>">Đổi mật khẩu</p>
                </a>
              </div>
            </li>
            <li>
              <div class="flex items-center ps-0">
                <div class="mx-2 text-center text-lg text-gray-500" style="height: 24px;width: 24px;">
                </div>
                <a class="w-full" href="<?php echo BASE_URL ?>/customer/specialevent">
                  <p class="text-[12px] xl:text-sm pt-1 mx-2 hover:text-orange-400 
              <?php echo strpos($_SERVER['REQUEST_URI'], '/specialevent') !== false ? 'text-red-700' : 'text-gray-600' ?>">Sự kiện</p>
                </a>
              </div>
            </li>
          </ul>
        </details>
      </li>
      <a class="w-full" href="<?php echo BASE_URL ?>/customer/order">
        <li class="border-s-4 rounded-md
          <?php echo strpos($_SERVER['REQUEST_URI'], '/order') ? 'border-red-700' : 'border-white' ?>">
          <div class="flex items-center ps-0">
            <div class="mx-2 text-center text-lg text-gray-500" style="height: 24px;width: 24px;">
              <i class="fa-solid fa-box"></i>
            </div>
            <p class="text-[12px] xl:text-sm pt-1 mx-2 hover:text-orange-400 
          <?php echo strpos($_SERVER['REQUEST_URI'], '/order') ? 'text-red-700 font-bold' : 'text-gray-600' ?>">Đơn hàng của tôi</p>
          </div>
        </li>
      </a>
      <a class="w-full" href="<?php echo BASE_URL ?>/customer/voucher">
        <li class="border-s-4 rounded-md
        <?php echo strpos($_SERVER['REQUEST_URI'], '/voucher') ? 'border-red-700' : 'border-white' ?>">
          <div class="flex items-center ps-0">
            <div class="mx-2 text-center text-lg text-gray-500" style="height: 24px;width: 24px;">
              <i class="fa-solid fa-ticket"></i>
            </div>
            <p class="text-[12px] xl:text-sm pt-1 mx-2 hover:text-orange-400 
          <?php echo strpos($_SERVER['REQUEST_URI'], '/voucher') ? 'text-red-700 font-bold' : 'text-gray-600' ?>">Ví voucher</p>
          </div>
        </li>
      </a>
      <a class="w-full" href="<?php echo BASE_URL ?>/customer/wishlist">
        <li class="border-s-4 rounded-md
      <?php echo strpos($_SERVER['REQUEST_URI'], '/wishlist') ? 'border-red-700' : 'border-white' ?>">
          <div class="flex items-center ps-0">
            <div class="mx-2 text-center text-lg text-gray-500" style="height: 24px;width: 24px;">
              <i class="fa-solid fa-heart"></i>
            </div>
            <p class="text-[12px] xl:text-sm pt-1 mx-2 hover:text-orange-400 
          <?php echo strpos($_SERVER['REQUEST_URI'], '/wishlist') ? 'text-red-700 font-bold' : 'text-gray-600' ?>">Sản phẩm yêu thích</p>
          </div>
        </li>
      </a>
      <a class="w-full" href="<?php echo BASE_URL ?>/customer/review">
        <li class="border-s-4 rounded-md
        <?php echo strpos($_SERVER['REQUEST_URI'], '/review') ? 'border-red-700' : 'border-white' ?>">
          <div class="flex items-center ps-0">
            <div class="mx-2 text-center text-lg text-gray-500" style="height: 24px;width: 24px;">
              <i class="fa-solid fa-star"></i>
            </div>
            <p class="text-[12px] xl:text-sm pt-1 mx-2 hover:text-orange-400 
          <?php echo strpos($_SERVER['REQUEST_URI'], '/review') ? 'text-red-700 font-bold' : 'text-gray-600' ?>">Nhận xét của tôi</p>
          </div>
        </li>
      </a>
      <form action="<?php echo BASE_URL ?>/dang-xuat" method="post" class="w-full text-center mt-2 block xl:hidden text-[13px] xl:text-sm ">
        <input type="hidden" name="csrf_token" value="<?php echo $csrf_token ?>">
        <li class="text-center block">
          <button type="submit" class="w-full bg-red-700 text-white flex justify-center items-center">
            <span>Đăng xuất</span>
          </button>
        </li>
      </form>
    </ul>
  </div>
</div>