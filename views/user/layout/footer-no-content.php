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
$success = \Core\Session::get('success');
$status = is_array($success) && isset($success['status']) ? $success['status'] : '';
$msg = is_array($success) && isset($success['msg']) ? $success['msg'] : '';
\Core\Session::delete('success'); // Xóa flash sau khi dùng
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