<?php

use Helpers\Format;

include_once VIEW_PATH_USER_LAYOUT . 'header.php'; ?>
<div class="w-full xl:max-w-screen-xl xl:mx-auto">
  <div class="w-full mt-3 mb-3 min-h-[550px]">
    <div class="flex flex-col xl:mb-0 xl:flex-row w-full">
      <div class="hidden xl:block xl:w-1/4">
        <?php include_once VIEW_PATH_USER_LAYOUT . 'sidebar-customer.php' ?>
      </div>
      <div class="w-full px-1 xl:w-[75%] xl:ms-3">
        <?php if ($order['payment_method'] == 'VNPAY' && $order['is_payment'] == 0) { ?>
          <div class="mx-auto p-2 mb-3 bg-white shadow-sm xl:shadow-lg rounded-2xl w-full flex items-center justify-between">
            <div class="flex items-center px-4 text-[12px] xl:text-[14px]">
              <i class="fa-solid fa-triangle-exclamation mr-3 text-red-700"></i>
              <p class="text-black">Đơn hàng chưa được thanh toán. Vui lòng thanh toán lại.</p>
            </div>
            <form action="<?php echo BASE_URL ?>/checkout/vnpay/checkout_again/<?php echo $order['id'] ?>" method="post">
              <input type="hidden" name="csrf_token" value="<?php echo $csrf_token ?>">
              <button type="submit" name="btn-checkout-again" class="w-[100px] h-[35px] text-[12px] xl:w-[120px] xl:h-[40px] bg-red-700 p-2 mr-3 xl:text-[14px] text-white font-semibold rounded-md">
                Thanh toán lại
              </button>
            </form>
          </div>
        <?php } else if ($order['payment_method'] == 'VNPAY' && $order['is_payment'] == 1) { ?>
          <div class="mx-auto px-4 py-1 mb-3 bg-white shadow-lg rounded-lg w-full flex items-center">
            <i class="fa-solid fa-circle-check mr-3 text-green-500"></i>
            <p class="text-[13px] xl:text-[15px]">Đơn hàng này đã được thanh toán.</p>
          </div>
        <?php } ?>
        <div class="mx-auto p-6 bg-white shadow-sm xl:shadow-lg rounded-2xl w-full">
          <p class="text-[14px] xl:text-xl text-gray-500 font-semibold">Chi tiết đơn hàng</p>
          <?php if ($order_review != null) { ?>
            <div class="flex items-center pt-1 text-[11px] xl:text-[13px] text-gray-500">
              <p>Đơn hàng được đánh giá:</p>
              <div class="rating py-1 ms-3">
                <?php for ($i = 1; $i <= 5; $i++) { ?>
                  <?php if ($i == $order_review['rating_id']) { ?>
                    <input
                      type="radio"
                      name="rating-order-<?php echo $order_review['order_id'] ?>"
                      value="<?php echo $i ?>" class="mask mask-star-2 w-[15px] h-[15px] bg-green-500"
                      aria-label="<?php echo $i ?> star"
                      checked disabled />
                  <?php } else { ?>
                    <input
                      type="radio"
                      name="rating-order-<?php echo $order_review['order_id'] ?>"
                      value="<?php echo $i ?>"
                      class="mask mask-star-2 w-[15px] h-[15px] bg-green-500"
                      aria-label="<?php echo $i ?> star"
                      disabled />
                  <?php } ?>
                <?php } ?>
              </div>
            </div>
          <?php } ?>
          <div class="flex items-center justify-between text-[12px] xl:text-[14px]">
            <p class=" text-orange-700 font-semibold mt-2">Mã đơn hàng: #<?php echo $order['id'] ?></p>
            <p class="text-[10px] xl:text-[12px] text-gray-400">Ngày đặt hàng: <?php echo date('d/m/Y', strtotime($order['order_date'])) ?></p>
          </div>

          <div class="relative mt-6 mb-8 w-full">
            <div class="flex flex-col w-full">
              <!-- Step 1 -->
              <div class="flex justify-around gap-2 items-center text-center z-50 relative">
                <div
                  class="order-step flex items-center justify-center border z-50 <?php echo in_array($order['status'], ['Chờ xác nhận', 'Chuẩn bị hàng', 'Đang giao hàng', 'Đã giao hàng']) ? 'bg-green-600 border-green-600 text-white' : 'bg-white text-gray-500 border-gray-400' ?> ">
                  <span>1</span>
                </div>
                <div
                  class="order-step flex items-center justify-center border z-50 <?php echo in_array($order['status'], ['Chuẩn bị hàng', 'Đang giao hàng', 'Đã giao hàng']) ? 'bg-green-600 border-green-600 text-white' : 'bg-white text-gray-500 border-gray-400' ?> ">
                  <span>2</span>

                </div>
                <div
                  class="order-step flex items-center justify-center border z-50 <?php echo in_array($order['status'], ['Đang giao hàng', 'Đã giao hàng'])  ? 'bg-green-600 border-green-600 text-white' : 'bg-white text-gray-500 border-gray-400' ?> ">
                  <span>3</span>
                </div>
                <div
                  class="order-step flex items-center justify-center border z-50 <?php echo in_array($order['status'], ['Đã giao hàng'])  ? 'bg-green-600 border-green-600 text-white' : 'bg-white text-gray-500 border-gray-400' ?> ">
                  <span>4</span>
                </div>
                <!-- Line background -->
                <div class="absolute bg-gray-200 h-[2px] top-[50%] left-[10%] w-[calc(100%-80px)] xl:top-[50%] xl:left-[12%] xl:w-[calc(100%-200px)]"></div>

                <!-- Line progress -->
                <div class="absolute bg-green-600 h-[2px] top-[50%] left-[10%] xl:top-[50%] xl:left-[12%] transition-all duration-500" style="width: calc(<?php echo $step_line ?>);"></div>
              </div>
              <!-- Step 2 -->
              <div class="flex justify-around items-center text-center z-10">
                <p class="text-[10px] xl:text-xs mt-2 <?php echo in_array($order['status'], ['Chờ xác nhận', 'Chuẩn bị hàng', 'Đang giao hàng', 'Đã giao hàng']) ? 'text-green-600 font-medium' : 'text-gray-500' ?>">Chờ xác nhận</p>
                <p class="text-[10px] xl:text-xs mt-2 <?php echo in_array($order['status'], ['Chuẩn bị hàng', 'Đang giao hàng', 'Đã giao hàng']) ? 'text-green-600 font-medium' : 'text-gray-500' ?>">Chuẩn bị hàng</p>
                <p class="text-[10px] xl:text-xs mt-2 <?php echo in_array($order['status'], ['Đang giao hàng', 'Đã giao hàng']) ? 'text-green-600 font-medium' : 'text-gray-500' ?>">Đang giao hàng</p>
                <p class="text-[10px] xl:text-xs mt-2 <?php echo in_array($order['status'], ['Đã giao hàng'])  ? 'text-green-600 font-medium' : 'text-gray-500' ?>">Đã giao hàng</p>
              </div>
            </div>
          </div>
          <!-- Thông tin sản phẩm -->
          <div class="mt-3">
            <?php foreach ($order_details as $order_detail) { ?>
              <div class="border border-gray-300 rounded-md flex items-center justify-between p-3 mb-3">
                <div class="flex items-center">
                  <div class="order_detail_img p-1 flex items-center justify-center w-[100px] h-[100px]">
                    <img src="<?php echo $order_detail['product_image'] ?>" alt="" class="max-h-full max-w-full object-contain">
                  </div>
                  <div class="flex h-full flex-col text-[12px] xl:text-sm text-gray-600 leading-3">
                    <p class="px-1 font-semibold w-[75%] leading-5"><?php echo $order_detail['product_name'] ?></p>
                    <p class="py-3 px-1">Số lượng: <?php echo $order_detail['quantity'] ?></p>
                  </div>
                </div>
                <div class="px-3 text-nowrap">
                  <p class="text-black font-semibold text-[14px] xl:text-sm"><?php echo Format::formatNumber($order_detail['total']) ?> đ</p>
                </div>
              </div>
            <?php } ?>
          </div>
          <div class="border border-gray-300 rounded-md p-3 mb-3">
            <div class="border-b border-gray-300">
              <p class="py-3 text-black text-[15px] xl:text-xl font-semibold">Đơn hàng</p>
              <div class="flex items-center justify-between py-3 text-[12px] xl:text-sm">
                <p>Thành tiền</p>
                <p><?php echo Format::formatNumber($order['total_price']) ?> đ</p>
              </div>
              <div class="flex items-center justify-between py-3 text-[12px] xl:text-sm">
                <p>Phí vận chuyển</p>
                <p><?php echo Format::formatNumber($order['shipping_fee']) ?> đ</p>
              </div>
              <div class="flex items-center justify-between py-3 text-[12px] xl:text-sm text-sm">
                <p>Phương thức thanh toán</p>
                <p><?php echo $order['payment_method'] ?></p>
              </div>
            </div>
            <div class="flex items-center justify-between pt-3 font-semibold text-black xl:text-sm text-sm">
              <p>Total</p>
              <p><?php echo Format::formatNumber($order['total_price'] + $order['shipping_fee']) ?> đ</p>
            </div>
          </div>
          <div class="mt-3">
            <div class="border border-gray-300 rounded-md p-3 mb-3 text-[14px]">
              <p class="text-[15px] xl:text-lg font-semibold py-2">Khách hàng</p>
              <div class="flex items-center py-2 text-gray-600 text-[12px] xl:text-sm">
                <i class="fa-solid fa-user mr-3"></i>
                <p><?php echo $order_shipping_address['full_name'] ?></p>
              </div>
              <div class="flex items-center py-2 text-gray-600 text-[12px] xl:text-sm">
                <i class="fa-solid fa-phone mr-3"></i>
                <p><?php echo $order_shipping_address['phone'] ?></p>
              </div>
            </div>
            <div class="border border-gray-300 rounded-md p-3 mb-3 text-[14px]">
              <p class="text-[15px] xl:text-lg font-semibold py-2">Địa chỉ giao hàng</p>
              <div class="flex items-center py-2 text-gray-600 text-[12px] xl:text-sm">
                <i class="fa-solid fa-user mr-3"></i>
                <p><?php echo $order_shipping_address['full_name'] ?></p>
              </div>
              <div class="py-2 text-gray-600 text-[12px] xl:text-sm">
                <p class="py-1"><?php echo $order_shipping_address['address_line1'] ?></p>
                <p class="py-1"><?php echo $order_shipping_address['ward'] . ', ' . $order_shipping_address['district'] . ', ' . $order_shipping_address['province']  ?></p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <?php include_once VIEW_PATH_USER_LAYOUT . 'footer.php'; ?>