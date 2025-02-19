<?php

use Core\Format;

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
                <!-- <label for="cart-checkall" class="relative z-50 " style="width: 16px; height: 17px;">
                  <span class="border border-orange-500 inline-block w-full h-full relative rounded-sm cart-item-checkall z-50">
                    <i class="px-0.5 text-sm fa-solid fa-check text-white absolute top-0 opacity-0 cart-icon-checkall"></i>
                  </span>
                  <input type="checkbox" class="w-full h-full checked:border-orange-500 absolute left-0 bottom-0 top-0 opacity-0" id="cart-checkall" name="checkall">
                </label> -->
                <p class=" text-gray-500 uppercase text-sm ms-3">Tất cả sản phẩm (<?php echo count($products) ?> item)</p>
              </div>
            </div>
            <div class="w-full mt-3 flex flex-col">
              <?php foreach ($products as $product) { ?>
                <div class="flex bg-white px-3 py-2 cart-product-item mb-3 rounded-sm">
                  <div class="border border-orange-500 bg-orange-500 rounded-sm cursor-pointer cart-item-checkbox relative mt-8" style="width: 16px; height: 17px;">
                    <i class="px-0.5 text-sm fa-solid fa-check text-white absolute top-0 cart-icon-checkbox cursor-pointer"></i>
                    <input type="checkbox" class="hidden cart-input-checkbox" name="cart-check-item" checked>
                  </div>
                  <div class="ms-3 align-middle">
                    <a href="<?php echo BASE_URL_NAME . '/product/' . Core\CreateSlug::createSlug($product['name']) . '-' . $product['product_id'] ?>">
                      <img src="<?php echo BASE_URL_NAME ?>/Public/upload/products/<?php echo $product['image'] ?>" alt="img-product" style="width: 70px;height: 80px;">
                    </a>
                  </div>
                  <div class="flex items-start ms-3 text-sm" style="width: 328px;">
                    <p><?php echo $product['name'] ?></p>
                  </div>
                  <div class="flex flex-col ms-6 items-start">
                    <p class="text-orange-400 text-lg">
                      <?php echo $product['discount_price'] != null ? 'đ ' . Format::forMatPrice($product['price'] - ($product['price'] * ($product['discount_price'] / 100))) : 'đ ' . Format::forMatPrice($product['price']) ?>
                    </p>
                    <p class="text-gray-300 text-sm <?php echo $product['discount_price'] != null ? '' : 'hidden' ?>"><s><?php echo 'đ ' . Format::forMatPrice($product['price']) ?></s></p>
                    <form action="<?php echo BASE_URL . '/gio-hang/delete/' . $product['product_id'] . '' ?>" method="post">
                      <button type="submit"><i class="fa-regular fa-trash-can text-gray-400 text-md ps-1 pt-2"></i></button>
                    </form>
                  </div>
                  <div class="flex items-center ms-10 p-3">
                    <div class="dec-quantity flex items-center text-center m-1 bg-gray-100 text-gray-400 cursor-pointer hover:bg-gray-300 hover:text-white" style="width: 32px;height: 32px;">
                      <span class="w-full "><i class="fa-solid fa-minus"></i></span>
                    </div>
                    <div class="p-2" style="width: 44px;">
                      <input type="text" value="<?php echo $product['cart_quantity'] ?>" class="w-full text-center outline-none cart-product-quantity" name="cart-quantity" data-productID="<?php echo $product['product_id'] ?>" checked>
                    </div>
                    <div
                      class="<?php echo $product['fs_quantity'] > 0 ? ($product['fs_quantity'] == $product['cart_quantity'] ? 'pointer-events-none' : '') : ($product['stock'] == $product['cart_quantity'] ? 'pointer-events-none' : '') ?>
                      inc-quantity flex items-center text-center m-1 bg-gray-100 text-gray-400 cursor-pointer hover:bg-gray-300 hover:text-white"
                      style="width: 32px;height: 32px;">
                      <span class="w-full"><i class="fa-solid fa-plus"></i></span>
                    </div>
                  </div>
                </div>
              <?php } ?>
            </div>
          </div>
          <div class="bg-white px-3 py-4 ms-2 flex-1 rounded-md" style="max-height: 250px;">
            <div class="mb-3">
              <p class="text-lg">Order Summary</p>
            </div>
            <div class="flex justify-between text-gray-500 text-sm mb-4">
              <p class="checkout-subtotal">Subtotal</p>
              <p class="mr-2 checkout-subtotal-price text-sm"><span id="cart-subtotal"><?php echo Format::forMatPrice($totalPrice) ?></span> <u>đ</u></p>
            </div>
            <div class="flex justify-between text-gray-500 text-sm mb-4">
              <p class="checkout-subtotal">Saved</p>
              <p class="mr-2 checkout-subtotal-price text-red-400">- <span id="cart-saved"><?php echo Format::forMatPrice($saveprice) ?></span> <u>đ</u></p>
            </div>
            <div class="flex justify-between text-black text-sm">
              <p class="checkout-subtotal">Total</p>
              <p class="mr-2 checkout-subtotal-price text-orange-500 text-lg"> <span id="cart-total"><?php echo Format::forMatPrice($totalPrice - $saveprice) ?></span><u>đ</u></p>
            </div>
            <div class="mt-4 text-center bg-orange-500 text-white py-2 rounded-md" id="cart-checkout">
              <form name="checkout" id="checkout" action="<?php echo BASE_URL . '/checkout' ?>">
                <button type="button" class="cursor-pointer w-full" name="btn-checkout" id="btn-checkout">Checkout</button>
              </form>
            </div>
          </div>
        </div>
      <?php } else { ?>
        <div class="mt-4 bg-white flex flex-col justify-center p-5 items-center ">
          <div class="mb-3">
            <img src="https://cdn0.fahasa.com/skin//frontend/ma_vanese/fahasa/images/checkout_cart/ico_emptycart.svg" alt="no-product-image">
          </div>
          <p class="mb-4 text-sm text-gray-400">Chưa có sản phẩm trong giỏ hàng của bạn</p>
          <div class="mb-3" style="width: 220px;height: 40px;">
            <button type="button" class="bg-red-600 text-white w-full h-full uppercase rounded-md"><a href="<?php echo BASE_URL . '/product' ?>" class="w-full h-full">mua sắm ngay</a></button>
          </div>
        </div>
      <?php } ?>
    <?php } else { ?>
      <div class="flex flex-col justify-center">
        <div class="flex justify-center">
          <img src="./Public/images/icon/cart.png" alt="cart_image">
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
</div>
<?php include_once VIEW_PATH_USER_LAYOUT . 'footer.php' ?>