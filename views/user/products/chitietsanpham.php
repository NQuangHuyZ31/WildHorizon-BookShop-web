<?php include_once VIEW_PATH_USER_LAYOUT . 'header.php'; ?>
<div class="container-fuild mx-auto">
  <div class="w-full mt-6 p-1">
    <div class="flex">
      <div class="product-detail-content shadow-sm">
        <div class="bg-white flex flex-col p-4 rounded-md" style="position: sticky;top:16px;">
          <div class="product-detail-image mb-2 mx-auto">
            <img src="<?php echo BASE_URL_NAME ?>/Public/upload/products/<?php echo $product['image'] ?>" class="w-full h-full" alt="product-image">
          </div>
          <div class="flex justify-around shadow-sm">
            <img src="<?php echo BASE_URL_NAME ?>/Public/upload/products/<?php echo $product['image'] ?>" class="mr-5" alt="" width="60" height="60">
            <img src="<?php echo BASE_URL_NAME ?>/Public/upload/products/<?php echo $product['image'] ?>" class="mr-5" alt="" width="60" height="60">
            <img src="<?php echo BASE_URL_NAME ?>/Public/upload/products/<?php echo $product['image'] ?>" class="mr-5" alt="" width="60" height="60">
            <img src="<?php echo BASE_URL_NAME ?>/Public/upload/products/<?php echo $product['image'] ?>" class="mr-5" alt="" width="60" height="60">
            <img src="<?php echo BASE_URL_NAME ?>/Public/upload/products/<?php echo $product['image'] ?>" class="" alt="" width="60" height="60">
          </div>
          <div class="flex py-5 justify-between">
            <a <?php echo !\Core\Session::has('user') ? 'href="' . BASE_URL . '/dang-nhap' . '"' : '' ?> class="<?php echo \Core\Session::has('user') ? 'addToCart' : '' ?> cursor-pointer" data-event="0" data-id="<?php echo $product['product_id'] ?>">
              <button type="button" class="flex product-box-btn items-center border-2 justify-center rounded-md border-red-700 mr-2">
                <i class="fa-solid fa-cart-shopping mr-3 text-red-600"></i>
                <p class="text-red-600 text-sm font-bold">Thêm vào giỏ hàng</p>
              </button>
            </a>
            <a <?php echo !\Core\Session::has('user') ? 'href="' . BASE_URL . '/dang-nhap' . '"' : '' ?> class="<?php echo \Core\Session::has('user') ? 'addToCart' : '' ?> cursor-pointer" data-event="1" data-id="<?php echo $product['product_id'] ?>">
              <button type="button" class="flex product-box-btn items-center justify-center rounded-md bg-red-700">
                <p class="text-white text-sm font-bold">Mua ngay</p>
              </button>
            </a>
          </div>
          <div class="flex flex-col">
            <p class="text-sm font-bold mb-3">Chính sách ưu đãi của WildHorizon BookShop</p>
            <div class="text-sm">
              <a href="<?php echo BASE_URL . '/chinh-sach/delivery' ?>" class="flex items-center mb-3">
                <i class="fa-solid fa-truck text-red-700 mr-2"></i>
                <p class="font-bold">Thời gian giao hàng:</p>
                <p class="ps-1">Giao nhanh và uy tín</p>
              </a>
              <a href="<?php echo BASE_URL . '/chinh-sach/return' ?>" class="flex items-center mb-3">
                <i class="fa-solid fa-box text-red-700 mr-2"></i>
                <p class="font-bold">Chính sách đổi trả:</p>
                <p class="ps-1">Đổi trả miễn phí toàn quốc</p>
              </a>
              <a href="<?php echo BASE_URL . '/chinh-sach/customer' ?>" class="flex items-center">
                <i class="fa-solid fa-store text-red-700 mr-2"></i>
                <p class="font-bold">Chính sách khách sỉ:</p>
                <p class="ps-1">Ưu đãi khi mua số lượng lớn</p>
              </a>
            </div>
          </div>
        </div>
      </div>
      <!-- THÔNG TIN SẢN PHẨM -->
      <div class="ms-5 w-full">
        <div class="bg-white rounded-md px-3 py-4 shadow-sm">
          <p class="text-2xl font-bold"><?php echo $product['name'] ?></p>
          <?php if ($product['catalog_id'] == 10) { ?>
            <div class="mt-3">
              <p class="inline-block w-1/2 text-sm">Nhà cung cấp: <span class="font-bold"><?php echo !empty($product['author']) ? $product['author'] : 'Chưa cập nhật' ?></span></p>
              <p class="inline-block w-1/3 text-sm">Thương hiệu: <span class="font-bold"><?php echo !empty($product['author']) ? $product['author'] : 'Chưa cập nhật' ?></span></p>
              <p class="inline-block w-1/2 text-sm mt-2">Xuất xứ: <span class="font-bold">Thế giới</span></p>
            </div>
          <?php } else if ($product['catalog_id'] == 11) { ?>
            <div class="mt-3">
              <p class="inline-block w-1/2 text-sm">Nhà cung cấp: <span class="font-bold"><?php echo !empty($product['author']) ? $product['author'] : 'Chưa cập nhật' ?></span></p>
              <p class="inline-block w-1/3 text-sm">Thương hiệu: <span class="font-bold"><?php echo !empty($product['author']) ? $product['author'] : 'Chưa cập nhật' ?></span></p>
              <p class="inline-block w-1/2 text-sm mt-2">Xuất xứ: <span class="font-bold">Thế giới</span></p>
            </div>
          <?php } else { ?>
            <div class="mt-3">
              <p class="inline-block w-1/2 text-sm">Nhà cung cấp: <span class="font-bold"><?php echo !empty($product['author']) ? $product['author'] : 'Chưa cập nhật' ?></span></p>
              <p class="inline-block w-1/3 text-sm">Tác giả: <span class="font-bold"><?php echo !empty($product['author']) ? $product['author'] : 'Chưa cập nhật' ?></span></p>
              <p class="inline-block w-1/2 text-sm mt-2">Nhà xuất bản: <span class="font-bold">Thế giới</span></p>
              <p class="inline-block w-1/3 text-sm mt-2">Năm xuất bản: <span class="font-bold"><?php echo !empty($product['publish_year']) ? $product['publish_year'] : 'Chưa cập nhật' ?></span></p>
            </div>
          <?php } ?>
          <?php if (!empty($fs_product)) { ?>
            <div class="mt-3 flex">
              <img src="<?php echo BASE_URL_NAME . '/Public/images/icon/label-flashsale.svg' ?>" alt="icon_fs">
              <p class="text-lg font-bold ms-5">Còn lại: <span class="text-orange-500"><?php echo $fs_product['quantity'] ?></span></p>
            </div>
            <div class="mt-3 flex items-center">
              <p class="text-3xl font-bold text-red-700"><?php echo number_format($product['price'] - ($product['price'] * $fs_product['discount_price'] / 100), 0, '.', ',') ?> đ</p>
              <p class="ms-3 text-gray-400 text-lg"><s><?php echo number_format($product['price'], 0, '.', ',') ?></s></p>
              <span class="ms-3 bg-red-500 px-1 rounded-sm text-white text-sm font-bold">-<?php echo $fs_product['discount_price'] ?>%</span>
            </div>
          <?php
          } else { ?>
            <div class="mt-3">
              <p class="text-3xl font-bold text-red-700"><?php echo number_format($product['price'], 0, '.', ',') ?> đ</p>
            </div>
          <?php } ?>
        </div>
        <div class="bg-white flex flex-col p-4 rounded-md mt-3">
          <div>
            <p class="text-lg font-bold">Thông tin vận chuyển</p>
            <div class="mt-2">
              <p class="text-sm cursor-pointer" id="change-temp-address">Giao hàng đến: <span class="font-bold" id="temp_address">Phường Bến Nghé, Quận 1, Hồ Chí Minh</span><span class="ms-3 text-blue-600 font-bold">Thay đổi</span></p>
            </div>
          </div>
          <div class="mt-3 flex">
            <i class="fa-solid fa-truck text-orange-500 mr-4 mt-1"></i>
            <div class="flex flex-col">
              <p class="font-bold">Giao hàng tiêu chuẩn</p>
              <p class="text-sm">Dự kiến giao: <span class="font-bold"><?php $date = new DateTime();
                                                                        echo $date->modify('+3 day')->format('d-m-Y'); ?></span></p>
            </div>
          </div>
          <div class="mt-3 flex items-center">
            <p class="font-bold mr-3">Ưu dãi liên quan</p>
            <div class="text-blue-500 cursor-pointer flex text-sm">
              <p class="mr-3">Xem thêm</p>
              <div style="width: 16px;height: 16px;background: url('https://cdn0.fahasa.com/skin/frontend/ma_vanese/fahasa/images/ico_seemore_blue.svg');background-repeat: no-repeat;margin-top: 2px;"></div>
            </div>
          </div>
          <div class="flex items-center mt-3">
            <p class="font-bold mr-3">Số lượng</p>
            <div class="flex items-center">
              <div class="dec-quantity-product-detail flex items-center text-center m-1 bg-gray-100 text-gray-400 cursor-pointer hover:bg-gray-300 hover:text-white pointer-events-none opacity-75" style="width: 32px;height: 32px;">
                <span class="w-full "><i class="fa-solid fa-minus"></i></span>
              </div>
              <div class="p-2" style="width: 44px;">
                <input type="text" value=1 class="w-full text-center outline-none product-detail-quantity" name="cart-quantity" data-id="<?php echo $product['product_id'] ?>">
              </div>
              <div class="inc-quantity-product-detail flex items-center text-center m-1 bg-gray-100 text-gray-400 cursor-pointer hover:bg-gray-300 hover:text-white" style="width: 32px;height: 32px;">
                <span class="w-full"><i class="fa-solid fa-plus"></i></span>
              </div>
            </div>
          </div>
        </div>
        <!-- THÔNG TIN CHI TIÊT -->
        <div class="bg-white rounded-md px-3 py-4 shadow-sm mt-5">
          <p class="font-bold text-lg">Thông tin chi tiết</p>
          <table class="table-auto w-full text-sm text-gray-500">
            <colgroup>
              <col width="25%">
              <col>
            </colgroup>
            <tr>
              <td class="p-2 border-b-sm">Tên nhà cung cấp</td>
              <td class="p-2 border-b-sm">Đông A</td>
            </tr>
            <tr>
              <td class="p-2 border-b-sm">Tác giả</td>
              <td class="p-2 border-b-sm">Đông A</td>
            </tr>
            <tr>
              <td class="p-2 border-b-sm">NXB</td>
              <td class="p-2 border-b-sm">Đại Học Sư phạm</td>
            </tr>
            <tr>
              <td class="p-2 border-b-sm">Năm XB</td>
              <td class="p-2 border-b-sm">2024</td>
            </tr>
            <tr>
              <td class="p-2 border-b-sm">Ngôn Ngữ</td>
              <td class="p-2 border-b-sm">Tiếng Việt</td>
            </tr>
            <tr>
              <td class="p-2 border-b-sm">Kích Thước Bao Bì</td>
              <td class="p-2 border-b-sm">30 x 25 x 3.7 cm</td>
            </tr>
            <tr>
              <td class="p-2 border-b-sm">Số trang</td>
              <td class="p-2 border-b-sm">660</td>
            </tr>
            <tr>
              <td class="p-2">Hình thức</td>
              <td class="p-2">Bìa Cứng</td>
            </tr>
          </table>
          <div class="mt-2 text-sm">
            <p class="mb-1">Giá sản phẩm trên WildHorizon.com đã bao gồm thuế theo luật hiện hành. Bên cạnh đó, tuỳ vào loại sản phẩm,
              hình thức và địa chỉ giao hàng mà có thể phát sinh thêm chi phí khác như Phụ phí đóng gói, phí vận chuyển, phụ phí hàng cồng kềnh,...</p>
            <p class="text-red-500">Chính sách khuyến mãi trên WildHorizon.com không áp dụng cho Hệ thống Nhà sách WildHorizon trên toàn quốc</p>
          </div>
        </div>
        <div class="bg-white rounded-md px-3 py-4 shadow-sm mt-5">
          <p class="font-bold text-lg">Mô tả sản phẩm</p>
          <p class="font-bold text-sm mt-3"><?php echo $product['name'] ?></p>
          <p class="text-sm text-gray-500 mt-2"><?php echo $product['description'] != null ? $product['description'] : '' ?></p>
        </div>
      </div>
    </div>
    <div class="bg-white flex flex-col p-4 rounded-md mt-3">
      <p class="text-lg font-bold">Đánh giá sản phẩm</p>
      <div class="flex items-center mt-3">
        <div class="flex flex-col w-1/4">
          <div class="flex items-center text-4xl justify-center">
            <i class="fa-solid fa-star fill-current text-orange-300 text-lg"></i>
            <p class="ms-1"><?php echo !empty($rating_reviews) ? '5' : '0' ?><span class="text-sm text-gray-400">/5</span></p>
          </div>
          <p class="text-center text-sm text-gray-400"><?php echo count($reviews) . ' đánh giá' ?></p>
        </div>
        <div class="w-1/3">
          <ul>
            <li class="flex items-center text-sm w-full mb-2">
              <p class="mr-2 flex items-center">5<i class="fa-solid fa-star fill-current text-orange-300 ms-1"></i></p>
              <div class="w-full bg-gray-200 rounded-lg" style="height: 6px;">
                <p class="bg-orange-400 h-full rounded-lg" style="width: <?php echo !empty($rating_reviews['per']) ? intval($rating_reviews['per']) . '%' : '0%' ?>;"></p>
              </div>
              <span class="ps-2 font-bold" style="width: 35px;"><?php echo !empty($rating_reviews['per']) ? intval($rating_reviews['per']) . '%' : '0%' ?></span>
            </li>
            <li class="flex items-center text-sm w-full mb-2">
              <p class="mr-2 flex items-center">4<i class="fa-solid fa-star fill-current text-orange-300 ms-1"></i></p>
              <div class="w-full bg-gray-200 rounded-lg" style="height: 6px;">
              </div>
              <p class="ms-2 font-bold">0%</p>
            </li>
            <li class="flex items-center text-sm w-full mb-2">
              <p class="mr-2 flex items-center">3<i class="fa-solid fa-star fill-current text-orange-300 ms-1"></i></p>
              <div class="w-full bg-gray-200 rounded-lg" style="height: 6px;">
              </div>
              <p class="ms-2 font-bold">0%</p>
            </li>
            <li class="flex items-center text-sm w-full mb-2">
              <p class="mr-2 flex items-center">2<i class="fa-solid fa-star fill-current text-orange-300 ms-1"></i></p>
              <div class="w-full bg-gray-200 rounded-lg" style="height: 6px;">
              </div>
              <p class="ms-2 font-bold">0%</p>
            </li>
            <li class="flex items-center text-sm w-full">
              <p class="mr-2 flex items-center">1<i class="fa-solid fa-star fill-current text-orange-300 ms-1"></i></p>
              <div class="w-full bg-gray-200 rounded-lg" style="height: 6px;">
              </div>
              <p class="ms-2 font-bold">0%</p>
            </li>
          </ul>
        </div>
      </div>
      <div class="px-2 py-1">
        <?php if (count($reviews) > 0) { ?>
          <?php foreach ($reviews as $review) { ?>
            <div class="mt-3 ps-2 py-1" style="font-size: 12px;">
              <p class="mb-1 pt-1 mr-2"><?php echo $review['username'] ?></p>
              <div class="flex px-1 items-center">
                <?php for ($i = 1; $i <= 5; $i++) { ?>
                  <?php if ($i <= $review['rating']) { ?>
                    <i class="fa-solid fa-star fill-current text-orange-500"></i>
                  <?php } else { ?>
                    <i class="fa-regular fa-star fill-current text-orange-500"></i>
                  <?php } ?>
                <?php } ?>
                <div class="ms-2">
                  <span class="pt-1"><?php echo $review['created_at'] ?></span>
                </div>
              </div>
              <div class="mt-2">
                <p class="text-sm text-gray-600 ps-2"><?php echo $review['comment'] ?></p>
              </div>
            </div>
          <?php } ?>
        <?php } else { ?>
          <p class="text-orange-400 mt-2 px-2 py-1">(<?php echo count($reviews) ?>) đánh giá sản phẩm</p>
        <?php } ?>
      </div>
    </div>
    <?php if (count($moreProducts) > 0) { ?>
      <div class="bg-white flex flex-col p-4 rounded-md mt-3">
        <p class="text-lg font-bold mb-3">Sản phẩm liên quan</p>
        <div class="more-product-detail">
          <div class="grid grid-cols-6 py-2 more-product-detail">
            <?php foreach ($moreProducts as $product) { ?>
              <a href="<?php echo  '/WildHorizon-BookShop/product/' . \Core\CreateSlug::createSlug($product['name']) . '-' . $product['product_id'] . '' ?>" class="mr-3 mb-4">
                <div class="bg-white flex flex-col hover:shadow-md hover:rounded-sm whr-product-content">
                  <div class="whr-product-img py-2">
                    <img src="<?php echo BASE_URL_NAME ?>/Public/upload/products/<?php echo $product['image']; ?>" class="w-full h-full" alt="image">
                  </div>
                  <div class="px-2 mt-2">
                    <p class="product-title text-sm"><?php echo $product['name'] ?></p>
                    <div class="flash-sale-product-price">
                      <p class="text-orange-500"><u class="text-orange-500">đ</u><?php echo number_format($product['price'], 0, '.', ',') ?></p>
                      <p class="flash-sale-product-price-sale <?php echo $product['discount_price'] > 0 ? '' : 'hidden' ?>"><s class="opacity-50">đ<?php echo number_format($product['price'] * (1 + $product['discount_price'] / 100), 0, '.', ',') ?></s><span class="text-white ms-2 bg-red-600 rounded-sm px-0.5">-<?php echo $product['discount_price'] . '%' ?></span></p>
                    </div>
                  </div>
                </div>
              </a>
            <?php } ?>
          </div>
        </div>
      </div>
    <?php } ?>
    <div class="rounded-md mt-3 product-suggest">
      <div class="flex py-1" style="height: 70px;"></div>
      <div class="grid grid-cols-5 mt-7">
        <?php foreach ($suggest_products as $product) { ?>
          <a href="<?php echo  '/WildHorizon-BookShop/product/' . \Core\CreateSlug::createSlug($product['name']) . '-' . $product['product_id'] . '' ?>" class="mr-3 mb-4">
            <div class="bg-white flex flex-col hover:shadow-md hover:rounded-sm whr-product-content">
              <div class="whr-product-img py-2">
                <img src="<?php echo BASE_URL_NAME ?>/Public/upload/products/<?php echo $product['image']; ?>" class="w-full h-full" alt="image">
              </div>
              <div class="px-2 mt-2">
                <p class="product-title text-sm"><?php echo $product['name'] ?></p>
                <div class="flash-sale-product-price">
                  <p class="text-orange-500"><u class="text-orange-500">đ</u><?php echo number_format($product['price'], 0, '.', ',') ?></p>
                  <p class="flash-sale-product-price-sale <?php echo $product['discount_price'] > 0 ? '' : 'hidden' ?>"><s class="opacity-50">đ<?php echo number_format($product['price'] * (1 + $product['discount_price'] / 100), 0, '.', ',') ?></s><span class="text-white ms-2 bg-red-600 rounded-sm px-0.5">-<?php echo $product['discount_price'] . '%' ?></span></p>
                </div>
              </div>
            </div>
          </a>
        <?php } ?>
      </div>
      <div class="mb-2 pt-3">
        <button type="button" id="loadMore-product" class="load-more-product"><a href="<?php echo BASE_URL . '/product' ?>">Load more</a></button>
      </div>
    </div>
  </div>

  <!-- MODAL NOTIFICATION -->
  <!-- Open the modal using ID.showModal() method -->
  <!-- <button class="btn" onclick="my_modal_1.showModal()">open modal</button> -->
  <dialog id="model_temp_address" class="modal">
    <div class="modal-box">
      <!-- <form method="dialog">
        <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2" id="btn-close-modal">✕</button>
      </form> -->
      <h3 class="text-lg font-bold border-b-2 border-gray-300 pb-2 text-center">Chọn địa chỉ giao hàng của bạn</h3>
      <div class="mt-3 flex text-nowrap items-center">
        <p class="mr-2" style="width: 190px;">Chọn Tỉnh/Thành phố:</p>
        <select class="w-1/2 outline-none border border-gray-400 ps-2 py-2 rounded-md " name="temp-address-province" id="temp-address-province">
          <option value="">Chọn tỉnh/thành phố</option>
        </select>
      </div>
      <div class="mt-3 flex text-nowrap items-center">
        <p class="mr-2" style="width: 190px;">Chọn Quận/Huyện:</p>
        <select class="w-1/2 outline-none border border-gray-400 ps-2 py-2 rounded-md " name="temp-address-district" id="temp-address-district" disabled>
          <option value="">Chọn quận/huyện</option>
        </select>
      </div>
      <div class="mt-3 flex text-nowrap items-center">
        <p class="mr-2" style="width: 190px;">Chọn Phường/Xã:</p>
        <select class="w-1/2 outline-none border border-gray-400 ps-2 py-2 rounded-md " name="temp-address-ward" id="temp-address-ward" disabled>
          <option value="">Chọn phường xã</option>
        </select>
      </div>
      <div class="flex justify-end items-center mt-3">
        <p class="text-sm text-gray-500 mr-5 cursor-pointer" id="cancel-temp-address">Hủy</p>
        <button type="button" class="bg-red-700 text-white p-2 rounded-md pointer-events-none opacity-25" id="accept-temp-address">Xác nhận</button>
      </div>
    </div>
  </dialog>
</div>
<?php include_once VIEW_PATH_USER_LAYOUT . 'footer.php' ?>