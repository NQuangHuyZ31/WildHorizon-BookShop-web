<?php

use Helpers\Format;

include_once VIEW_PATH_USER_LAYOUT . 'header.php'; ?>

<div class="container-fuild mx-auto">
  <div class="w-full mt-3 mb-3">
    <div class="flex flex-col lg:mb-0 lg:flex-row w-full">
      <?php include_once VIEW_PATH_USER_LAYOUT . 'sidebar-customer.php' ?>
      <div class="w-full px-1 lg:w-[75%] lg:ms-3">
        <div class="w-full bg-white rounded-md shadow-sm px-4">
          <div class="w-full flex justify-content-around items-center gap-7 lg:gap-4">
            <a
              href="<?php echo BASE_URL ?>/customer/order?type=all"
              class="p-2 w-full text-center text-[15px] cursor-pointer customer-order-type 
              <?php echo !isset($_GET['type']) || isset($_GET['type']) && $_GET['type'] == 'all' ? 'active font-semibold' : '' ?>">
              <span class="text-[13px] lg:text-[14px]">
                Tất cả
              </span>
            </a>
            <a
              href="<?php echo BASE_URL ?>/customer/order?type=Chờ xác nhận"
              class="p-2 w-full text-center text-[15px] cursor-pointer customer-order-type 
              <?php echo isset($_GET['type']) && $_GET['type'] == 'Chờ xác nhận' ? 'active font-semibold' : '' ?>">
              <span class="text-[13px] lg:text-[14px]">
                Chờ xác nhận
              </span>
            </a>
            <a
              href="<?php echo BASE_URL ?>/customer/order?type=Chuẩn bị hàng"
              class="p-2 w-full text-center text-[15px] cursor-pointer customer-order-type 
              <?php echo isset($_GET['type']) && $_GET['type'] == 'Chuẩn bị hàng' ? 'active font-semibold' : '' ?>">
              <span class="text-[13px] lg:text-[14px]">
                Chuẩn bị hàng
              </span>
            </a>
            <a
              href="<?php echo BASE_URL ?>/customer/order?type=Đang giao hàng"
              class="p-2 w-full text-center text-[15px] cursor-pointer customer-order-type 
              <?php echo isset($_GET['type']) && $_GET['type'] == 'Đang giao hàng' ? 'active font-semibold' : '' ?>">
              <span class="text-[13px] lg:text-[14px]">
                Đang giao hàng
              </span>
            </a>
            <a
              href="<?php echo BASE_URL ?>/customer/order?type=Đã giao hàng"
              class="p-2 w-full text-center text-[15px] cursor-pointer customer-order-type 
              <?php echo isset($_GET['type']) && $_GET['type'] == 'Đã giao hàng' ? 'active font-semibold' : '' ?>">
              <span class="text-[13px] lg:text-[14px]">
                Đã giao hàng
              </span>
            </a>
          </div>
        </div>
        <div class="mt-3 w-full bg-white px-4 flex items-center text-red-700 text-[13px] rounded-sm py-1">
          <i class="fa-solid fa-circle-exclamation"></i>
          <p class="ms-2 text-gray-500">Lưu ý: Tổng tiền đã bao gồm phí ship cho mỗi đơn hàng </p>
        </div>
        <div class="mt-3 w-full bg-white rounded-md shadow-md px-4 order-content">
          <!-- Danh sách đơn hàng -->
          <!-- Một đơn hàng -->
          <?php if ($grouped_orders) { ?>
            <?php foreach ($grouped_orders as $order) { ?>
              <div class="px-2 py-4 border-b border-orange-200">
                <div class="flex justify-between items-center mb-2">
                  <div class="text-sm text-gray-500">Mã đơn: <span class="font-medium">#<?php echo $order['order_id'] ?></span></div>
                  <div class="text-sm text-yellow-600 font-semibold"><?php echo $order['order_status'] ?></div>
                </div>

                <?php foreach ($order['items'] as $item) { ?>
                  <div class="flex justify-between items-center mb-4">
                    <div class="flex items-center space-x-4">
                      <img
                        src="<?php echo $item['product_image'] ?>"
                        class="w-16 h-16 object-cover rounded"
                        alt="product">
                      <div class="flex-1">
                        <p class="text-[12px] lg:text-[14px] font-medium">Sản phẩm: <?php echo $item['product_name'] ?></p>
                        <p class="text-[12px] lg:text-[14px] text-gray-500">Số lượng: <?php echo $item['quantity'] ?></p>
                      </div>
                    </div>
                    <div class="text-right text-[14px]">
                      <p class="text-orange-500 font-semibold"><?php echo Format::forMatPrice($item['order_detail_price'] * $item['quantity']) ?>đ</p>
                    </div>
                  </div>
                <?php } ?>

                <div class="text-right">
                  <p class="text-red-500 font-semibold"><span class="text-[14px] text-gray-400">Tổng tiền:</span> <?php echo Format::forMatPrice($order['total_price']) ?>đ</p>
                  <p class="text-sm text-gray-600">Đặt lúc: <?php echo date('d/m/Y', strtotime($order['order_date'])) ?></p>
                </div>

                <div class="flex justify-end mt-4 space-x-2">
                  <button class="px-3 py-1 border rounded-md text-sm text-gray-600 hover:bg-gray-100">
                    <a href="<?php echo BASE_URL ?>/customer/order/detail/<?php echo $order['order_id'] ?>">Chi tiết</a>
                  </button>
                  <button
                    class="review-order flex items-center px-3 py-1 border rounded-md text-sm text-gray-600  hover:bg-red-400 <?php echo $order['order_review'] == 1 ? 'poiter-events-none user-select-none' : '' ?> <?php echo $order['order_status'] == 'Đã giao hàng' ? 'block' : 'hidden' ?>"
                    data-id="<?php echo $order['order_id'] ?>">
                    <i class="fa-solid fa-circle-check text-green-500 mr-2 <?php echo $order['order_review'] == 1 ? 'block' : 'hidden' ?>"></i>
                    <p><?php echo $order['order_review'] == 1 ? 'Đã nhận hàng' : 'Xác nhận nhận hàng' ?></p>
                  </button>
                  <!-- <button class=" px-3 py-1 bg-red-500 text-white rounded-md text-sm hover:bg-red-600">Hủy đơn</button> -->
                </div>
              </div>
            <?php } ?>
          <?php } else { ?>
            <div class="flex justify-center items-center flex-col py-5">
              <img src="<?php echo BASE_URL ?>/Public/images/no-order.png" alt="">
              <p class="mt-4 text-gray-500 font-semibold">Không có đơn hàng nào</p>
            </div>
          <?php } ?>
        </div>
      </div>
    </div>
    <dialog id="review_order_modal" class="modal">
      <div class="modal-box ">
        <div class="mb-3 text-lg font-semibold">
          <p>Đánh giá đơn hàng # <span id="order_modal_id" data-id=""></span></p>
        </div>
        <div class="review-content">
          <div class="text-[14px] text-gray-400">
            <div class="mt-2 text-center">
              <p>Đánh giá đơn hàng</p>
              <div class="rating py-1">
                <input type="radio" name="rating-order" value="1" class="mask mask-star-2 w-[17px] h-[17px] bg-green-500" aria-label="1 star" />
                <input type="radio" name="rating-order" value="2" class="mask mask-star-2 w-[17px] h-[17px] bg-green-500" aria-label="2 star" />
                <input type="radio" name="rating-order" value="3" class="mask mask-star-2 w-[17px] h-[17px] bg-green-500" aria-label="3 star" />
                <input type="radio" name="rating-order" value="4" class="mask mask-star-2 w-[17px] h-[17px] bg-green-500" aria-label="4 star" />
                <input type="radio" name="rating-order" value="5" class="mask mask-star-2 w-[17px] h-[17px] bg-green-500" aria-label="5 star" checked />
              </div>
            </div>
            <textarea type="text" name="comment-order" placeholder="Viết bình luận của bạn về đơn hàng" class="textarea textarea-info w-full mt-2"></textarea>
          </div>
          <div class="product-review-content text-[14px] text-gray-400 mt-2">
            <p class="text-center">Đánh giá sản phẩm</p>
          </div>
          <input type="hidden" name="csrf_token" value="<?php echo $csrf_token ?>">
        </div>
        <div class="flex justify-end text-[13px]">
          <button type="button" class="px-7 py-2 text-white font-semibold bg-red-700 rounded-md" id="btn-save-review">Gửi</button>
        </div>
      </div>
    </dialog>
  </div>
  <?php include_once VIEW_PATH_USER_LAYOUT . 'footer.php'; ?>