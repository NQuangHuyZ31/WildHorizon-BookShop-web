<?php

use Helpers\Format;
use Core\Session;
use Helpers\CreateSlug;

Session::delete('error');
include_once VIEW_PATH_USER_LAYOUT . 'header.php'

?>
<div class="container-fuild mx-auto p-1 xl:p-0">
  <div class="mt-3 xl:min-h-[400px]">
    <!-- -->
    <?php if (\Core\Session::has('user')) { ?>
      <?php if (count($products) > 0) { ?>
        <div class="flex flex-col xl:flex-row xl:justify-between">
          <div class="xl:w-full" style="max-width:788px">
            <div class="flex justify-between w-full bg-white px-3 py-2 rounded-sm">
              <div class="flex items-center">
                <p class=" text-gray-500 uppercase text-[12px] xl:text-sm ms-3">Tất cả sản phẩm (<?php echo count($products) ?> sản phẩm)</p>
              </div>
            </div>
            <form id="form-checkout" action="<?php echo BASE_URL . '/checkout/process' ?>" method="post">
              <input type="hidden" name="csrf_token" value="<?php echo $csrf_token ?>">
              <div class="w-full mt-3 flex flex-col">
                <?php foreach ($products as $product) { ?>
                  <div class="flex items-center bg-white px-3 py-2 cart-product-item mb-3 rounded-sm">
                    <div class="flex items-center">
                      <div class="border border-orange-500 bg-orange-500 rounded-sm cursor-pointer cart-item-checkbox relative" style="width: 16px; height: 17px;">
                        <i class="px-0.5 text-sm fa-solid fa-check text-white absolute top-0 cart-icon-checkbox cursor-pointer"></i>
                        <input type="checkbox" class="hidden cart-input-checkbox" name="cart-product-id[]" value="<?php echo $product['id'] ?>" checked>
                      </div>
                      <div class="xl:ms-3 align-middle">
                        <a href="<?php echo BASE_URL . '/product/' . CreateSlug::createSlug($product['product_name']) . '-' . $product['id'] ?>">
                          <img src="<?php echo $product['product_image'] ?>" alt="img-product" style="width: 70px;height: 80px;">
                        </a>
                      </div>
                    </div>
                    <div class="flex justify-start w-[300px] xl:w-full xl:items-center flex-col xl:flex-row">
                      <div class="flex items-start xl:ms-3 text-sm xl:w-full" style="max-width: 328px;">
                        <p class="w-full text-[13px] xl:text-[14px]"><?php echo $product['product_name'] ?></p>
                      </div>
                      <div class="flex flex-row items-center gap-2 xl:gap-0 xl:flex-col xl:ms-6 xl:w-full xl:items-start" style="max-width: 100px;">
                        <p class="text-orange-400 text-sm xl:text-lg text-nowrap">
                          <?php echo $product['f_quantity'] > 0 ? 'đ ' . Format::forMatPrice($product['price'] - ($product['price'] * ($product['f_discount_price'] / 100)))
                            : 'đ ' . Format::forMatPrice($product['price'] - ($product['price'] * ($product['discount_price'] / 100))) ?>
                        </p>
                        <p class="text-gray-300 text-sm text-nowrap"><s><?php echo 'đ ' . Format::forMatPrice($product['price']) ?></s></p>
                        <button type="button" class="cart-delete-product" data-id="<?php echo $product['id'] ?>">
                          <i class="fa-regular fa-trash-can text-gray-400 text-[12px] xl:text-sm ps-1 pt-2"></i>
                        </button>
                      </div>
                      <div class="flex items-center text-[12px] xl:text-[14px] xl:ms-10 xl:p-3 user-select-none">
                        <div class="dec-quantity flex items-center text-center m-1 bg-gray-100 text-gray-400 cursor-pointer hover:bg-gray-300 hover:text-white" style="width: 32px;height: 32px;">
                          <span class="w-full "><i class="fa-solid fa-minus"></i></span>
                        </div>
                        <div class="p-2" style="width: 44px;">
                          <input type="text" value="<?php echo $product['cart_quantity'] ?>" class="w-full text-center outline-none cart-product-quantity bg-white" name="cart-quantity[]" data-productID="<?php echo $product['id'] ?>">
                        </div>
                        <div
                          class="<?php echo $product['f_quantity'] > 0 ? ($product['f_quantity'] == $product['cart_quantity'] ? 'pointer-events-none' : '') : ($product['stock'] == $product['cart_quantity'] ? 'pointer-events-none' : '') ?>
                            inc-quantity flex items-center text-center m-1 bg-gray-100 text-gray-400 cursor-pointer hover:bg-gray-300 hover:text-white"
                          style="width: 32px;height: 32px;">
                          <span class="w-full"><i class="fa-solid fa-plus"></i></span>
                        </div>
                      </div>
                    </div>
                  </div>
                <?php } ?>
              </div>
            </form>
          </div>
          <div class="bg-white px-3 py-4 xl:ms-2 flex-1 rounded-md" style="max-height: 250px;">
            <div class="mb-3">
              <p class="text-[14px] xl:text-lg">Tổng tiền đơn hàng</p>
            </div>
            <div class="flex justify-between text-gray-500 text-[12px] xl:text-sm mb-4">
              <p class="checkout-subtotal">Thành tiền</p>
              <p class="mr-2 checkout-subtotal-price text-sm"><span id="cart-subtotal"><?php echo Format::forMatPrice($totalPrice) ?></span> <u>đ</u></p>
            </div>
            <div class="flex justify-between text-gray-500 text-[12px] xl:text-sm mb-4">
              <p class="checkout-subtotal">Giảm giá</p>
              <p class="mr-2 checkout-subtotal-price text-red-400">- <span id="cart-saved"><?php echo Format::forMatPrice($saveprice) ?></span> <u>đ</u></p>
            </div>
            <div class="flex justify-between text-gray-500 text-[12px] xl:text-sm mb-4">
              <p class="checkout-subtotal">Phí vận chuyển (tiêu chuẩn)</p>
              <p class="mr-2 checkout-subtotal-price text-red-400"><span id="fee-shipping">23.000</span> <u>đ</u></p>
            </div>
            <div class="flex justify-between text-black text-[14px] xl:text-sm">
              <p class="checkout-subtotal">Tổng tiền</p>
              <p class="mr-2 checkout-subtotal-price text-orange-500 text-[15px] xl:text-lg"> <span id="cart-total"><?php echo Format::forMatPrice($totalPrice - $saveprice + 23000) ?></span><u>đ</u></p>
            </div>
            <div class="mt-2 text-center bg-orange-500 text-white py-2 rounded-md" id="cart-checkout">
              <button type="button" class="cursor-pointer w-full xl:text-sm text-[14px]" name="btn-checkout" id="btn-checkout">Đặt hàng</button>
            </div>
          </div>
        </div>
      <?php } else { ?>
        <div class="mt-4 bg-white flex flex-col justify-center items-center p-5 ">
          <div class="mb-3 flex justify-center">
            <img src="https://res.cloudinary.com/whr-clound/image/upload/v1745417547/poqkthizdksp4b1fhhqm.png" alt="no-product-image" class="w-[50%] xl:w-full h-full">
          </div>
          <p class="mb-4 text-[12px] xl:text-sm text-gray-400">Chưa có sản phẩm trong giỏ hàng của bạn</p>
          <div class="mb-3" style="width: 220px;height: 40px;">
            <button type="button" class="bg-red-600 text-white w-full h-full uppercase rounded-md"><a href="<?php echo BASE_URL . '/product' ?>" class="w-full h-full xl:text-sm text-[13px]">Mua sắm ngay</a></button>
          </div>
        </div>
      <?php } ?>
    <?php } else { ?>
      <div class="flex flex-col justify-center bg-white py-4 rounded-md shadow-sm p-1 xl:p-0 xl:py-4">
        <div class="mb-3 flex justify-center items-center">
          <img src="https://res.cloudinary.com/whr-clound/image/upload/v1745417547/poqkthizdksp4b1fhhqm.png" alt="no-product-image" class="w-[50%] xl:w-1/5 h-full">
        </div>
        <div class="flex flex-col">
          <div class="text-center mt-3 text-[14px] xl:text-lg text-gray-600">
            <p class="p-1">Bạn chưa đăng nhập.</p>
            <p class="text-sm text-gray-400">Đăng nhập để thêm sản phẩm vào giỏ hàng!</p>
          </div>
          <div class="text-center mt-4">
            <button type="button" class="bg-orange-500 p-2 hover:bg-orange-600 rounded-md" style="height: 50px;width: 240px;"><a href="<?php echo BASE_URL . '/dang-nhap' ?>" class="text-white text-[12px] xl:text-md">Sign in/Sign up</a></button>
          </div>
          <div class="text-center mt-6">
            <button type="button" class="p-2 hover:bg-orange-100 rounded-md border border-orange-400" style="height: 50px;width: 240px;"><a href="<?php echo BASE_URL . '/' ?>" class="text-orange-400 text-[12px] xl:text-md">Go to Shopping</a></button>
          </div>
        </div>
      </div>
    <?php } ?>
  </div>
  <!--  -->
  <div class="mt-8 p-1 bg-white rounded-md xl:p-5 xl:max-w-screen-xl xl:mx-auto">
    <div class="px-3 py-3 rounded-t-md flex items-center border-b border-gray-200">
      <div class="w-[35px] h-[35px] flex items-center justify-center rounded-md" style="background: url(https://res.cloudinary.com/whr-clound/image/upload/v1747141655/mqcesjm6cxlkrihb67cr.webp) no-repeat center center;">
        <i class="fa-solid fa-star-and-crescent text-white relative z-50"></i>
      </div>
      <p class="ms-3 font-bold text-sm xl:text-lg">Có thể bạn quan tâm</p>
    </div>
    <div class="flex flex-col ">
      <div class="mt-3 grid gap-2 grid-cols-2 xl:grid-cols-6 whr-product px-1 xl:px-0">
        <?php foreach ($suggestproduct as $product) { ?>
          <a href="<?php echo  BASE_URL . '/product/' . CreateSlug::createSlug($product['product_name']) . '-' . $product['id'] . '' ?>">
            <div class="bg-white flex flex-col hover:shadow-full whr-product-content xl:min-h-[260px]">
              <div class="whr-product-img py-2">
                <img data-src="<?php echo $product['product_image'] ?>" class="w-full h-full lazyload" alt="image">
              </div>
              <div class="px-2 xl:mt-1 pb-3">
                <p class="text-[13px] xl:text-sm flash-sale-product-title px-2 xl:px-0"><?php echo $product['product_name'] ?></p>
                <div class="flex items-start xl:mt-1 flex-col px-2 xl:px-0">
                  <div class="product-price text-[13px] xl:text-sm">
                    <p class="text-orange-500 mr-2"><?php echo number_format($product['price'] - (($product['price'] * $product['discount_price'] / 100)), '0', '.', '.') ?><u class="ms-1">đ</u></p>
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
        <button type="button" class="load-more-product w-[100px] xl:w-full xl:text-sm text-[12px] xl:h-[40px] h-[35px] flex items-center justify-center" data-offset="10">
          <a href="<?php echo BASE_URL ?>/product">Xem thêm</a>
        </button>
      </div>
    </div>
  </div>
  <script>
    window.addEventListener('pageshow', function(event) {
      if (event.persisted) {
        window.location.reload();
      }
    });
  </script>
  <?php include_once VIEW_PATH_USER_LAYOUT . 'footer.php' ?>