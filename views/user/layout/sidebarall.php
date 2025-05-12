<div class="bg-white px-2 mr-3 mt-3 rounded-md text-nowrap w-full lg:w-1/5">
  <div class="flex items-center px-2 py-2 justify-between border-b border-gray-200 lg:py-4 lg:px-2">
    <p class="lg:text-xl text-red-700 font-semibold uppercase">Lọc theo</p>
    <label class="inline-grid btn btn-circle swap swap-rotate bg-white border-none hover:bg-white shadow-none lg:hidden ">
      <!-- this hidden checkbox controls the state -->
      <input type="checkbox" id="filter_on_off" />

      <!-- hamburger icon -->
      <i class="fa-solid fa-caret-down swap-off fill-current text-[20px]" id="filter-down"></i>
      <!-- close icon -->
      <i class="fa-solid fa-caret-up swap-on fill-current text-[20px]" id="filter-up"></i>
    </label>
  </div>
  <div class="hidden w-full sticky lg:block" style="top: 16px;" id="sidebar_product">
    <div class="mt-2 px-1">
      <p class="font-bold mb-1 text-[14px] lg:text-[16px]">Danh mục sản phẩm</p>
      <ul class="px-2 py-1 text-slate-500 text-[13px] lg:text-[14px] border-b border-gray-100 auto-maxheight" style="max-height: 200px;" id="list_catagories">
        <li class="leading-5 mb-2 hover:text-orange-400">
          <a class="<?php echo parse_url(basename($_SERVER['REQUEST_URI']), PHP_URL_PATH) == 'product' ? 'text-orange-500' : '' ?>" href="<?php echo BASE_URL . '/product' ?>">Tất cả danh mục</a>
        </li>
        <?php foreach ($categories as $category) { ?>
          <li class="leading-5 mb-2 hover:text-orange-400">
            <a href="<?php echo BASE_URL . '/category/' . \Helpers\CreateSlug::createSlug($category['catalog_name']) . '-' . $category['id'] . '' ?>">
              <?php echo $category['catalog_name'] ?>
            </a>
          </li>
        <?php } ?>
      </ul>
      <button class="flex justify-center text-[13px] text-red-500 cursor-pointer w-full font-bold mt-2" onclick="toggleContent('#list_catagories')">Xem thêm</button>
    </div>
    <div class="mt-2 px-1 border-b border-gray-100">
      <p class="font-bold mb-1 text-[14px] lg:text-[16px]">Giá</p>
      <ul class="px-2 py-1 text-slate-500 text-[13px] lg:text-[14px]">
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
    <div class="mt-2 px-1">
      <p class="font-bold mb-1 text-[14px] lg:text-[16px]">Nhà cung cấp</p>
      <ul class="px-2 py-1 text-slate-500 text-[13px] lg:text-[14px] auto-maxheight border-b border-gray-100" style=" max-height: 200px;" id="list_supplier_name">
        <?php foreach ($suppliers as $supplier) { ?>
          <li class="leading-5 mb-2  hover:text-orange-400 cursor-pointer">
            <a class="ps-5 supplier-unchecked filter" id="supplier-m-<?php echo $supplier['id'] ?>" data-id="<?php echo $supplier['id'] ?>">
              <?php echo $supplier['supplier_name'] ?>
            </a>
          </li>
        <?php } ?>
      </ul>
      <button class="flex justify-center text-[13px] text-red-500 cursor-pointer w-full font-bold py-2" onclick="toggleContent('#list_supplier_name')">Xem thêm</button>
    </div>
    <div class="mt-2 px-1 border-b">
      <p class="font-bold mb-1 text-[14px] lg:text-[16px]">Thương hiệu</p>
      <ul class="px-2 py-1 text-slate-500 text-[13px] lg:text-[14px] auto-maxheight border-gray-100" style="max-height: 200px;" id="list_brand_name">
        <?php foreach ($brands as $brand) { ?>
          <li class="leading-5 mb-2  hover:text-orange-400 cursor-pointer">
            <a class="ps-5 brand-unchecked filter" id="brand-m-<?php echo $brand['id'] ?>" data-id="<?php echo $brand['id'] ?>">
              <?php echo $brand['brand_name'] ?>
            </a>
          </li>
        <?php } ?>
      </ul>
      <!-- <button class="flex justify-center text-[13px] text-red-500 cursor-pointer w-full font-bold mt-2" onclick="toggleContent('#list_brand_name')">Xem thêm</button> -->
    </div>
    <div class="mt-2 px-1 border-b">
      <p class="font-bold mb-1 text-[14px] lg:text-[16px]">Màu sắc</p>
      <ul class="px-2 py-1 text-slate-500 text-[13px] lg:text-[14px] border-gray-100" style="max-height: 200px;" id="list_color">
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
      <!-- <button class="flex justify-center text-[13px] text-red-500 cursor-pointer w-full font-bold mt-2" onclick="toggleContent('#list_color')">Xem thêm</button> -->
    </div>
  </div>
</div>