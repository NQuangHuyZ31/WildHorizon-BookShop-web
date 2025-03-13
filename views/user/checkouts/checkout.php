<?php

use Core\Format;
use Core\Session;

include_once VIEW_PATH_USER_LAYOUT . 'header.php';

?>
<form action="<?php echo BASE_URL_NAME . '/saveorder' ?>" method="post">
  <input type="hidden" name="csrf_token" value="<?php echo $csrf_token ?>">
  <div class="container-fuild mx-auto pb-5">
    <div class="bg-white w-full px-4 py-2 mt-3">
      <p class="text-lg uppercase font-bold py-2 border-b">Địa chỉ giao hàng</p>
      <div class="mt-2 flex items-center">
        <label class="text-sm text-slate-500 text-nowrap checkout-label">Họ và tên người nhận</label>
        <input type="text" class="text-sm rounded-md checkout-input focus:border-sky-300 font-bold" name="fullname" value="<?php echo $customer['firstname'] . ' ' . $customer['lastname'] ?>" required>
      </div>
      <div class="mt-2 flex items-center">
        <label class="text-sm text-slate-500 text-nowrap checkout-label">Số điện thoại</label>
        <input type="text" class="text-sm rounded-md checkout-input focus:border-sky-300 font-bold" name="phone" value="<?php echo $customer['phone'] ?>" required>
      </div>
      <div class="mt-2 flex items-center">
        <label class="text-sm text-slate-500 text-nowrap checkout-label">Tỉnh/thành phố</label>
        <select name="province" id="checkout-province" class="text-sm rounded-md checkout-input focus:border-sky-300" required>
          <option value="">Chọn tỉnh/thành phố</option>
        </select>
      </div>
      <div class="mt-2 flex items-center">
        <label class="text-sm text-slate-500 text-nowrap checkout-label">Quận/Huyện</label>
        <select name="district" id="checkout-district" class="text-sm rounded-md checkout-input focus:border-sky-300" disabled required>
          <option value="">Chọn quận/Huyện</option>
        </select>
      </div>
      <div class="mt-2 flex items-center">
        <label class="text-sm text-slate-500 text-nowrap checkout-label">Phường/Xã</label>
        <select name="ward" id="checkout-ward" class="text-sm rounded-md checkout-input focus:border-sky-300" disabled required>
          <option value="">Chọn phường/xã</option>
        </select>
      </div>
      <div class="mt-2 flex items-center">
        <label class="text-sm text-slate-500 text-nowrap checkout-label">Địa chỉ nhận hàng</label>
        <input type="text" name="address" id="checkout-address" class="text-sm rounded-md checkout-input focus:border-sky-300" placeholder="Nhập địa chỉ giao hàng...." required>
      </div>
    </div>
    <div class="bg-white w-full px-4 py-2 mt-3">
      <p class="text-lg uppercase font-bold py-2 border-b">Phương thức vận chuyển</p>
      <div class="flex items-center py-2">
        <input type="radio" name="shipping-fee" class="mr-3 shipping-fee" value="23000" checked>
        <label class="text-sm text-slate-500 text-nowrap checkout-label">Vận chuyển tiêu chuẩn (23.000 đ)</label>
      </div>
      <div class="flex items-center py-2">
        <input type="radio" name="shipping-fee" class="mr-3 shipping-fee" value="32000">
        <label class="text-sm text-slate-500 text-nowrap checkout-label">Vận chuyển nhanh (32.000 đ)</label>
      </div>
    </div>
    <div class="bg-white w-full px-4 py-2 mt-3">
      <p class="text-lg uppercase font-bold py-2 border-b">Phương thức thanh toán</p>
      <div class="flex items-center">
        <input type="radio" name="payment-method" class="mr-3 payment-method cursor-pointer" value="Tiền mặt" checked>
        <p class="mr-2" style="background: url(https://cdn0.fahasa.com/skin/frontend/base/default/images/payment_icon/ico_cashondelivery.svg?q=10884) no-repeat center center;width: 40px;height: 40px;"></p>
        <label class="text-sm text-nowrap checkout-label">Thanh toán sau khi nhận hàng</label>
      </div>
      <div class="flex items-center">
        <input type="radio" name="payment-method" class="mr-3 payment-method cursor-pointer" value="Chuyển khoản ngân hàng">
        <p class="mr-2" style="background: url(https://cdn0.fahasa.com/skin/frontend/base/default/images/payment_icon/ico_zalopayatm.svg?q=10884) no-repeat center center;width: 40px;height: 40px;"></p>
        <label class="text-sm text-nowrap checkout-label">Thanh toán qua ngân hàng</label>
      </div>
      <div class="flex items-center">
        <input type="radio" name="payment-method" class="mr-3 payment-method cursor-pointer" value="MoMo">
        <p class="mr-2" style="background: url(https://cdn0.fahasa.com/skin/frontend/base/default/images/payment_icon/ico_momopay.svg?q=10884) no-repeat center center;width: 40px;height: 40px;"></p>
        <label class="text-sm text-nowrap checkout-label">Thanh toán qua ví momo</label>
      </div>
    </div>
    <div class="bg-white w-full px-4 py-2 mt-3 ">
      <p class="text-lg uppercase font-bold py-2 border-b">Kiểm tra lại đơn hàng</p>
      <?php foreach ($cartItems as $item) { ?>
        <div class="mt-3 flex">
          <div class="checkout-product-image p-1">
            <img src="<?php echo BASE_URL_NAME ?>/Public/upload/products/<?php echo $item['product_image'] ?>" alt="" class="h-full mx-auto" width="80">
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
          <button type="submit" class="p-4 bg-red-700 rounded-md">Xác nhận thanh toán</button>
        </div>
      </div>
    </div>
  </div>
</form>
<?php include_once VIEW_PATH_USER_LAYOUT . 'footer-no-content.php'; ?>