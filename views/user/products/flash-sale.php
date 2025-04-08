<?php

use Helpers\CreateSlug;
use Helpers\Format;

include_once VIEW_PATH_USER_LAYOUT . 'header.php'
?>

<div class="container-fuild mx-auto">
  <div class="whr-flash-sale">
    <?php if (!empty($fs_products)) { ?>
      <div class="grid grid-cols-6 mt-4 whr-product-flash-sale">
        <?php foreach ($fs_products as $fs_product) { ?>
          <a href="<?php echo BASE_URL . '/product/' . CreateSlug::createSlug($fs_product['product_name']) . '-' . $fs_product['product_id'] . '' ?>" class="mr-2 bg-white mb-3">
            <div class="flex flex-col ">
              <div class="whr-product-img py-2">
                <img src="<?php echo BASE_URL ?>/Public/upload/products/<?php echo $fs_product['product_image'] ?>" class="w-full h-full" alt="sanpham">
              </div>
              <div class="flash-sale-product mt-1 mx-2">
                <p class="text-sm flash-sale-product-title"><?php echo $fs_product['product_name'] ?></p>
                <div class="flash-sale-product-price">
                  <p class="text-orange-500"><?php echo Format::forMatPrice($fs_product['price'] - ($fs_product['price'] * $fs_product['discount_price'] / 100), 0, '.', ',') ?><u class="text-orange-500 ms-1">đ</u></p>
                  <p class="flash-sale-product-price-sale"><s class="opacity-50">đ<?php echo Format::forMatPrice($fs_product['price'], 0, '.', ',') ?></s>
                    <span class="text-white ms-2 bg-red-600 rounded-sm px-1">-<?php echo Format::formatNumber($fs_product['discount_price']) . '%' ?></span>
                  </p>
                </div>
              </div>
            </div>
            <div class="flex justify-end px-1">
              <p class="text-gray-400" style="font-size: 11px;"><?php echo 'còn ' . $fs_product['quantity'] . ' sản phẩm' ?></p>
            </div>
            <div class="flex" style="height: 16px;"></div>
          </a>
        <?php } ?>
      </div>
      <div class="mb-2 pt-3">
        <button type="button" class="load-more-product" id="loadmore-product-fs" data-offset="10">Load more</button>
      </div>
    <?php } else { ?>
      <div class="text-center mt-4">
        <p class="text-2xl text-red-400">Không có sản phẩm.</p>
      </div>
      <div class="flex flex-col justify-center text-center mt-4">
        <p class="text-sm text-gray-500">Quay lại mua sắm</p>
        <div class="text-center mt-2">
          <button type="button" class="bg-orange-400 rounded-sm text-white" style="width: 240px;height: 50px;"><a href="<?php echo BASE_URL . '/' ?>" class="w-full">Go to Shopping</a></button>
        </div>
      </div>
    <?php } ?>
  </div>
</div>
<?php include_once VIEW_PATH_USER_LAYOUT . 'footer.php' ?>