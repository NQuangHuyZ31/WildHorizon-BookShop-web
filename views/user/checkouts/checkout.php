<?php

use Helpers\Format;

// var_dump($_SESSION);
include_once VIEW_PATH_USER_LAYOUT . 'header.php';

?>
<form action="<?php echo BASE_URL . '/saveorder' ?>" method="post">
  <input type="hidden" name="csrf_token" value="<?php echo $csrf_token ?>">
  <div class="container-fuild mx-auto pb-5">
    <div class="bg-white w-full px-4 py-2 mt-3">
      <p class="text-lg uppercase font-bold py-2 border-b">Địa chỉ giao hàng</p>
      <?php if ($customerAddress != null) { ?>
        <div class="mt-3" id="checkout-address">
          <div class="checkout-address-content">
            <?php foreach ($customerAddress as $address) { ?>
              <div class="flex items-center justify-between mb-3">
                <label class="flex items-center text-[14px] cursor-pointer">
                  <input
                    type="radio"
                    name="checkout-address"
                    value="<?php echo $address['id'] ?>"
                    data-id="<?php echo $address['id'] ?>"
                    class="radio radio-success mr-3"
                    <?php echo $address['default_address'] == 1 ? 'checked="checked" ' : '' ?> />
                  <!--  -->
                  <?php echo $address['username'] ?>
                  <span class="h-[17px] w-[2px] bg-gray-200 mx-3"></span>
                  <?php echo $address['address'] ?>, <?php echo $address['ward'] ?>, <?php echo $address['district'] ?>, <?php echo $address['province'] ?>
                  <span class="h-[17px] w-[2px] bg-gray-200 mx-3"></span>
                  <?php echo $address['phone'] ?>
                </label>
                <div class="text-[14px] flex justify-start w-[100px] font-semibold text-blue-500">
                  <?php if ($address['default_address'] == 0) {  ?>
                    <button type="button" class="update-address-checkout">Xóa</button>
                  <?php } ?>
                </div>
              </div>
            <?php } ?>
          </div>
          <div class="cursor-pointer flex items-center add-orther-address">
            <i class="fa-solid fa-circle-plus text-[18px] text-red-700 mr-3"></i>
            <p class="text-[14px]">Giao hàng đến địa chỉ khác</p>
          </div>
        </div>
      <?php } else { ?>
        <?php require_once VIEW_PATH . 'user/checkouts/checkout-new-address.php' ?>
      <?php } ?>
    </div>
    <div class="bg-white w-full px-4 py-2 mt-3">
      <p class="text-lg uppercase font-bold py-2 border-b">Phương thức vận chuyển</p>
      <div class="flex items-center py-2">

        <label class="text-sm text-slate-500 flex items-center cursor-pointer">
          <input type="radio" name="shipping-fee" class="mr-3 shipping-fee" value="23000" checked>
          <p>Vận chuyển tiêu chuẩn (23.000 đ)</p>
        </label>
      </div>
      <div class="flex items-center py-2">
        <label class="text-sm text-slate-500 flex items-center cursor-pointer">
          <input type="radio" name="shipping-fee" class="mr-3 shipping-fee" value="32000">
          <p>Vận chuyển nhanh (32.000 đ)</p>
        </label>
      </div>
    </div>
    <div class="bg-white w-full px-4 py-2 mt-3">
      <p class="text-lg uppercase font-bold py-2 border-b">Phương thức thanh toán</p>
      <div class="flex items-center">
        <label class="text-sm flex items-center cursor-pointer">
          <input type="radio" name="payment-method" class="mr-3 payment-method cursor-pointer" value="Tiền mặt" checked>
          <p class="mr-2" style="background: url(https://res.cloudinary.com/whr-clound/image/upload/v1745417547/jtaerq0bcxjrnnp7fnwg.svg) no-repeat center center;width: 40px;height: 40px;"></p>
          <p>Thanh toán sau khi nhận hàng</p>
        </label>
      </div>
      <div class="flex items-center">
        <label class="text-sm flex items-center cursor-pointer">
          <input type="radio" name="payment-method" class="mr-3 payment-method cursor-pointer" value="VNPAY">
          <p class="mr-2" style="background: url(https://res.cloudinary.com/whr-clound/image/upload/v1745417656/wytvfotat2mk3kbqhfit.svg) no-repeat center center;width: 40px;height: 40px;"></p>
          <p>Thanh toán qua VNPAY</p>
        </label>
      </div>
      <div class="flex items-center">
        <label class="text-sm flex items-center cursor-pointer">
          <input type="radio" name="payment-method" class="mr-3 payment-method cursor-pointer" value="MoMo">
          <p class="mr-2" style="background: url(https://res.cloudinary.com/whr-clound/image/upload/v1745417655/mlicklrqbxcvguevagbq.svg) no-repeat center center;width: 40px;height: 40px;"></p>
          <p>Thanh toán qua ví momo</p>
        </label>
      </div>
    </div>
    <div class="bg-white w-full px-4 py-2 mt-3 ">
      <p class="text-lg uppercase font-bold py-2 border-b">Kiểm tra lại đơn hàng</p>
      <?php foreach ($cartItems as $item) { ?>
        <div class="mt-3 flex">
          <div class="checkout-product-image p-1">
            <img src="<?php echo $item['product_image'] ?>" alt="" class="h-full mx-auto" width="80">
          </div>
          <div class="checkout-product-title ms-4 pt-2 text-sm">
            <p><?php echo $item['product_name'] ?></p>
          </div>
          <div class="checkout-price text-sm">
            <p>
              <?php echo $item['f_discount_price'] > 0 ? Format::forMatPrice($item['price'] - ($item['price'] * $item['f_discount_price'] / 100)) : Format::forMatPrice($item['price'] - ($item['price'] * $item['discount_price'] / 100)) ?>
              đ</p>
            <p class="text-gray-300">
              <s>
                <?php echo Format::forMatPrice($item['price']) ?>
                đ
              </s>
            </p>
          </div>
          <div class="checkout-quantity text-sm text-center">
            <p><?php echo $item['quantity'] ?></p>
          </div>
          <div class="text-orange-400">
            <p>
              <?php echo $item['f_discount_price'] > 0 ? Format::forMatPrice(($item['price'] - ($item['price'] * $item['f_discount_price'] / 100)) * $item['quantity']) : Format::forMatPrice(($item['price'] - ($item['price'] * $item['discount_price'] / 100)) * $item['quantity']) ?>
              đ</p>
          </div>
        </div>
        <input type="hidden" name="productID[]" value="<?php echo $item['product_id'] ?>">
        <input type="hidden" name="quantity[]" value="<?php echo $item['quantity'] ?>">
      <?php } ?>
    </div>

  </div>
  <div class="bg-white flex justify-end">
    <div class="p-2 flex flex-col">
      <div class="w-full border-b border-slate-400">
        <div class="flex flex-col border-b " style="width: 300px;">
          <div class="flex justify-between p-2">
            <p>Thành tiền</p>
            <p><?php echo Format::forMatPrice($total) ?>đ</p>
          </div>
          <div class="flex justify-between p-2">
            <p>Phí vận chuyển
            </p>
            <p class="shipping-cost">23.000đ</p>
          </div>
          <div class="flex p-2 justify-between font-bold">
            <input type="hidden" name="total" value="<?php echo $total ?>">
            <p>Tổng Số Tiền </p>
            <p class="text-orange-400 total-price" data-total="<?php echo $total ?>"><?php echo Format::forMatPrice($total + 23000) ?>đ</p>
          </div>
        </div>
      </div>
      <hr>
      <div class="w-full flex justify-end">
        <div class="mt-3 text-white font-bold" style="width: 200px;height: 60px;">
          <button type="submit" class="p-4 bg-red-700 rounded-md cursor-pointer user-select-none">Xác nhận thanh toán</button>
        </div>
      </div>
    </div>
  </div>
</form>

<!-- Modal thêm địa chỉ -->
<dialog id="checkout_new_address_modal" class="modal">
  <div class="modal-box">
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