<div class="bg-white px-2 mr-3 mt-3 rounded-md text-nowrap w-1/5">
  <div class="w-full sticky" style="top: 16px;">
    <div class="mt-2 px-1 border-b border-gray-100">
      <p class="font-bold mb-1">Danh mục sản phẩm</p>
      <p class="ps-1 text-slate-600"><a class="<?php echo parse_url(basename($_SERVER['REQUEST_URI']), PHP_URL_PATH) == 'product' ? 'text-orange-500' : '' ?>" href="<?php echo BASE_URL . '/product' ?>">Tất cả danh mục</a></p>
      <ul class="ms-3 px-2 py-1 text-slate-500" style="font-size: 14px;">
        <?php foreach ($categories as $category) { ?>
          <li class="leading-5 mb-2 hover:text-orange-400">
            <a href="<?php echo BASE_URL . '/category/' . \Core\CreateSlug::createSlug($category['catalog_name']) . '-' . $category['id'] . '' ?>">
              <?php echo $category['catalog_name'] ?>
            </a>
          </li>
        <?php } ?>
      </ul>
    </div>
    <div class="mt-2 px-1 border-b border-gray-100">
      <p class="font-bold mb-1">Giá</p>
      <ul class="px-2 py-1 text-slate-500" style="font-size: 14px;">
        <li class="leading-5 mb-2 hover:text-orange-400">
          <a class="ps-5 price-unchecked filter cursor-pointer" id="price-m-1" data-id="1" data-from="0" data-to="150000">
            0đ - 150,000đ
          </a>
        </li>
        <li class="leading-5 mb-2 hover:text-orange-400">
          <a class="ps-5 price-unchecked filter cursor-pointer" id="price-m-2" data-id="2" data-from="1500000" data-to="300000">
            150,000đ - 300,000đ
          </a>
        </li>
        <li class="leading-5 mb-2 hover:text-orange-400">
          <a class="ps-5 price-unchecked filter cursor-pointer" id="price-m-3" data-id="3" data-from="300000" data-to="500000">
            300,000đ - 500,000đ
          </a>
        </li>
        <li class="leading-5 mb-2 hover:text-orange-400">
          <a class="ps-5 price-unchecked filter cursor-pointer" id="price-m-4" data-id="4" data-from="500000" data-to="700000">
            500,000đ - 700,000đ
          </a>
        </li>
        <li class="leading-5 mb-2 hover:text-orange-400">
          <a class="ps-5 price-unchecked filter cursor-pointer" id="price-m-5" data-id="5" data-from="700000" data-to="">
            700,000đ - Trở lên
          </a>
        </li>
      </ul>
    </div>
    <div class="mt-2 px-1 border-b border-gray-100">
      <p class="font-bold mb-1">Nhà cung cấp</p>
      <ul class="px-2 py-1 text-slate-500" style="font-size: 14px;">
        <?php foreach ($suppliers as $supplier) { ?>
          <li class="leading-5 mb-2  hover:text-orange-400 cursor-pointer">
            <a class="ps-5 supplier-unchecked filter" id="supplier-m-<?php echo $supplier['id'] ?>" data-id="<?php echo $supplier['id'] ?>">
              <?php echo $supplier['supplier_name'] ?>
            </a>
          </li>
        <?php } ?>
      </ul>
    </div>
    <div class="mt-2 px-1 border-b border-gray-100">
      <p class="font-bold mb-1">Thương hiệu</p>
      <ul class="px-2 py-1 text-slate-500" style="font-size: 14px;">
        <?php foreach ($brands as $brand) { ?>
          <li class="leading-5 mb-2  hover:text-orange-400 cursor-pointer">
            <a class="ps-5 brand-unchecked filter" id="brand-m-<?php echo $brand['id'] ?>" data-id="<?php echo $brand['id'] ?>">
              <?php echo $brand['brand_name'] ?>
            </a>
          </li>
        <?php } ?>
      </ul>
    </div>
    <div class="mt-2 px-1 border-b border-gray-100">
      <p class="font-bold mb-1">Màu sắc</p>
      <ul class="px-2 py-1 text-slate-500" style="font-size: 14px;">
        <?php foreach ($colors as $color) { ?>
          <?php if ($color['color'] != null) { ?>
            <li class="leading-5 mb-2  hover:text-orange-400 cursor-pointer">
              <a class="ps-5 filter color-unchecked" data-value="<?php echo $color['color'] ?>">
                <?php echo $color['color'] ?>
              </a>
            </li>
          <?php } ?>
        <?php } ?>
        </li>
      </ul>
    </div>
  </div>
</div>