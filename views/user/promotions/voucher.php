<?php

use Helpers\Format;

include_once VIEW_PATH_USER_LAYOUT . 'header.php'; ?>
<div class="container-fuild min-h-[500px] mx-auto">
  <div class="bg-white mt-3 w-full rounded-md">
    <div class="w-full p-4 mb-3 min-h-[750px]">
      <div class="w-full">
        <img src="https://res.cloudinary.com/whr-clound/image/upload/v1746515620/qacztkzptp4ubpmqnquh.png" alt="" class="w-full h-[50%]">
      </div>
      <div class="grid grid-cols-1 lg:grid-cols-2 mt-3">
        <?php foreach ($vouchers as $voucher) { ?>
          <div class="border border-gray-200 rounded-md mr-3 px-4 mb-3">
            <div class="flex">
              <i class="fa-solid fa-ticket text-[100px] text-green-500"></i>
              <div class="ms-3 text-[14px] font-semibold my-3 flex flex-col justify-between">
                <div>
                  <p><?php echo $voucher['name'] ?></p>
                  <p><?php echo $voucher['description'] ?> cho đơn hàng từ <?php echo Format::formatNumber($voucher['min_order_value']) ?>đ</p>
                </div>
                <div class="">
                  <div class="flex justify-between items-center">
                    <p class="text-blue-500">Hạn sử dụng: <?php echo date('d-m-Y', strtotime($voucher['end_date'])) ?></p>
                    <?php if ($voucher['voucher_id'] == $voucher['id']) { ?>
                      <button type="button" class="bg-gray-300 w-[120px] h-[30px] text-white rounded-sm pointer-events-none user-select-none">Đã lưu</button>
                    <?php } else { ?>
                      <button type="button" class="<?php echo $voucher['quantity'] > 0 ? 'bg-blue-500' : 'bg-gray-300 pointer-events-none' ?> w-[120px] h-[30px] text-white rounded-sm user-select-none btn-save-voucher" data-id="<?php echo $voucher['id'] ?>">Lưu mã</button>
                    <?php } ?>
                  </div>
                </div>
              </div>
            </div>
            <?php if ($voucher['quantity'] <= 0) { ?>
              <p class="text-[11px] font-normal text-red-500">Voucher đã hết lượt sử dụng</p>
            <?php } ?>
          </div>
        <?php } ?>
      </div>
    </div>
  </div>
</div>
<?php include_once VIEW_PATH_USER_LAYOUT . 'footer.php'; ?>