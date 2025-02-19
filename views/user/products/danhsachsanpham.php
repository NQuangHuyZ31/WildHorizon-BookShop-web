<?php include_once VIEW_PATH_USER_LAYOUT . 'header.php'; ?>
<div class="container-fuild mx-auto">
  <div class="flex">
    <div class="bg-white px-2 mr-3 mt-3 rounded-md text-nowrap w-1/5">
      <div class="w-full sticky" style="top: 16px;">
        <div class="mt-2 px-1 border-b border-gray-100">
          <p class="font-bold mb-1">Danh mục sản phẩm</p>
          <p class="ps-1 text-slate-600"><a class="<?php echo parse_url(basename($_SERVER['REQUEST_URI']),PHP_URL_PATH) == 'product' ? 'text-orange-500' : '' ?>" href="<?php echo BASE_URL . '/product' ?>">Tất cả danh mục</a></p>
          <ul class="ms-3 px-2 py-1 text-slate-500" style="font-size: 14px;">
            <?php foreach ($categories as $category) { ?>
              <li class="leading-5 mb-2 hover:text-orange-400">
                <a href="<?php echo BASE_URL . '/category/' . \Core\CreateSlug::createSlug($category['name']) . '-' . $category['catalog_id'] . '' ?>">
                  <?php echo $category['name'] ?>
                </a>
              </li>
            <?php } ?>
          </ul>
        </div>
        <div class="mt-2 px-1 border-b border-gray-100">
          <p class="font-bold mb-1">Giá</p>
          <ul class="px-2 py-1 text-slate-500" style="font-size: 14px;">
            <li class="leading-5 mb-2 hover:text-orange-400">
              <a class="ps-5 price-unchecked cursor-pointer" id="price-m-1" data-id="1" data-from="0" data-to="150000">
                0đ - 150,000đ
              </a>
            </li>
            <li class="leading-5 mb-2 hover:text-orange-400">
              <a class="ps-5 price-unchecked cursor-pointer" id="price-m-2" data-id="2" data-from="1500000" data-to="300000">
                150,000đ - 300,000đ
              </a>
            </li>
            <li class="leading-5 mb-2 hover:text-orange-400">
              <a class="ps-5 price-unchecked cursor-pointer" id="price-m-3" data-id="3" data-from="300000" data-to="500000">
                300,000đ - 500,000đ
              </a>
            </li>
            <li class="leading-5 mb-2 hover:text-orange-400">
              <a class="ps-5 price-unchecked cursor-pointer" id="price-m-4" data-id="4" data-from="500000" data-to="700000">
                500,000đ - 700,000đ
              </a>
            </li>
            <li class="leading-5 mb-2 hover:text-orange-400">
              <a class="ps-5 price-unchecked cursor-pointer" id="price-m-5" data-id="5" data-from="700000" data-to="">
                700,000đ - Trở lên
              </a>
            </li>
          </ul>
        </div>
        <div class="mt-2 px-1 border-b border-gray-100">
          <p class="font-bold mb-1">Nhà xuất bản</p>
          <ul class="px-2 py-1 text-slate-500" style="font-size: 14px;">
            <li class="leading-5 mb-2">
              <a class="ps-5 price-unchecked" id="price-m-1" data-id="1" data-from="0" data-to="150000">
                0đ - 150,000đ
              </a>
            </li>
          </ul>
        </div>
        <div class="mt-2 px-1 border-b border-gray-100">
          <p class="font-bold mb-1">Thương hiệu</p>
          <ul class="px-2 py-1 text-slate-500" style="font-size: 14px;">
            <li class="leading-5 mb-2">
              <a class="ps-5 price-unchecked" id="price-m-1" data-id="1" data-from="0" data-to="150000">
                0đ - 150,000đ
              </a>
            </li>
          </ul>
        </div>
        <div class="mt-2 px-1 border-b border-gray-100">
          <p class="font-bold mb-1">Màu sắc</p>
          <ul class="px-2 py-1 text-slate-500" style="font-size: 14px;">
            <li class="leading-5 mb-2">
              <a class="ps-5 price-unchecked" id="price-m-1" data-id="1" data-from="0" data-to="150000">
                0đ - 150,000đ
              </a>
            </li>
          </ul>
        </div>
      </div>
    </div>
    <div class="whr-product-main flex-1">
      <div class="mt-3 ps-4 bg-white py-3 rounded-sm">
        <p class="text-lg uppercase font-bold text-orange-400"><?php echo isset($keyword) ? $keyword : 'Tất cả sản phẩm' ?></p>
        <p class="text-gray-400 text-sm">Showing results for <?php echo count($products) ?> sản phẩm</p>
      </div>
      <?php if (!empty($products)) { ?>
        <div class="grid grid-cols-4 mt-4 whr-product">
          <?php foreach ($products as $product) { ?>
            <a href="<?php echo  '/WildHorizon-BookShop/product/' . \Core\CreateSlug::createSlug($product['name']) . '-' . $product['product_id'] . '' ?>" class="mr-3 mb-4">
              <div class="bg-white flex flex-col hover:shadow-md hover:rounded-sm whr-product-content">
                <div class="whr-product-img py-2">
                  <img src="<?php echo BASE_URL_NAME ?>/Public/upload/products/<?php echo $product['image']; ?>" class="w-full h-full" alt="image">
                </div>
                <div class="px-2 mt-2">
                  <p class="product-title text-sm"><?php echo $product['name'] ?></p>
                  <div class="product-price-sale">
                    <p class="text-orange-500"><u class="text-orange-500">đ</u><?php echo number_format($product['price'], 0, '.', ',') ?></p>
                    <p class="flash-sale-product-price-sale <?php echo $product['discount_price'] > 0 ? '' : 'hidden' ?>"><s class="opacity-50">đ<?php echo number_format($product['price'] * (1 + $product['discount_price'] / 100), 0, '.', ',') ?></s>
                      <span class="text-white ms-2 bg-red-600 rounded-sm px-0.5">-<?php echo $product['discount_price'] . '%' ?></span>
                    </p>
                  </div>
                </div>
              </div>
            </a>
          <?php } ?>
        </div>
        <?php if (count($products) > 10) { ?>
          <div class="mb-2 pt-3">
            <button type="button" id="loadMore-product" class="load-more-product"
              data-offset="<?php echo isset($primaryProduct) ? 30 : 10 ?>"
              data-load="<?php echo isset($primaryProduct) ? 1 : 0 ?>">Load more</button>
          </div>
        <?php } ?>
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
</div>
<?php include_once VIEW_PATH_USER_LAYOUT . 'footer.php' ?>