<?php

use Helpers\Format;

// var_dump($_SESSION);
include_once VIEW_PATH_USER_LAYOUT . 'header.php';

?>
<form action="<?php echo BASE_URL . '/saveorder' ?>" method="post" class="w-full xl:container">
  <input type="hidden" name="csrf_token" value="<?php echo $csrf_token ?>">
  <div class="container-fuild mx-auto h-auto xl:p-0 px-2">
    <div class="bg-white w-full px-2 py-2 mt-3 xl:px-4 rounded-md">
      <p class="text-[15px] xl:text-lg uppercase font-bold py-2 border-b">Địa chỉ giao hàng</p>
      <?php if ($customerAddress != null) { ?>
        <div class="mt-3" id="checkout-address">
          <div class="checkout-address-content">
            <?php foreach ($customerAddress as $address) { ?>
              <div class="flex items-center justify-between mb-3">
                <label class="flex items-center text-[12px] xl:text-sm cursor-pointer">
                  <input
                    type="radio"
                    name="checkout-address"
                    value="<?php echo $address['id'] ?>"
                    data-id="<?php echo $address['id'] ?>"
                    class="radio radio-success mr-3 w-[20px] h-[20px] xl:h-[24px] xl:w-[24px]"
                    <?php echo $address['default_address'] == 1 ? 'checked="checked" ' : '' ?> />
                  <!--  -->
                  <p><?php echo $address['username'] ?></p>
                  <span class="h-[17px] w-[2px] bg-gray-200 mx-3"></span>
                  <p><?php echo $address['address'] ?>, <?php echo $address['ward'] ?>, <?php echo $address['district'] ?>, <?php echo $address['province'] ?></p>
                  <span class="h-[17px] w-[2px] bg-gray-200 mx-3"></span>
                  <p><?php echo $address['phone'] ?></p>
                </label>
                <div class="text-[12px] flex justify-start font-semibold text-blue-500 ms-2 xl:w-[100px] xl:text-[14px]">
                  <?php if ($address['default_address'] == 0) {  ?>
                    <button type="button" class="delete-address-checkout" data-id="<?php echo $address['id'] ?>">Xóa</button>
                  <?php } ?>
                </div>
              </div>
            <?php } ?>
          </div>
          <div class="cursor-pointer flex items-center add-orther-address">
            <i class="fa-solid fa-circle-plus text-[14px] xl:text-[18px] text-red-700 mr-3"></i>
            <p class="text-[12px] xl:text-[14px]">Giao hàng đến địa chỉ khác</p>
          </div>
        </div>
      <?php } else { ?>
        <?php require_once VIEW_PATH . 'user/checkouts/checkout-new-address.php' ?>
      <?php } ?>
    </div>
    <div class="bg-white w-full px-4 py-2 mt-3 rounded-md">
      <p class="xl:text-lg text-[15px] uppercase font-bold py-2 border-b">Phương thức vận chuyển</p>
      <div class="flex items-center py-2">
        <label class="xl:text-sm text-[12px] text-slate-500 flex items-center cursor-pointer">
          <input type="radio" name="shipping-fee" class="accent-blue-600 dark:accent-blue-400 mr-3 shipping-fee" value="23000" checked>
          <p>Vận chuyển tiêu chuẩn (23.000 đ)</p>
        </label>
      </div>
      <div class="flex items-center py-2">
        <label class="xl:text-sm text-[12px] text-slate-500 flex items-center cursor-pointer">
          <input type="radio" name="shipping-fee" class="accent-blue-600 dark:accent-blue-400 mr-3 shipping-fee" value="32000">
          <p>Vận chuyển nhanh (32.000 đ)</p>
        </label>
      </div>
    </div>
    <div class="bg-white w-full px-4 py-2 mt-3 rounded-md">
      <p class="xl:text-lg text-[15px] uppercase font-bold py-2 border-b">Phương thức thanh toán</p>
      <div class="flex items-center">
        <label class="xl:text-sm text-[12px] flex items-center cursor-pointer">
          <input type="radio" name="payment-method" class="mr-3 accent-blue-600 dark:accent-blue-400 payment-method cursor-pointer" value="Tiền mặt" checked>
          <p class="mr-2" style="background: url(https://res.cloudinary.com/whr-clound/image/upload/v1745417547/jtaerq0bcxjrnnp7fnwg.svg) no-repeat center center;width: 40px;height: 40px;"></p>
          <p>Thanh toán sau khi nhận hàng</p>
        </label>
      </div>
      <div class="flex items-center">
        <label class="xl:text-sm text-[12px] flex items-center cursor-pointer">
          <input type="radio" name="payment-method" class="mr-3 accent-blue-600 dark:accent-blue-400 payment-method cursor-pointer" value="VNPAY">
          <p class="mr-2" style="background: url(https://res.cloudinary.com/whr-clound/image/upload/v1745417656/wytvfotat2mk3kbqhfit.svg) no-repeat center center;width: 40px;height: 40px;"></p>
          <p>Thanh toán qua VNPAY</p>
        </label>
      </div>
      <div class="flex items-center">
        <label class="xl:text-sm text-[12px] flex items-center cursor-pointer">
          <input type="radio" name="payment-method" class="mr-3 accent-blue-600 dark:accent-blue-400 payment-method cursor-pointer" value="MoMo">
          <p class="mr-2" style="background: url(https://res.cloudinary.com/whr-clound/image/upload/v1745417655/mlicklrqbxcvguevagbq.svg) no-repeat center center;width: 40px;height: 40px;"></p>
          <p>Thanh toán qua ví momo</p>
        </label>
      </div>
    </div>
    <div class="bg-white w-full px-4 py-2 mt-3 rounded-md">
      <div class="flex items-center justify-between xl:justify-start border-b border-gray-200 py-2">
        <p class="font-bold uppercase">Mã khuyến mãi</p>
        <button type="button" class="text-blue-500 xl:text-sm xl:ms-14" id="btn_show_voucher">Chọn mã khuyến mãi<i class="fa-solid fa-chevron-right ms-2"></i></button>
      </div>
    </div>
    <!--  -->
    <div class="bg-white w-full px-2 py-2 mt-3 xl:px-4 xl:mb-48 rounded-md">
      <p class="xl:text-lg text-[15px] uppercase font-bold py-2 border-b">Kiểm tra lại đơn hàng</p>
      <?php foreach ($cartItems as $item) { ?>
        <div class="mt-3 flex">
          <div class="checkout-product-image p-1 xl:h-[150px]">
            <img src="<?php echo $item['product_image'] ?>" alt="" class="h-full">
          </div>
          <div class="flex flex-col xl:flex-row xl:flex-1 xl:justify-around">
            <div class="pt-2 text-[13px] w-[250px] xl:text-sm xl:w-[500px]">
              <p><?php echo $item['product_name'] ?></p>
            </div>
            <div class="checkout-price text-sm w-full flex items-center xl:w-auto xl:block">
              <p class="text-orange-500 mr-2 xl:text-black">
                <?php echo $item['f_discount_price'] > 0 ? Format::forMatPrice($item['price'] - ($item['price'] * $item['f_discount_price'] / 100)) : Format::forMatPrice($item['price'] - ($item['price'] * $item['discount_price'] / 100)) ?>
                <span>đ</span>
              </p>
              <p class="text-gray-300">
                <s>
                  <?php echo Format::forMatPrice($item['price']) ?>
                  đ
                </s>
              </p>
            </div>
            <div class="text-[12px] xl:text-sm">
              <p class="flex"><span class="block xl:hidden">Số lượng: </span><?php echo $item['quantity'] ?></p>
            </div>
            <div class="text-orange-400 hidden xl:block">
              <p>
                <?php echo $item['f_discount_price'] > 0 ? Format::forMatPrice(($item['price'] - ($item['price'] * $item['f_discount_price'] / 100)) * $item['quantity']) : Format::forMatPrice(($item['price'] - ($item['price'] * $item['discount_price'] / 100)) * $item['quantity']) ?>
                đ</p>
            </div>
            <input type="hidden" name="productID[]" value="<?php echo $item['product_id'] ?>">
            <input type="hidden" name="quantity[]" value="<?php echo $item['quantity'] ?>">
          </div>
        </div>
      <?php } ?>
    </div>
    <div class="flex items-center m-3 xl:hidden pb-28 xl:mb-0 p-1">
      <input type="checkbox" name="dieu_khoan" value="1" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 cursor-pointer" checked>
      <p class="ms-2 xl:text-sm text-[12px] xl:ms-3 text-gray-400">Bằng việc tiến hành Mua hàng, Bạn đã đồng ý với <span><br><a href="<?php echo BASE_URL ?>/dieu-khoan-whr" class="text-blue-700 font-semibold text-[12px] xl:text-sm">Điều khoản & Điều kiện của wildhorizonBS.com</a></span></p>
    </div>
  </div>
  <!-- Phần cố định dưới cùng -->
  <div class="fixed bottom-0 left-0 w-full xl:flex xl:items-center xl:justify-center p-2 bg-white dark:bg-gray-800 shadow-[0_-6px_10px_-6px_rgba(0,0,0,0.3)] z-50">
    <div class="xl:min-w-[1024px] xl:mx-auto">
      <div class="xl:p-2 xl:flex xl:items-end xl:justify-end">
        <div class="xl:flex flex-col w-full xl:w-[300px]">
          <div class="hidden xl:flex justify-between p-1 xl:text-sm">
            <p>Thành tiền</p>
            <p><?php echo Format::forMatPrice($total) ?>đ</p>
          </div>
          <div class="hidden xl:flex justify-between p-1 xl:text-sm">
            <p>Phí vận chuyển
            </p>
            <p class="shipping-cost">23.000đ</p>
          </div>
          <div class="flex justify-between font-bold p-2 xl:text-sm xl:justify-between xl:p-1 ">
            <input type="hidden" name="total" value="<?php echo $total ?>">
            <p class="flex xl:text-sm text-[14px]">Tổng Tiền<span class="block xl:hidden"> (bao gồm phí ship)</span> </p>
            <p class="text-orange-400 total-price" data-total="<?php echo $total ?>"><?php echo Format::forMatPrice($total + 23000) ?>đ</p>
          </div>
        </div>
      </div>
      <hr>
      <div class="w-full xl:flex xl:justify-between">
        <div class="hidden xl:flex items-center">
          <input type="checkbox" name="dieu_khoan" value="1" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 cursor-pointer" checked>
          <p class="xl:text-sm xl:ms-3 text-gray-400">Bằng việc tiến hành Mua hàng, Bạn đã đồng ý với <span><br><a href="<?php echo BASE_URL ?>/dieu-khoan-whr" class="text-blue-700 font-semibold">Điều khoản & Điều kiện của wildhorizonBS.com</a></span></p>
        </div>
        <div class="mt-3 text-white font-bold">
          <button type="submit" class="p-3 text-[14px] w-full bg-red-700 rounded-md cursor-pointer user-select-none xl:text-sm xl:p-4">Xác nhận thanh toán</button>
        </div>
      </div>
    </div>
  </div>

</form>

<!-- Modal voucher -->
<div class="w-full xl:w-[550px] fixed top-[10%] left-[50%] z-[99999] bg-white rounded-md p-2 h-[85%] max-h-[800px] hidden" id="voucher_checkout_main" style="transform: translate(-50%,0);">
  <div class="w-full h-full">
    <div class="flex items-center justify-between p-3">
      <div class="flex items-center gap-2 text-[12px] xl:text-sm text-blue-500 uppercase">
        <i class="fa-solid fa-ticket-simple"></i>
        <p>Chọn mã khuyến mãi</p>
      </div>
      <i class="fa-solid fa-xmark text-gray-300 cursor-pointer" id="hide_voucher_content"></i>
    </div>
    <div class="h-full overflow-x-hidden overflow-y-auto">
      <div class="grid grid-cols-1 gap-2 mt-3">
        <?php foreach ($vouchers as $voucher) { ?>
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
      </div>
    </div>
  </div>
</div>

<div class="fixed float-left top-0 left-0 w-full h-full z-[2000] bg-gray-500 opacity-50 hidden" id="cover_page"></div>
<!-- Modal thêm địa chỉ -->
<dialog id="checkout_new_address_modal" class="modal">
  <div class="modal-box bg-white dark:bg-gray-900">
    <form method="dialog">
      <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</button>
    </form>
    <div class="feedback-content w-full">
      <p class="font-semibold">Thêm địa chỉ nhận hàng</p>
      <?php require_once VIEW_PATH . 'user/checkouts/checkout-new-address.php' ?>
      <div class="flex justify-end mt-3">
        <button type="button" id="checkout-new-address" class="w-[100px] h-[40px] bg-red-700 text-white font-semibold text-[13px] rounded-md">Thêm địa chỉ</button>
      </div>
    </div>
  </div>
</dialog>
<?php include_once VIEW_PATH_USER_LAYOUT . 'footer-no-content.php'; ?>