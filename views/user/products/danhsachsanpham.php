<?php

use Helpers\CreateSlug;
use Helpers\Format;

include_once VIEW_PATH_USER_LAYOUT . 'header.php';

?>
<div class="container-fuild mx-auto">
  <div class="flex">
    <?php include_once  VIEW_PATH_USER_LAYOUT . 'sidebarall.php'; ?>
    <div class="whr-product-main flex-1">
      <div class="mt-3 ps-4 bg-white py-3 rounded-sm">
        <p class="text-lg uppercase font-bold text-orange-400"><?php echo isset($keyword) ? $keyword : 'Tất cả sản phẩm' ?></p>
        <p class="text-gray-400 text-sm">Showing results for
          <span class="product-count"><?php echo count($products) ?></span> sản phẩm
        </p>
      </div>
      <?php if (!empty($products)) { ?>
        <div class="grid grid-cols-4 mt-4 whr-product gap-4">
          <?php foreach ($products as $product) { ?>
            <a href="<?php echo  BASE_URL . '/product/' . CreateSlug::createSlug($product['product_name']) . '-' . $product['id'] . '' ?>" class="">
              <div class="bg-white flex flex-col hover:shadow-md hover:rounded-sm whr-product-content lg:min-h-[260px]">
                <div class="whr-product-img py-2 main-img-product">
                  <img src="<?php echo $product['product_image']; ?>" class="w-full h-full" alt="image">
                </div>
                <div class="px-2 mt-2">
                  <p class="text-[12px] lg:text-sm flash-sale-product-title"><?php echo $product['product_name'] ?></p>
                  <div class="product-price-sale">
                    <p class="text-orange-500">
                      <?php echo $product['f_discount_price'] > 0 ? Format::forMatPrice($product['price'] - ($product['price'] * $product['f_discount_price'] / 100)) : Format::forMatPrice($product['price'] - ($product['price'] * $product['discount_price'] / 100)) ?>
                      <u class="text-orange-500 ms-1">đ</u>
                    </p>
                    <div class="flex justify-between items-center">
                      <p class="flash-sale-product-price-sale <?php echo $product['discount_price'] > 0 || $product['f_discount_price'] > 0 ? '' : 'hidden' ?>"><s class="opacity-50">đ<?php echo Format::forMatPrice($product['price']) ?></s>
                        <span class="text-white ms-2 bg-red-600 rounded-sm px-1">-<?php echo ($product['f_discount_price'] > 0 ? Format::formatNumber($product['f_discount_price']) : Format::formatNumber($product['discount_price'])) . '%' ?></span>
                      </p>
                      <img src="https://res.cloudinary.com/whr-clound/image/upload/v1745417547/xumhjzw0igzdwwgosq1k.svg" alt="icon_fs" width="70" height="40" class="mr-2 <?php echo $product['f_quantity'] > 0 ? '' : 'hidden' ?>">
                    </div>
                  </div>
                </div>
              </div>
            </a>
          <?php } ?>
        </div>
        <?php if (count($products) > 10) { ?>
          <div class="mb-2 pt-3">
            <button type="button" id="loadMore-product" class="load-more-product w-[100px] lg:w-full lg:text-sm text-[11px] lg:h-[40px] h-[35px] flex items-center justify-center"
              data-offset="<?php echo isset($primaryProduct) ? 30 : 10 ?>"
              data-load="<?php echo isset($primaryProduct) ? 1 : 0 ?>">Load more</button>
          </div>
        <?php } ?>
      <?php } else { ?>
        <div class="text-center mt-4">
          <p class="text-xl lg:text-2xl text-red-400">Không có sản phẩm.</p>
        </div>
        <div class="flex flex-col justify-center text-center mt-4">
          <p class="text-[12px] lg:text-sm text-gray-500">Quay lại mua sắm</p>
          <div class="text-center mt-2">
            <button type="button" class="bg-orange-400 rounded-sm text-white" style="width: 240px;height: 50px;"><a href="<?php echo BASE_URL . '/product' ?>" class="w-full">Go to Shopping</a></button>
          </div>
        </div>
      <?php } ?>
    </div>
  </div>
</div>
<?php include_once VIEW_PATH_USER_LAYOUT . 'footer.php' ?>