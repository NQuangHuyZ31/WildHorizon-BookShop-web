<footer class="mx-auto container-fuild">
  <div class="border-t-2 border-gray-200">
    <?php

    use Core\Session;

    if (isset($homePage) && $banner_footers != null) { ?>
      <div class="flex">
        <div class="grid grid-cols-3 px-2 py-4">
          <?php foreach ($banner_footers as $banner) { ?>
            <div class="me-2">
              <img src="<?php echo $banner['image'] ?>" alt="banner1">
            </div>
          <?php } ?>
        </div>
      </div>
    <?php } ?>
    <div class="grid grid-cols-1 py-5 px-3 lg:grid-cols-4">
      <div class="flex flex-col">
        <h1 class="text-[13px] lg:text-[15px] text-sky-400">Liên hệ với chúng tôi</h1>
        <div class="mt-1">
          <ul class="list-none text-[11px] lg:text-[13px] ps-2 text-red-950">
            <li><a href="#" class="hover:underline">Đường dây nóng & Trò chuyện trực tuyến</a></li>
            <li><a href="#" class="hover:underline">Trung tâm trợ giúp</a></li>
            <li><a href="#" class="hover:underline">Cách mua sản phẩm</a></li>
            <li><a href="#" class="hover:underline">Vận chuyển & Giao hàng</a></li>
            <li><a href="#" class="hover:underline">Chính sách sản phẩm quốc tế</a></li>
          </ul>
        </div>
      </div>
      <div class="flex flex-col">
        <h1 class="text-[13px] lg:text-[15px] text-sky-400">WildHorizon BookShop</h1>
        <div class="mt-1">
          <ul class="list-none text-[11px] lg:text-[13px] ps-2 text-red-950">
            <li><a href="#" class="hover:underline">Về chúng tôi</a></li>
            <li><a href="#" class="hover:underline">Điều khoản & Điều kiện</a></li>
            <li><a href="#" class="hover:underline">Chính sách bảo mật</a></li>
            <li><a href="#" class="hover:underline">Bảo vệ sở hữu trí tuệ</a></li>
            <li><a href="#" class="hover:underline">Quy định hoạt động</a></li>
          </ul>
        </div>
      </div>
      <div class="flex flex-col">
        <h1 class="text-[13px] lg:text-[15px] text-sky-400">Địa chỉ</h1>
        <div class="mt-1">
          <ul class="list-none text-[11px] lg:text-[13px] ps-2 text-red-950">
            <li><a href="#" class="hover:underline">Địa chỉ: 123 NVB, Gò Vấp</a></li>
            <li><a href="#" class="hover:underline">Email: quanghuy123@gmail.com</a></li>
            <li><a href="#" class="hover:underline">Sđt: 0908762316</a></li>
            <li><a href="#" class="hover:underline">Fax: 46790-5678-5678</a></li>
          </ul>
        </div>
      </div>
      <div>
        <div class="flex flex-nwrap mt-3 w-[250px] lg:w-full" style="max-width: 290px;">
          <!-- <h1 class="text-lg">Address</h1> -->
          <div class="px-1 py-2 me-1"><img src="https://res.cloudinary.com/whr-clound/image/upload/v1746262297/gpykjvrri1urreezgu5b.png" alt=""></div>
          <div class="px-1 py-2 me-1"><img src="https://res.cloudinary.com/whr-clound/image/upload/v1746262296/jayddy3a1hmqtkbyjyji.png" alt=""></div>
          <div class="px-1 py-2 me-1"><img src="https://res.cloudinary.com/whr-clound/image/upload/v1746262295/ut61h8vhqfjemgmevxbw.png" alt=""></div>
        </div>
      </div>
    </div>
  </div>
</footer>
</div>
<div class="bg-white flex">
  <div class="container-fuild mx-auto">
    <div class="lg:grid-cols-2">
      <div class="w-full">
        <h1 class="text-[14px] lg:text-lg px-2 py-2 font-bold">Payment Methods</h1>
        <div class="flex flex-wrap">
          <img src="https://res.cloudinary.com/whr-clound/image/upload/v1746262300/hhnu7934rfekk67nnhee.png" alt="payment method" class="px-3 me-3 py-2" style="height: 60px; width: 80px;">
          <img src="https://res.cloudinary.com/whr-clound/image/upload/v1746262299/wdbqerws4it4n2qxzvsk.png" alt="payment method" class="px-3 me-3 py-2" style="height: 60px; width: 80px;">
          <img src="https://res.cloudinary.com/whr-clound/image/upload/v1746262295/ywpkqhmdriwpshdtzikq.png" alt="payment method" class="px-3 me-3 py-2" style="height: 60px; width: 80px;">
          <img src="https://res.cloudinary.com/whr-clound/image/upload/v1746262294/dpflumu5t9o52myclrtw.png" alt="payment method" class="px-3 me-3 py-2" style="height: 60px; width: 80px;">
          <img src="https://res.cloudinary.com/whr-clound/image/upload/v1746262293/inomznpdmp8cfvjcyvdh.png" alt="payment method" class="px-3 me-3 py-2" style="height: 60px; width: 80px;">
          <img src="https://res.cloudinary.com/whr-clound/image/upload/v1746262293/uxf5jomf4hbmx95jtsrl.png" alt="payment method" class="px-3 me-3 py-2" style="height: 60px; width: 80px;">
          <img src="https://res.cloudinary.com/whr-clound/image/upload/v1746262625/rui3zw9prsfi5bttckib.png" alt="payment method" class="px-3 me-3 py-2" style="height: 60px; width: 80px;">

        </div>
      </div>
      <div class="w-full">
        <h1 class="text-[14px] lg:text-lg px-2 py-2 font-bold">Delivery Services</h1>
        <div class="flex flex-wrap">
          <img src="https://res.cloudinary.com/whr-clound/image/upload/v1746262293/xs2thvgu6fhstn5lca0z.png" alt="payment method" class="px-3 me-3 py-2" style="height: 60px; width: 80px;">
          <img src="https://res.cloudinary.com/whr-clound/image/upload/v1746262623/forjgbiaxzfnpkj0vkfl.png" alt="payment method" class="px-3 me-3 py-2" style="height: 60px; width: 80px;">
          <img src="https://res.cloudinary.com/whr-clound/image/upload/v1746262622/ihrp53voxcf88dabze2u.png" alt="payment method" class="px-3 me-3 py-2" style="height: 60px; width: 80px;">
          <img src="https://res.cloudinary.com/whr-clound/image/upload/v1746262622/hbhf9x1rruqyhw7oo8qk.png" alt="payment method" class="px-3 me-3 py-2" style="height: 60px; width: 80px;">
          <img src="https://res.cloudinary.com/whr-clound/image/upload/v1746262622/bcpmpmlnrdosjxw5igs6.png" alt="payment method" class="px-3 me-3 py-2" style="height: 60px; width: 80px;">
          <img src="https://res.cloudinary.com/whr-clound/image/upload/v1746262622/qtp5xxdymasvmeazzwyk.png" alt="payment method" class="px-3 me-3 py-2" style="height: 60px; width: 80px;">
        </div>
      </div>
    </div>
  </div>
</div>

<script src="https://kit.fontawesome.com/3991b54e5c.js" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick.min.js" integrity="sha512-HGOnQO9+SP1V92SrtZfjqxxtLmVzqZpjFFekvzZVWoiASSQgSr4cw9Kqd2+l8Llp4Gm0G8GIFJ4ddwZilcdb8A==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdn.jsdelivr.net/npm/js-loading-overlay@1.1.0/dist/js-loading-overlay.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<script src="<?php echo BASE_URL ?>/Public/js/app.js?v=<?php echo rand() ?>"></script>
<script src="<?php echo BASE_URL ?>/Public/js/cart.js?v=<?php echo rand() ?>"></script>
<script src="<?php echo BASE_URL ?>/Public/js/product-detail.js?v=<?php echo rand() ?>"></script>
<script src="<?php echo BASE_URL ?>/Public/js/checkout.js?v=<?php echo rand() ?>"></script>
<script src="<?php echo BASE_URL ?>/Public/js/product.js?v=<?php echo rand() ?>"></script>
<script src="<?php echo BASE_URL ?>/Public/js/account.js?v=<?php echo rand() ?>"></script>
<script src="<?php echo BASE_URL ?>/Public/js/lazysizes.min.js?v=<?php echo rand() ?>" async=""></script>
<script src="<?php echo BASE_URL ?>/Public/js/lity.min.js?v=<?php echo rand() ?>" async=""></script>
<?php
$success = Session::get('success');
$status = is_array($success) && isset($success['status']) ? $success['status'] : '';
$msg = is_array($success) && isset($success['msg']) ? $success['msg'] : '';
Session::delete('success'); // Xóa flash sau khi dùng
?>

<!-- Config notify -->
<script>
  const status = "<?= addslashes($status) ?>";
  const msg = "<?= addslashes($msg) ?>";
  toastr.options = {
    "closeButton": true,
    "positionClass": "toast-bottom-right",
    "onclick": null,
    "showDuration": "300",
    "hideDuration": "500",
    "timeOut": "2000",
    // "extendedTimeOut": "1000",
    "showEasing": "swing",
    "hideEasing": "linear",
    "showMethod": "fadeIn",
    "hideMethod": "fadeOut"
  }
  if (status != "" && status == 1) {
    toastr["success"](msg)
  }

  if (status != "" && status == 0) {
    toastr["error"](msg)
  }
</script>
</body>

</html>