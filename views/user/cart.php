<?php include_once('layout/header.php') ?>
<div class="container-fuild mx-auto">
  <div class="whr-cart mt-3">
    <div class="flex justify-between">
      <div style="width:788px">
        <div class="flex justify-between w-full bg-white px-3 py-2">
          <div class="flex items-center">
            <label for="cart-checkall" class="relative cart-item-checkbox z-50" style="width: 16px; height: 17px;">
              <span class="border border-orange-500 inline-block w-full h-full relative rounded-sm cursor-pointer"><i class="px-0.5 text-sm fa-solid fa-check text-white absolute top-0 opacity-0"></i></span>
              <input type="checkbox" class="w-full h-full checked:border-orange-500 absolute left-0 bottom-0 top-0 opacity-0" id="cart-checkall" name="checkall" aria-checked="flase" checked>
            </label>
            <p class=" text-gray-500 uppercase text-sm ms-3">SELECT ALL (5 ITEMS)</p>
          </div>
          <form action="" method="post">
            <input type="hidden" name="csrf_token" value="<?php echo $csrf_token ?>">
            <button class="flex items-center text-gray-500 hover:text-orange-300">
              <i class="fa-regular fa-trash-can"></i>
              <p class="uppercase text-sm ms-2">delete</p>
            </button>
          </form>
        </div>
        <div class="w-full mt-3">
          <div class="flex bg-white px-3 py-2 cart-product-item">
            <label for="" class="relative cart-item-checkbox z-50 mt-7" style="width: 16px; height: 17px;">
              <span class="border border-orange-500 inline-block w-full h-full relative rounded-sm cursor-pointer"><i class="px-0.5 text-sm fa-solid fa-check text-white absolute top-0 opacity-0"></i></span>
              <input type="checkbox" class="w-full h-full checked:border-orange-500 absolute left-0 bottom-0 top-0 opacity-0 cart-product-checkbox" name="cart-check-item" aria-checked="false" checked>
            </label>
            <div class="ms-3 align-middle">
              <a href=""><img src="./Public/images/Probi.avif" alt="img-product" style="width: 80px;height: 80px;"></a>
            </div>
            <div class="flex items-start ms-3 text-sm" style="width: 328px;">
              <p>Bộ 3 hộp Bông tẩy trang cao cấp Silcot Premium 66 miếng/hộp - TUSC00002CB</p>
            </div>
            <div class="flex flex-col ms-6 items-start">
              <p class="text-orange-400 text-lg">đ 98,000</p>
              <p class="text-gray-300 text-sm"><s>đ 139,800</s></p>
              <form action=""><button type="submit"><i class="fa-regular fa-trash-can text-gray-400 text-md ps-1 pt-2"></i></button></form>
            </div>
            <div class="flex items-center ms-10 p-3">
              <div class="dec-quantity flex items-center text-center m-1 bg-gray-100 text-gray-400 cursor-pointer hover:bg-gray-300 hover:text-white" style="width: 32px;height: 32px;">
                <span class="w-full "><i class="fa-solid fa-minus"></i></span>
              </div>
              <div class="p-2" style="width: 44px;">
                <input type="text" value="1" class="w-full text-center outline-none cart-product-quantity" name="cart-quantity">
              </div>
              <div class="inc-quantity flex items-center text-center m-1 bg-gray-100 text-gray-400 cursor-pointer hover:bg-gray-300 hover:text-white" style="width: 32px;height: 32px;">
                <span class="w-full"><i class="fa-solid fa-plus"></i></span>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="bg-white p-2 ms-2 flex-1">
        <div class="ps-1"> 
          <p class="text-lg">Order Summary</p>
        </div>
      </div>
    </div>
  </div>
</div>
<?php include_once('layout/footer.php') ?>