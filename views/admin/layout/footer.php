<!-- footer.php -->
<div class="bg-gray-800 text-white text-center py-4 mt-auto">
    <p>&copy; 2025 Admin Panel. All Rights Reserved.</p>
</div>

<script src="<?= BASE_URL ?>/Public/js/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/js-loading-overlay@1.1.0/dist/js-loading-overlay.min.js"></script>
<script src="<?php echo BASE_URL ?>/Public/js/lity.min.js?v=<?php echo rand() ?>" async=""></script>
<script>
    toastr.options = {
        "closeButton": true,
        "debug": false,
        "newestOnTop": false,
        "progressBar": false,
        "positionClass": "toast-top-right",
        "preventDuplicates": false,
        "showDuration": "300",
        "hideDuration": "1000",
        "timeOut": "3000",
        "extendedTimeOut": "1000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
    };
    // Config Loading Overplay
    JsLoadingOverlay.setOptions({
        overlayBackgroundColor: '#FFFFFF',
        overlayOpacity: '0.7',
        spinnerIcon: 'ball-clip-rotate-multiple',
        spinnerColor: '#DE812F',
        spinnerSize: '1x',
        overlayIDName: 'overlay',
        spinnerIDName: 'spinner',
        offsetX: 0,
        offsetY: 0,
        containerID: null,
        lockScroll: false,
        overlayZIndex: 9998,
        spinnerZIndex: 9999,
    });
</script>