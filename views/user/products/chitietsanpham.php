<?php

use Core\Session;
use Helpers\CreateSlug;
use Helpers\Format;

include_once VIEW_PATH_USER_LAYOUT . 'header.php';

?>
<div class="container-fuild mx-auto">
  <div class="w-full mt-6 p-1">
    <div class="flex flex-col xl:flex-row ">
      <div class="product-detail-content shadow-sm p-1 xl:p-0">
        <div class="bg-white flex flex-col p-4 rounded-md" style="position: sticky;top:16px;">
          <div class="product-detail-image mb-2 mx-auto border-b border-gray-200">
            <img src="<?php echo $product['product_image'] ?>" data-lity class="w-full h-full" alt="product-image">
          </div>
          <div class="grid grid-cols-4 gap-2 flex-wrap shadow-sm">
            <img src="<?php echo $product['product_image'] ?>" alt="" width="60" height="60">
            <img src="<?php echo $product['product_image'] ?>" alt="" width="60" height="60">
            <img src="<?php echo $product['product_image'] ?>" alt="" width="60" height="60">
            <img src="<?php echo $product['product_image'] ?>" alt="" width="60" height="60">
            <img src="<?php echo $product['product_image'] ?>" class="" alt="" width="60" height="60">
          </div>
          <div class="hidden xl:flex py-5 justify-between">
            <a <?php echo !Session::has('user') ? 'href="' . BASE_URL . '/dang-nhap' . '"' : '' ?> class="<?php echo Session::has('user') ? 'addToCart' : '' ?> cursor-pointer" data-event="0" data-id="<?php echo $product['id'] ?>">
              <button type="button" class="flex product-box-btn items-center border-2 justify-center rounded-md border-red-700 mr-2" <?php echo $product['stock'] <= 0 ? 'disabled' : '' ?>>
                <i class="fa-solid fa-cart-shopping mr-3 text-red-600"></i>
                <p class="text-red-600 text-sm font-bold">Thêm vào giỏ hàng</p>
              </button>
            </a>
            <a <?php echo !Session::has('user') ? 'href="' . BASE_URL . '/dang-nhap' . '"' : '' ?> class="<?php echo Session::has('user') ? 'addToCart' : '' ?> cursor-pointer" data-event="1" data-id="<?php echo $product['id'] ?>">
              <button type="button" class="flex product-box-btn items-center justify-center rounded-md bg-red-700" <?php echo $product['stock'] <= 0 ? 'disabled' : '' ?>>
                <p class="text-white text-sm font-bold">Mua ngay</p>
              </button>
            </a>
          </div>
          <div class="hidden xl:flex flex-col">
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
      <div class="px-1 xl:ms-5 w-full">
        <!-- mobile price -->
        <div class="block bg-white xl:hidden rounded-md">
          <div class="flex flex-col py-1">
            <?php if ($product['f_quantity'] > 0) { ?>
              <div class="w-full bg-gradient-to-r from-[#e53935] to-[#ff7043] text-white py-2 ps-3">
                <img src="https://res.cloudinary.com/whr-clound/image/upload/v1746867428/dzxhpsuecpi8ktrjn3dr.svg" alt="icon_fs" class="">
              </div>
            <?php } ?>
            <div class="flex items-center ps-3">
              <p class="text-2xl font-bold text-red-700">
                <?php echo $product['f_quantity'] > 0 ? Format::forMatPrice($product['price'] - ($product['price'] * $product['f_discount_price'] / 100)) : Format::formatNumber($product['price'] - ($product['price'] * $product['discount_price'] / 100)) ?>
                đ</p>
              <p class="ms-3 text-gray-400 text-lg"><s><?php echo Format::forMatPrice($product['price']) ?></s></p>
              <span class="ms-3 bg-red-500 px-1 rounded-sm text-white text-[12px] font-bold">-<?php echo $product['f_quantity'] > 0 ? Format::formatNumber($product['f_discount_price']) : Format::formatNumber($product['discount_price']) ?>%</span>
            </div>
          </div>
        </div>
        <div class="bg-white rounded-md px-3 pb-2 xl:py-4 shadow-sm">
          <p class="text-[15px] xl:text-2xl font-bold"><?php echo $product['product_name'] ?>
            <?php if ($product['stock'] <= 0) { ?>
              <span class="text-red-700 ms-5 text-[13px] xl:hidden">Hết hàng</span>
            <?php } ?>
          </p>
          <?php if ($product['catalog_id'] == 10) { ?>
            <div class="mt-3 hidden xl:grid xl:grid-cols-2 px-3">
              <p class="text-sm">Nhà cung cấp: <span class="font-bold"><?php echo $product['supplier_name'] != null ? $product['supplier_name'] : 'Chưa cập nhật' ?></span></p>
              <p class="text-sm">Thương hiệu: <span class="font-bold"><?php echo $product['brand_name'] != null ? $product['brand_name'] : 'Chưa cập nhật' ?></span></p>
              <p class="text-sm mt-2">Xuất xứ: <span class="font-bold"><?php echo !empty($product['origin']) ? $product['origin'] : 'Chưa cập nhật' ?></span></p>
            </div>
          <?php } else if ($product['catalog_id'] == 11) { ?>
            <div class="mt-3 hidden xl:grid xl:grid-cols-2 px-3">
              <p class="text-sm">Nhà cung cấp: <span class="font-bold"><?php echo !empty($product['supplier_name']) ? $product['supplier_name'] : 'Chưa cập nhật' ?></span></p>
              <p class="text-sm">Thương hiệu: <span class="font-bold"><?php echo !empty($product['brand_name']) ? $product['brand_name'] : 'Chưa cập nhật' ?></span></p>
              <p class="text-sm mt-2">Xuất xứ: <span class="font-bold"><?php echo !empty($product['origin']) ? $product['origin'] : 'Chưa cập nhật' ?></span></p>
            </div>
          <?php } else { ?>
            <div class="mt-3 hidden xl:grid xl:grid-cols-2 px-3">
              <p class="text-sm">Nhà cung cấp: <span class="font-bold"><?php echo $product['supplier_name'] != null ? $product['supplier_name'] : 'Chưa cập nhật' ?></span></p>
              <p class="text-sm">Tác giả: <span class="font-bold"><?php echo $product['author'] != null ? $product['author'] : 'Chưa cập nhật' ?></span></p>
              <p class="text-sm mt-2">Nhà xuất bản: <span class="font-bold"><?php echo $product['publisher'] != null ? $product['publisher'] : 'Chưa cập nhật' ?></span></p>
              <p class="text-sm mt-2">Năm xuất bản: <span class="font-bold"><?php echo $product['publication_year'] != null ? $product['publication_year'] : 'Chưa cập nhật' ?></span></p>
            </div>
          <?php } ?>
          <?php if ($product['f_quantity'] > 0) { ?>
            <div class="mt-3 hidden xl:flex ">
              <img src="https://res.cloudinary.com/whr-clound/image/upload/v1745417547/xumhjzw0igzdwwgosq1k.svg" alt="icon_fs">
              <p class="text-lg font-bold ms-5">Còn lại: <span class="text-orange-500"><?php echo $product['f_quantity'] ?></span></p>
            </div>
          <?php } ?>
          <div class="mt-3 hidden xl:flex  items-center">
            <p class="text-3xl font-bold text-red-700">
              <?php echo $product['f_quantity'] > 0 ? Format::forMatPrice($product['price'] - ($product['price'] * $product['f_discount_price'] / 100)) : Format::formatNumber($product['price'] - ($product['price'] * $product['discount_price'] / 100)) ?>
              đ</p>
            <p class="ms-3 text-gray-400 text-lg"><s><?php echo Format::forMatPrice($product['price']) ?></s></p>
            <span class="ms-3 bg-red-500 px-1 rounded-sm text-white text-sm font-bold">-<?php echo $product['f_quantity'] > 0 ? Format::formatNumber($product['f_discount_price']) : Format::formatNumber($product['discount_price']) ?>%</span>
          </div>
        </div>
        <div class="bg-white flex flex-col p-4 rounded-md mt-3 ">
          <div>
            <p class="text-[14px] xl:text-lg font-bold">Thông tin vận chuyển</p>
            <div class="mt-2">
              <p class="text-[12px] xl:text-sm cursor-pointer" id="change-temp-address">Giao hàng đến: <span class="font-bold" id="temp_address">Phường Bến Nghé, Quận 1, Hồ Chí Minh</span><span class="ms-3 text-blue-600 font-bold">Thay đổi</span></p>
            </div>
          </div>
          <div class="mt-3 flex">
            <i class="fa-solid fa-truck text-orange-500 mr-4 mt-1"></i>
            <div class="flex flex-col">
              <p class="text-[14px] xl:text-lg font-bold">Giao hàng tiêu chuẩn</p>
              <p class="text-[12px] xl:text-sm">Dự kiến giao: <span class="font-bold"><?php $date = new DateTime();
                                                                                      echo $date->modify('+3 day')->format('d-m-Y'); ?></span></p>
            </div>
          </div>
          <div class="mt-3 flex items-center">
            <p class="text-[14px] xl:text-lg font-bold mr-3">Ưu dãi liên quan</p>
            <div class="text-blue-500 cursor-pointer flex text-[12px] xl:text-sm">
              <p class="mr-3">Xem thêm</p>
              <div style="width: 16px;height: 16px;background: url('https://res.cloudinary.com/whr-clound/image/upload/v1745417547/xumhjzw0igzdwwgosq1k.svg');background-repeat: no-repeat;margin-top: 2px;"></div>
            </div>
          </div>
          <div class="hidden xl:flex items-center mt-3">
            <p class="text-lg font-bold mr-3">Số lượng</p>
            <div class="flex items-center user-select-none">
              <div class="dec-quantity-product-detail flex items-center text-center m-1 bg-gray-100 text-gray-400 cursor-pointer hover:bg-gray-300 hover:text-white pointer-events-none opacity-75 <?php echo $product['stock'] <= 0 ? 'poiter-events-none' : '' ?>" style="width: 32px;height: 32px;">
                <span class="w-full "><i class="fa-solid fa-minus"></i></span>
              </div>
              <div class="p-2" style="width: 44px;">
                <input type="text" value="1" class="w-full text-center outline-none product-detail-quantity bg-white" name="cart-quantity" data-id="<?php echo $product['id'] ?> ">
              </div>
              <div class="inc-quantity-product-detail flex items-center text-center m-1 bg-gray-100 text-gray-400 cursor-pointer hover:bg-gray-300 hover:text-white <?php echo $product['stock'] <= 0 ? 'poiter-events-none' : '' ?>" style="width: 32px;height: 32px;">
                <span class="w-full"><i class="fa-solid fa-plus"></i></span>
              </div>
            </div>
            <?php if ($product['stock'] <= 0) { ?>
              <p class="text-red-700 ms-5 text-[14px]">Hết hàng</p>
            <?php } ?>
          </div>
        </div>
        <!-- THÔNG TIN CHI TIÊT -->
        <div class="bg-white rounded-md px-3 py-4 shadow-sm mt-5">
          <p class="font-bold text-[14px] xl:text-lg">Thông tin chi tiết</p>
          <table class="table-auto w-full text-[12px] xl:text-sm text-gray-500">
            <colgroup>
              <col width="40%">
              <col>
            </colgroup>
            <?php foreach ($product_attrs as $product_attr) { ?>
              <tr>
                <td class="p-2 border-b-sm align-middle"><?php echo $product_attr['attr_name']; ?></td>
                <td class="p-2 border-b-sm align-middle"><?php echo $product_attr['attr_value']; ?></td>
              </tr>
            <?php } ?>
          </table>
          <div class="mt-2 text-[12px] xl:text-sm">
            <p class="mb-1">Giá sản phẩm trên WildHorizon.com đã bao gồm thuế theo luật hiện hành. Bên cạnh đó, tuỳ vào loại sản phẩm,
              hình thức và địa chỉ giao hàng mà có thể phát sinh thêm chi phí khác như Phụ phí đóng gói, phí vận chuyển, phụ phí hàng cồng kềnh,...</p>
            <p class="text-red-500">Chính sách khuyến mãi trên WildHorizon.com không áp dụng cho Hệ thống Nhà sách WildHorizon trên toàn quốc</p>
          </div>
        </div>
        <div class="bg-white rounded-md px-3 py-4 shadow-sm mt-5">
          <p class="font-bold text-[14px] xl:text-lg">Mô tả sản phẩm</p>
          <p class="font-bold text-[14px] xl:text-sm mt-3"><?php echo $product['product_name'] ?></p>
          <p class="text-[12px] xl:text-sm text-gray-500 mt-2"><?php echo $product['p_description'] ? $product['p_description'] : '' ?></p>
        </div>
        <!-- moblie quanity, addcart template -->
        <div class="fixed w-full left-0 right-0 bottom-0 z-[999999] block xl:hidden">
          <div class="mx-auto max-w-[600px] w-full bg-white h-[65px] shadow-md flex items-center justify-center px-4 py-2">
            <div class="flex items-center user-select-none mr-2">
              <div class="dec-quantity-product-detail flex items-center text-center m-1 bg-gray-100 text-gray-400 cursor-pointer hover:bg-gray-300 hover:text-white pointer-events-none opacity-75 <?php echo $product['stock'] <= 0 ? 'poiter-events-none' : '' ?>" style="width: 32px;height: 32px;">
                <span class="w-full "><i class="fa-solid fa-minus"></i></span>
              </div>
              <div class="p-2" style="width: 44px;">
                <input type="text" value="1" class="w-full text-center outline-none product-detail-quantity bg-white" name="cart-quantity" data-id="<?php echo $product['id'] ?> ">
              </div>
              <div class="inc-quantity-product-detail flex items-center text-center m-1 bg-gray-100 text-gray-400 cursor-pointer hover:bg-gray-300 hover:text-white <?php echo $product['stock'] <= 0 ? 'poiter-events-none' : '' ?>" style="width: 32px;height: 32px;">
                <span class="w-full"><i class="fa-solid fa-plus"></i></span>
              </div>
            </div>
            <div class="flex justify-around py-5 w-full">
              <a <?php echo !Session::has('user') ? 'href="' . BASE_URL . '/dang-nhap' . '"' : '' ?> class="<?php echo Session::has('user') ? 'addToCart' : '' ?> cursor-pointer" data-event="0" data-id="<?php echo $product['id'] ?>">
                <button type="button" class="flex items-center h-[45px] px-2 border-2 justify-center rounded-md border-red-700 mr-2" <?php echo $product['stock'] <= 0 ? 'disabled' : '' ?>>
                  <p class="text-red-600 text-sm font-bold">Thêm vào giỏ hàng</p>
                </button>
              </a>
              <a <?php echo !Session::has('user') ? 'href="' . BASE_URL . '/dang-nhap' . '"' : '' ?> class="<?php echo Session::has('user') ? 'addToCart' : '' ?> cursor-pointer" data-event="1" data-id="<?php echo $product['id'] ?>">
                <button type="button" class="flex items-center h-[45px] px-2 justify-center rounded-md bg-red-700" <?php echo $product['stock'] <= 0 ? 'disabled' : '' ?>>
                  <p class="text-white text-sm font-bold">Mua ngay</p>
                </button>
              </a>
            </div>
          </div>
        </div>

      </div>
    </div>
    <div class="bg-white flex flex-col p-4 rounded-md mt-3 text-[12px] xl:text-sm">
      <p class="text-[16px] xl:text-lg font-bold">Đánh giá sản phẩm</p>
      <div class="flex items-center mt-3">
        <div class="flex flex-col w-1/4 mr-3 xl:mr-0">
          <div class="flex items-center text-lg xl:text-4xl justify-center">
            <i class="fa-solid fa-star fill-current text-orange-300 text-2xl"></i>
            <p class="ms-1"><?php echo !empty($avgRating) ? number_format(floatval($avgRating['avgRating']), 1, '.') : '0' ?><span class="text-sm text-gray-400">/5</span></p>
          </div>
          <p class="text-center text-sm text-gray-400"><?php echo count($reviews) . ' đánh giá' ?></p>
        </div>
        <div class="flex-1 xl:flex-none xl:w-1/3">
          <ul>
            <?php foreach ($rating_reviews as $rating) { ?>
              <li class="flex items-center text-[13px] xl:text-sm w-full mb-2">
                <p class="mr-2 flex items-center"><?php echo $rating['rating_id'] ?><i class="fa-solid fa-star fill-current text-orange-300 ms-1"></i></p>
                <div class="w-full bg-gray-200 rounded-lg" style="height: 6px;">
                  <p class="bg-orange-400 h-full rounded-lg" style="width: <?php echo !empty($rating['per']) ? intval($rating['per']) . '%' : '0%' ?>;"></p>
                </div>
                <span class="ps-2 font-bold" style="width: 35px;"><?php echo !empty($rating['per']) ? intval($rating['per']) . '%' : '0%' ?></span>
              </li>
            <?php } ?>
          </ul>
        </div>
      </div>
      <div class="px-2 py-1 xl:w-[70%]">
        <?php if (count($reviews) > 0) { ?>
          <?php foreach ($reviews as $review) { ?>
            <div class="mt-3 ps-2 py-1" style="font-size: 12px;">
              <p class="mb-1 pt-1 mr-2 text-[14px] font-semibold xl:text-sm"><?php echo $review['username'] ?></p>
              <div class="flex px-1 items-center">
                <?php for ($i = 1; $i <= 5; $i++) { ?>
                  <?php if ($i <= $review['rating_id']) { ?>
                    <i class="fa-solid fa-star fill-current text-orange-500"></i>
                  <?php } else { ?>
                    <i class="fa-regular fa-star fill-current text-orange-500"></i>
                  <?php } ?>
                <?php } ?>
                <div class="ms-2">
                  <span class="pt-1"><?php echo $review['created_at'] ?></span>
                </div>
              </div>
              <div class="mt-2 <?php echo $review['comment'] != null ? 'block' : 'hidden' ?>">
                <p class="text-[12px] xl:text-sm text-gray-600 ps-2"><?php echo $review['comment'] ?></p>
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
        <p class="text-[15px] xl:text-lg font-bold mb-3">Sản phẩm liên quan</p>
        <div class="more-product-detail">
          <div class="grid grid-cols-3 xl:grid-cols-5 gap-2 py-2 more-product-detail">
            <?php foreach ($moreProducts as $product) { ?>
              <a href="<?php echo  BASE_URL . '/product/' . CreateSlug::createSlug($product['product_name']) . '-' . $product['id'] . '' ?>" class="">
                <div class="bg-white flex flex-col hover:shadow-md hover:rounded-sm whr-product-content xl:min-h-[260px]">
                  <div class="whr-product-img py-2 h-[130px] xl:h-[180px]">
                    <img src="<?php echo $product['product_image']; ?>" class="w-full h-full" alt="image">
                  </div>
                  <div class="px-2 mt-2 pb-3">
                    <p class="product-title text-[13px] xl:text-sm xl:px-2"><?php echo $product['product_name'] ?></p>
                    <div class="flex items-start text-[12px] xl:px-2 xl:text-[15px] flex-col">
                      <div class="product-price">
                        <p class="text-orange-500 mr-2"><?php echo number_format($product['price'] - (($product['price'] * $product['discount_price'] / 100)), '0', '.', '.') ?><u class="ms-1">đ</u></p>
                        <p class="text-sm" style="font-size: 12px;"></p>
                      </div>
                      <?php if (isset($product['discount_price']) && $product['discount_price'] > 0) { ?>
                        <div class="product-price-sale">
                          <p class="flash-sale-product-price-sale"><s class="opacity-50">đ<?php echo number_format($product['price'], 0, '.', ',') ?></s>
                            <span class="text-white ms-2 bg-red-600 rounded-sm px-1 text-center text-[9px] xl:text-[11px]">-<?php echo number_format($product['discount_price'], 0) . '%' ?></span>
                          </p>
                        </div>
                      <?php  } ?>
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
      <div class="flex py-1 xl:h-[70px]" style="max-height: 70px;"></div>
      <div class="grid grid-cols-3 xl:grid-cols-5 gap-2 xl:gap-4 mt-7">
        <?php foreach ($suggest_products as $product) { ?>
          <a href="<?php echo  BASE_URL . '/product/' . CreateSlug::createSlug($product['product_name']) . '-' . $product['id'] . '' ?>" class="">
            <div class="bg-white flex flex-col hover:shadow-md hover:rounded-sm whr-product-content xl:min-h-[260px]">
              <div class="whr-product-img py-2 h-[130px] xl:h-[180px]">
                <img src="<?php echo $product['product_image']; ?>" class="w-full h-full" alt="image">
              </div>
              <div class="px-2 mt-2 pb-3">
                <p class="product-title text-[13px] xl:text-sm xl:px-2"><?php echo $product['product_name'] ?></p>
                <div class="flex items-start flex-col text-[12px] xl:text-[15px] xl:mt-2 xl:px-2">
                  <div class="product-price">
                    <p class="text-orange-500 mr-2"><?php echo number_format($product['price'] - (($product['price'] * $product['discount_price'] / 100)), '0', '.', '.') ?><u class="ms-1">đ</u></p>
                    <p class="text-sm" style="font-size: 12px;"></p>
                  </div>
                  <?php if (isset($product['discount_price']) && $product['discount_price'] > 0) { ?>
                    <div class="product-price-sale">
                      <p class="flash-sale-product-price-sale"><s class="opacity-50">đ<?php echo number_format($product['price'], 0, '.', ',') ?></s>
                        <span class="text-white ms-2 bg-red-600 rounded-sm px-1 text-center text-[9px] xl:text-[11px]">-<?php echo number_format($product['discount_price'], 0) . '%' ?></span>
                      </p>
                    </div>
                  <?php  } ?>
                </div>
              </div>
            </div>
          </a>
        <?php } ?>
      </div>
      <div class="mb-2 pt-3">
        <button type="button" class="load-more-product w-[100px] xl:w-full xl:text-sm text-[12px] xl:h-[40px] h-[35px] flex items-center justify-center"><a href="<?php echo BASE_URL . '/product' ?>">Load more</a></button>
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
        <p class="mr-2 text-[12px] xl:text-sm w-[140px] xl:w-full" style="max-width: 190px;">Chọn Tỉnh/Thành phố:</p>
        <select class="w-1/2 outline-none border border-gray-400 ps-2 py-2 rounded-md text-[12px] xl:text-sm" name="temp-address-province" id="temp-address-province">
          <option value="">Chọn tỉnh/thành phố</option>
        </select>
      </div>
      <div class="mt-3 flex text-nowrap items-center">
        <p class="mr-2 text-[12px] xl:text-sm w-[140px] xl:w-full" style="max-width: 190px;">Chọn Quận/Huyện:</p>
        <select class="w-1/2 outline-none border border-gray-400 ps-2 py-2 rounded-md text-[12px] xl:text-sm" name="temp-address-district" id="temp-address-district" disabled>
          <option value="">Chọn quận/huyện</option>
        </select>
      </div>
      <div class="mt-3 flex text-nowrap items-center">
        <p class="mr-2 text-[12px] xl:text-sm w-[140px] xl:w-full" style="max-width: 190px;">Chọn Phường/Xã:</p>
        <select class="w-1/2 outline-none border border-gray-400 ps-2 py-2 rounded-md text-[12px] xl:text-sm" name="temp-address-ward" id="temp-address-ward" disabled>
          <option value="">Chọn phường xã</option>
        </select>
      </div>
      <div class="flex justify-end items-center mt-3">
        <p class="text-sm text-gray-500 mr-5 cursor-pointer text-[13px] xl:text-sm" id="cancel-temp-address">Hủy</p>
        <button type="button" class="bg-red-700 text-white p-2 rounded-md pointer-events-none opacity-25 text-[14px] xl:text-sm" id="accept-temp-address">Xác nhận</button>
      </div>
    </div>
  </dialog>
</div>
<?php include_once VIEW_PATH_USER_LAYOUT . 'footer.php' ?>