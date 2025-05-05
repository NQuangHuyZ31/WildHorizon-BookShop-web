<?php

use Helpers\Format;
use Core\Session;
use Helpers\CreateSlug;

Session::delete('error');
include_once VIEW_PATH_USER_LAYOUT . 'header.php'

?>
<div class="container-fuild mx-auto">
  <div class="whr-cart mt-3">
    <!-- -->
    <?php if (\Core\Session::has('user')) { ?>
      <?php if (count($products) > 0) { ?>
        <div class="flex justify-between">
          <div style="width:788px">
            <div class="flex justify-between w-full bg-white px-3 py-2 rounded-sm">
              <div class="flex items-center">
                <p class=" text-gray-500 uppercase text-sm ms-3">Tất cả sản phẩm (<?php echo count($products) ?> sản phẩm)</p>
              </div>
            </div>
            <form id="form-checkout" action="<?php echo BASE_URL . '/checkout/process' ?>" method="post">
              <input type="hidden" name="csrf_token" value="<?php echo $csrf_token ?>">
              <div class="w-full mt-3 flex flex-col">
                <?php foreach ($products as $product) { ?>
                  <div class="flex bg-white px-3 py-2 cart-product-item mb-3 rounded-sm">
                    <div class="border border-orange-500 bg-orange-500 rounded-sm cursor-pointer cart-item-checkbox relative mt-8" style="width: 16px; height: 17px;">
                      <i class="px-0.5 text-sm fa-solid fa-check text-white absolute top-0 cart-icon-checkbox cursor-pointer"></i>
                      <input type="checkbox" class="hidden cart-input-checkbox" name="cart-product-id[]" value="<?php echo $product['id'] ?>" checked>
                    </div>
                    <div class="ms-3 align-middle">
                      <a href="<?php echo BASE_URL . '/product/' . CreateSlug::createSlug($product['product_name']) . '-' . $product['id'] ?>">
                        <img src="<?php echo $product['product_image'] ?>" alt="img-product" style="width: 70px;height: 80px;">
                      </a>
                    </div>
                    <div class="flex items-start ms-3 text-sm" style="width: 328px;">
                      <p><?php echo $product['product_name'] ?></p>
                    </div>
                    <div class="flex flex-col ms-6 items-start" style="width: 100px;">
                      <p class="text-orange-400 text-lg">
                        <?php echo $product['f_quantity'] > 0 ? 'đ ' . Format::forMatPrice($product['price'] - ($product['price'] * ($product['f_discount_price'] / 100)))
                          : 'đ ' . Format::forMatPrice($product['price'] - ($product['price'] * ($product['discount_price'] / 100))) ?>
                      </p>
                      <p class="text-gray-300 text-sm"><s><?php echo 'đ ' . Format::forMatPrice($product['price']) ?></s></p>
                      <button type="button" class="cart-delete-product" data-id="<?php echo $product['id'] ?>">
                        <i class="fa-regular fa-trash-can text-gray-400 text-md ps-1 pt-2"></i>
                      </button>
                    </div>
                    <div class="flex items-center ms-10 p-3 user-select-none">
                      <div class="dec-quantity flex items-center text-center m-1 bg-gray-100 text-gray-400 cursor-pointer hover:bg-gray-300 hover:text-white" style="width: 32px;height: 32px;">
                        <span class="w-full "><i class="fa-solid fa-minus"></i></span>
                      </div>
                      <div class="p-2" style="width: 44px;">
                        <input type="text" value="<?php echo $product['cart_quantity'] ?>" class="w-full text-center outline-none cart-product-quantity" name="cart-quantity[]" data-productID="<?php echo $product['id'] ?>">
                      </div>
                      <div
                        class="<?php echo $product['f_quantity'] > 0 ? ($product['f_quantity'] == $product['cart_quantity'] ? 'pointer-events-none' : '') : ($product['stock'] == $product['cart_quantity'] ? 'pointer-events-none' : '') ?>
                      inc-quantity flex items-center text-center m-1 bg-gray-100 text-gray-400 cursor-pointer hover:bg-gray-300 hover:text-white"
                        style="width: 32px;height: 32px;">
                        <span class="w-full"><i class="fa-solid fa-plus"></i></span>
                      </div>
                    </div>
                  </div>
                <?php } ?>
              </div>
            </form>
          </div>
          <div class="bg-white px-3 py-4 ms-2 flex-1 rounded-md" style="max-height: 250px;">
            <div class="mb-3">
              <p class="text-lg">Tổng tiền đơn hàng</p>
            </div>
            <div class="flex justify-between text-gray-500 text-sm mb-4">
              <p class="checkout-subtotal">Thành tiền</p>
              <p class="mr-2 checkout-subtotal-price text-sm"><span id="cart-subtotal"><?php echo Format::forMatPrice($totalPrice) ?></span> <u>đ</u></p>
            </div>
            <div class="flex justify-between text-gray-500 text-sm mb-4">
              <p class="checkout-subtotal">Giảm giá</p>
              <p class="mr-2 checkout-subtotal-price text-red-400">- <span id="cart-saved"><?php echo Format::forMatPrice($saveprice) ?></span> <u>đ</u></p>
            </div>
            <div class="flex justify-between text-gray-500 text-sm mb-4">
              <p class="checkout-subtotal">Phí vận chuyển (tiêu chuẩn)</p>
              <p class="mr-2 checkout-subtotal-price text-red-400"><span id="fee-shipping">23.000</span> <u>đ</u></p>
            </div>
            <div class="flex justify-between text-black text-sm">
              <p class="checkout-subtotal">Tổng tiền</p>
              <p class="mr-2 checkout-subtotal-price text-orange-500 text-lg"> <span id="cart-total"><?php echo Format::forMatPrice($totalPrice - $saveprice + 23000) ?></span><u>đ</u></p>
            </div>
            <div class="mt-2 text-center bg-orange-500 text-white py-2 rounded-md" id="cart-checkout">
              <button type="button" class="cursor-pointer w-full" name="btn-checkout" id="btn-checkout">Đặt hàng</button>
            </div>
          </div>
        </div>
      <?php } else { ?>
        <div class="mt-4 bg-white flex flex-col justify-center p-5 items-center ">
          <div class="mb-3">
            <img src="https://res.cloudinary.com/whr-clound/image/upload/v1745417547/poqkthizdksp4b1fhhqm.png" alt="no-product-image">
          </div>
          <p class="mb-4 text-sm text-gray-400">Chưa có sản phẩm trong giỏ hàng của bạn</p>
          <div class="mb-3" style="width: 220px;height: 40px;">
            <button type="button" class="bg-red-600 text-white w-full h-full uppercase rounded-md"><a href="<?php echo BASE_URL . '/product' ?>" class="w-full h-full">Mua sắm ngay</a></button>
          </div>
        </div>
      <?php } ?>
    <?php } else { ?>
      <div class="flex flex-col justify-center">
        <div class="flex justify-center">
          <img src="https://res.cloudinary.com/whr-clound/image/upload/v1745417547/poqkthizdksp4b1fhhqm.png" alt="cart_image">
        </div>
        <div class="flex flex-col">
          <div class="text-center mt-3 text-lg text-gray-600">
            <p class="p-1">Bạn chưa đăng nhập.</p>
            <p class="text-sm text-gray-400">Đăng nhập để thêm sản phẩm vào giỏ hàng!</p>
          </div>
          <div class="text-center mt-4">
            <button type="button" class="bg-orange-500 p-2 hover:bg-orange-600 rounded-sm" style="height: 50px;width: 240px;"><a href="<?php echo BASE_URL . '/dang-nhap' ?>" class="text-white text-sm">Sign in/Sign up</a></button>
          </div>
          <div class="text-center mt-6">
            <button type="button" class="p-2 hover:bg-orange-100 rounded-sm border border-orange-400" style="height: 50px;width: 240px;"><a href="<?php echo BASE_URL . '/' ?>" class="text-orange-400 text-sm">Go to Shopping</a></button>
          </div>
        </div>
      </div>
    <?php } ?>
  </div>
  <div class="rounded-md mt-3">
    <p class=" text-lg ps-2 font-bold">Có thể bạn quan tâm</p>
    <div class="grid grid-cols-5 mt-7">
      <?php foreach ($suggestproduct as $product) { ?>
        <a href="<?php echo  '/WildHorizon-BookShop/product/' . CreateSlug::createSlug($product['product_name']) . '-' . $product['id'] . '' ?>" class="mr-3 mb-4">
          <div class="bg-white flex flex-col hover:shadow-md hover:rounded-sm whr-product-content">
            <div class="whr-product-img py-2">
              <img src="<?php echo $product['product_image']; ?>" class="w-full h-full" alt="image">
            </div>
            <div class="px-2 mt-2 pb-3">
              <p class="product-title text-sm"><?php echo $product['product_name'] ?></p>
              <div class="flex items-start mt-2 flex-col">
                <div class="product-price">
                  <p class="text-orange-500 mr-2"><?php echo number_format($product['price'] - (($product['price'] * $product['discount_price'] / 100)), '0', '.', '.') ?><u class="ms-1">đ</u></p>
                  <p class="text-sm" style="font-size: 12px;"></p>
                </div>
                <?php if (isset($product['discount_price']) && $product['discount_price'] > 0) { ?>
                  <div class="product-price-sale">
                    <p class="flash-sale-product-price-sale"><s class="opacity-50">đ<?php echo number_format($product['price'], 0, '.', ',') ?></s>
                      <span class="text-white ms-2 bg-red-600 rounded-sm px-1 text-center">-<?php echo number_format($product['discount_price'], 0) . '%' ?></span>
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
      <button type="button" id="loadMore-product" class="load-more-product"><a href="<?php echo BASE_URL . '/product' ?>">Xem thêm</a></button>
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