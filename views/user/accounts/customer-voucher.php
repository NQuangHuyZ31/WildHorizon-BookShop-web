<?php

use Helpers\Format;

include_once VIEW_PATH_USER_LAYOUT . 'header.php'; ?>

<div class="w-full xl:max-w-screen-xl xl:mx-auto">
  <div class="w-full py-3">
    <div class="flex flex-col xl:mb-0 xl:flex-row w-full">
      <div class="xl:w-1/4">
        <?php include_once VIEW_PATH_USER_LAYOUT . 'sidebar-customer.php' ?>
      </div>
      <div class="flex-1 px-1 min-h-[550px] xl:ms-3">
        <div class="w-full bg-white rounded-md shadow-sm xl:shadow-md pb-4 px-4">
          <div class="text-[14px] xl:text-xl text-gray-500 font-bold">
            <div class="p-4">
              <p>Ví voucher</p>
            </div>
            <div class="text-[12px] xl:text-sm font-normal px-4">
              <ul class="flex items-center gap-6 text-black border-b-2 border-gray-100">
                <li id="voucher_shop" class="border-b-2 text-red-700 border-red-700 pb-[7px] cursor-pointer transition ease-linear duration-300 voucher_item" onclick="activeVoucher('voucher_shop')">Voucher của tôi</li>
                <li id="voucher_partner" class="pb-[7px] cursor-pointer transition ease-linear duration-300 voucher_item" onclick="activeVoucher('voucher_partner')">Voucher đối tác</li>
              </ul>
            </div>
          </div>
        </div>
        <div class="w-full bg-white rounded-md shadow-sm xl:shadow-md p-4 mt-2 min-h-[450px]">
          <div id="voucher_shop_tab" class="tab_content">
            <?php if (count($customer_voucher) > 0) { ?>
              <div class="grid grid-cols-1 gap-2 xl:grid-cols-2 xl:gap-4">
                <?php foreach ($customer_voucher as $voucher) { ?>
                  <div class="border border-gray-200 rounded-md p-2">
                    <div class="flex items-center">
                      <i class="fa-solid fa-ticket text-[80px] xl:text-[100px] text-green-500"></i>
                      <div class="text-[12px] xl:text-sm font-semibold my-3 flex flex-col justify-between px-3 gap-1 flex-1">
                        <div>
                          <p><?php echo $voucher['name'] ?></p>
                          <p class="font-normal text-[10px] xl:text-[12px]"><?php echo $voucher['description'] ?> cho đơn hàng từ <?php echo Format::formatNumber($voucher['min_order_value']) ?>đ</p>
                        </div>
                        <div class="bg-gray-300 w-32 tracking-wider text-black px-2 py-1 rounded-md text-[13px] xl:text-sm"><?php echo $voucher['code'] ?></div>
                        <div class="flex justify-between items-center text-[11px] xl:text-[13px]">
                          <p class="text-blue-500">Hạn sử dụng: <?php echo date('d-m-Y', strtotime($voucher['end_date'])) ?></p>
                          <button type="button" class="bg-blue-500 text-white p-2 user-select-none rounded-md text-[12px] text-nowrap xl:text-sm" onclick="copyVoucher('<?php echo $voucher['code'] ?>',event.target)">Sao chép mã</button>
                        </div>
                      </div>
                    </div>
                    <?php if ($voucher['quantity'] <= 0) { ?>
                      <p class="text-[11px] font-normal text-red-500">Voucher đã hết lượt sử dụng</p>
                    <?php } ?>
                    <div class="text-red-500 text-[12px] <?php echo $voucher['used'] == 1 ? 'block' : 'hidden' ?>">Đã sử dụng</div>
                  </div>
                <?php } ?>
              </div>
            <?php } else { ?>
              <div class="flex flex-col items-center gap-4 justify-center min-h-[400px] text-[11px] xl:text-sm">
                <img src="https://res.cloudinary.com/whr-clound/image/upload/v1747390605/shm4cxxqasvn2gbixp69.svg" alt="no_voucher">
                <p>Không có khuyễn mãi nào</p>
                <button class="flex items-center justify-center bg-red-700 w-36 h-5 text-white text-[12px] xl:text-sm rounded-md px-2 py-4 xl:py-5">
                  <a href="<?php echo BASE_URL ?>/voucher" class="w-full">Thu thập thêm</a>
                </button>
              </div>
            <?php } ?>

          </div>
          <div id="voucher_partner_tab" class="tab_content flex flex-col items-center gap-4 justify-center min-h-[400px] text-[11px] xl:text-sm" style="display: none;">
            <img src="https://res.cloudinary.com/whr-clound/image/upload/v1747390605/shm4cxxqasvn2gbixp69.svg" alt="no_voucher">
            <p>Không có khuyễn mãi nào</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
</div>
<?php include_once VIEW_PATH_USER_LAYOUT . 'footer.php'; ?>