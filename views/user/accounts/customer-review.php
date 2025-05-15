<?php include_once VIEW_PATH_USER_LAYOUT . 'header.php'; ?>

<div class="w-full xl:max-w-screen-xl xl:mx-auto">
  <div class="w-full mt-3 mb-3">
    <div class="flex flex-col xl:mb-0 xl:flex-row w-full">
      <div class="xl:w-1/4">
        <?php include_once VIEW_PATH_USER_LAYOUT . 'sidebar-customer.php' ?>
      </div>
      <div class="flex-1 px-1 min-h-[550px] xl:ms-3">
        <div class="w-full bg-white rounded-md shadow-sm xl:shadow-md pb-4 px-4">
          <div class="p-4">
            <p class="text-sm xl:text-lg font-bold text-slate-500">Nhận xét của tôi</p>
            <div class="mt-3 border border-gray-200 rounded-md p-3">
              <p class="text-[12px] xl:text-sm text-gray-400 font-semibold">Đánh giá đơn hàng</p>
              <?php if ($order_reviews != null) { ?>
                <?php foreach ($order_reviews as $review) { ?>
                  <div class="border border-gray-200 rounded-md p-2 mt-3">
                    <div class="mb-2">
                      <div class="text-[13px] text-nowrap xl:text-sm text-gray-600 flex items-center justify-between">
                        <p>Mã đơn: <span class="font-semibold text-orange-400">#<?php echo $review['order_id'] ?></span></p>
                        <p class="text-[10px] xl:text-[12px] text-gray-400">Ngày đánh giá: <span><?php echo date('d-m-Y', strtotime($review['created_at'])) ?></span></p>
                      </div>
                      <div class="flex items-center text-[12px] xl:text-sm text-gray-400 py-2">
                        <p>Rating: </p>
                        <div class="rating py-1 ms-3">
                          <?php for ($i = 1; $i <= 5; $i++) { ?>
                            <?php if ($i == $review['rating_id']) { ?>
                              <input
                                type="radio"
                                name="rating-order-<?php echo $review['order_id'] ?>"
                                value="<?php echo $i ?>" class="mask mask-star-2 w-[15px] h-[15px] bg-green-500"
                                aria-label="<?php echo $i ?> star"
                                checked disabled />
                            <?php } else { ?>
                              <input
                                type="radio"
                                name="rating-order-<?php echo $review['order_id'] ?>"
                                value="<?php echo $i ?>"
                                class="mask mask-star-2 w-[15px] h-[15px] bg-green-500"
                                aria-label="<?php echo $i ?> star"
                                disabled />
                            <?php } ?>
                          <?php } ?>
                        </div>
                      </div>
                      <div class="text-[13px] xl:text-sm flex items-center">
                        <p>Nội dung đánh giá:</p>
                        <p class="ms-2"><?php echo $review['comment'] != null ? $review['comment'] : 'Không có đánh giá' ?></p>
                      </div>
                      <div class="flex justify-end">
                        <div class="mt-2 flex justify-around items-center gap-2">
                          <button class="px-3 py-1 border rounded-md text-[11px] xl:text-sm text-gray-600 hover:bg-gray-100">
                            <a href="<?php echo BASE_URL ?>/customer/order/detail/<?php echo $review['order_id'] ?>">Xem lại đơn hàng</a>
                          </button>
                          <button class="review-product-reseen px-3 py-1 border rounded-md text-[11px] xl:text-sm text-gray-600 hover:bg-gray-100" data-id="<?php echo $review['order_id'] ?>">
                            Xem đánh giá sản phẩm
                          </button>
                        </div>
                      </div>
                    </div>
                  </div>
                <?php } ?>
              <?php } else { ?>
                <div class="mt-3 flex text-[13px] text-nowrap xl:text-sm items-center ps-3">
                  <i class="fa-solid fa-circle-question mr-2 text-orange-300"></i>
                  <p class="text-red-700 font-semibold xl:text-sm text-[11px]">Bạn chưa có đánh giá nào.</p>
                </div>
              <?php } ?>
            </div>
            <?php if ($feedbacks != null) { ?>
              <div class="mt-7 border border-gray-200 rounded-md p-3">
                <p class="text-[12px] xl:text-sm text-gray-400 font-semibold">Các feedback đã được trả lời</p>
                <?php foreach ($feedbacks as $feedback) { ?>
                  <div class="border border-gray-200 rounded-md p-2 mt-3">
                    <p class="text-[12px] xl:text-sm mb-3 text-gray-500">Ngày gửi: <span class="text-[13px]"><?php echo date('d-m-Y', strtotime($feedback['created_at'])) ?></span></p>
                    <div class="flex items-center text-[13px] text-nowrap xl:text-sm p-2">
                      <p class="text-[13px] text-nowrap font-semibold xl:text-sm">Loại:</p><span class="ms-2"><?php echo $feedback['type'] ?></span>
                    </div>
                    <div class="text-[13px] text-nowrap xl:text-sm p-2">
                      <p class="text-[13px] text-nowrap font-semibold xl:text-sm">Nội dung:<span class="ms-2 text-wrap font-normal"><?php echo $feedback['content'] ?></span></p>
                    </div>
                    <div class="text-[13px] text-nowrap font-semibold xl:text-sm p-2">
                      <p class="mb-1">Hình ảnh kèm theo:</p>
                      <?php if ($feedback['image'] != null) { ?>
                        <img src="<?php echo $feedback['image'] ?>" data-lity alt=" hình ảnh feedback" class="w-[100px] h-[100px] cursor-pointer">
                      <?php } else { ?>
                        <p class="ms-2">Không có hình ảnh kèm theo</p>
                      <?php } ?>
                    </div>
                    <div class="flex justify-end">
                      <button class="btn-feedback px-3 py-1 border rounded-md text-sm text-gray-600 hover:bg-gray-100" data-id="<?php echo $feedback['feedback_id'] ?>">
                        <i class="fa-solid fa-circle-check text-green-500 mr-2"></i> Đã phản hồi
                      </button>
                    </div>
                  </div>
                <?php } ?>
              </div>
            <?php } ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- Modal -->
<dialog id="review_product_modal" class="modal">
  <div class="modal-box ">
    <form method="dialog">
      <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</button>
    </form>
    <div class="review-content w-full">
      <div class="review-product-content text-[12px] xl:text-sm text-gray-400 mt-2">
        <p class="text-center">Feekback đã gửi</p>
      </div>
    </div>
  </div>
</dialog>
<!-- Modal feedback answer -->
<dialog id="feedback_modal" class="modal">
  <div class="modal-box ">
    <form method="dialog">
      <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</button>
    </form>
    <div class="feedback-content w-full">
      <p>Phản hồi bởi Admin</p>
      <textarea type="text" placeholder="Viết bình luận của bạn về sản phẩm" class="textarea textarea-info w-full mt-2 textarea-feedback" readonly></textarea>
    </div>
  </div>
</dialog>
<?php include_once VIEW_PATH_USER_LAYOUT . 'footer.php'; ?>