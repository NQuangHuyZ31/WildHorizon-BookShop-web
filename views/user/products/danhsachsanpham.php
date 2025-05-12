<?php

use Helpers\CreateSlug;
use Helpers\Format;

include_once VIEW_PATH_USER_LAYOUT . 'header.php';

?>
<div class="container-fuild mx-auto">
  <div class="flex flex-col px-2 lg:px-0 lg:flex-row">
    <?php include_once  VIEW_PATH_USER_LAYOUT . 'sidebarall.php'; ?>
    <div class="flex-1">
      <div class="mt-3 ps-4 bg-white py-3 rounded-md flex items-center">
        <p class="text-[14px] lg:text-[16px] uppercase font-bold text-black"><?php echo isset($keyword) ? $keyword : 'Tất cả sản phẩm' ?></p>
        <p class="text-blue-500 text-[12px] lg:text-[14px] ms-1">(
          <span class="product-count"><?php echo count($products) ?></span> sản phẩm)
        </p>
      </div>
      <?php if (!empty($products)) { ?>
        <div class="grid grid-cols-3 mt-2 gap-2 whr-product lg:gap-4 lg:grid-cols-5 lg:mt-4">
          <?php foreach ($products as $product) { ?>
            <a href="<?php echo  BASE_URL . '/product/' . CreateSlug::createSlug($product['product_name']) . '-' . $product['id'] . '' ?>" class="">
              <div class="bg-white flex flex-col hover:shadow-md hover:rounded-sm whr-product-content pb-2 lg:pb-0 lg:min-h-[260px]">
                <div class="py-2 h-[130px] lg:h-[180px]">
                  <img src="<?php echo $product['product_image']; ?>" class="w-full h-full" alt="image">
                </div>
                <div class="px-2 mt-2">
                  <p class="text-[13px] lg:text-sm flash-sale-product-title"><?php echo $product['product_name'] ?></p>
                  <div class="product-price-sale text-[12px] lg:text-sm">
                    <p class="text-orange-500">
                      <?php echo $product['f_discount_price'] > 0 ? Format::forMatPrice($product['price'] - ($product['price'] * $product['f_discount_price'] / 100)) : Format::forMatPrice($product['price'] - ($product['price'] * $product['discount_price'] / 100)) ?>
                      <u class="text-orange-500 ms-1">đ</u>
                    </p>
                    <div class="flex justify-between items-center">
                      <p class="flash-sale-product-price-sale <?php echo $product['discount_price'] > 0 || $product['f_discount_price'] > 0 ? '' : 'hidden' ?>"><s class="opacity-50">đ<?php echo Format::forMatPrice($product['price']) ?></s>
                        <span class="text-white ms-1 bg-red-600 rounded-sm px-1 text-[9px] lg:text-[11px]">-<?php echo ($product['f_discount_price'] > 0 ? Format::formatNumber($product['f_discount_price']) : Format::formatNumber($product['discount_price'])) . '%' ?></span>
                      </p>
                      <div class="hidden lg:block">
                        <img src="https://res.cloudinary.com/whr-clound/image/upload/v1745417547/xumhjzw0igzdwwgosq1k.svg" alt="icon_fs" class="px-1 w-[40px] h-[auto] lg:w-[70px] <?php echo $product['f_quantity'] > 0 ? '' : 'hidden' ?>">
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </a>
          <?php } ?>
        </div>
        <?php if (count($products) > 10) { ?>
          <div class="mb-2 pt-3">
            <button type="button" id="loadMore-product" class="load-more-product w-[100px] lg:w-full lg:text-sm text-[11px] lg:h-[40px] h-[35px] flex items-center justify-center" data-offset="30">Load more</button>
          </div>
        <?php } ?>
      <?php } else { ?>
        <div class="flex flex-col justify-center bg-white h-auto mt-2 rounded-md py-3 mb-3 lg:mb-0 lg:py-6">
          <div class="text-center">
            <p class="text-[15px] lg:text-xl text-red-400">Không có sản phẩm.</p>
          </div>
          <div class="flex flex-col justify-center text-center lg:mt-2">
            <p class="text-[12px] lg:text-sm text-gray-500">Quay lại mua sắm</p>
            <div class="text-center mt-2 text-[12px] lg:text-sm">
              <button type="button" class="bg-orange-400 rounded-md text-white px-4 py-1 lg:px-7 lg:py-2"><a href="<?php echo BASE_URL . '/product' ?>" class="w-full">Quay lại mua sắm</a></button>
            </div>
          </div>
        </div>
      <?php } ?>
    </div>
  </div>
</div>
<?php include_once VIEW_PATH_USER_LAYOUT . 'footer.php' ?>