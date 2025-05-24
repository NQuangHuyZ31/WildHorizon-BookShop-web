// Config
window.APP_CONFIG = {
    appURL: '/WildHorizon-BookShop',
};

// config toastr
document.addEventListener('DOMContentLoaded', function () {
    const swiper = new Swiper('.swiperFlashsale', {
        loop: true,
        spaceBetween: 20,
        breakpoints: {
            320: {
                slidesPerView: 2.2, // Mobile nhỏ
            },
            480: {
                slidesPerView: 3,
            },
            768: {
                slidesPerView: 4,
            },
            1024: {
                slidesPerView: 6, // Desktop
            },
            1280: {
                slidesPerView: 6,
            },
            1536: {
                slidesPerView: 6,
            },
        },
        // navigation: {
        //   nextEl: '.swiper-button-next',
        //   prevEl: '.swiper-button-prev',
        // },
    });

    // Swiper 2 - Banner (ví dụ khác)
    const swiperBanner = new Swiper('.outstanding_product', {
        loop: false,
        spaceBetween: 20,
        breakpoints: {
            320: {
                slidesPerView: 2.2, // Mobile nhỏ
            },
            480: {
                slidesPerView: 3,
            },
            768: {
                slidesPerView: 4,
            },
            1024: {
                slidesPerView: 6, // Desktop
            },
            1280: {
                slidesPerView: 6,
            },
            1536: {
                slidesPerView: 6,
            },
        },
    });

    // Config toastr
    toastr.options = {
        closeButton: false,
        debug: false,
        newestOnTop: false,
        progressBar: false,
        positionClass: 'toast-top-right',
        preventDuplicates: false,
        onclick: null,
        showDuration: '2000',
        hideDuration: '2000',
        timeOut: '2000',
        extendedTimeOut: '2000',
        showEasing: 'swing',
        hideEasing: 'linear',
        showMethod: 'fadeIn',
        hideMethod: 'fadeOut',
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
});

// Hàm main hanle logic
$(document).ready(function () {
    const baseURL = APP_CONFIG.appURL;
    let URL_GETMORE_PRODUCT_HOMEPAGE = baseURL + '/homepage/product/loadmore';
    let URL_GETMORE_FS_PRODUCT_HOMEPAGE = baseURL + '/loadmorefs';
    let URL_FEEDBACK = baseURL + '/feedback';
    let URL_RESEND_VERIFY_ACCOUNT = baseURL + '/dang-ky/verify-account/resend';
    let URL_SAVE_VOUCHER = baseURL + '/voucher/save';

    // Ẩn banner top
    $('#banner-top-ee').click(function () {
        $('.banner-top').addClass('hidden');
    });

    // Setup slideshow
    $('.single-item').slick({
        arrows: true,
        autoplay: true,
        autoplaySpeed: 5000,
        // fade: true,
    });

    // ------------------------------------------------------------LOGIN------------------------------------------------------
    // ------------------------------------------------SHOW, HIDE PASSWORD
    $('.whr-show-pw-icon').click(function (e) {
        e.preventDefault();
        $('#whr-login-password').attr('type', 'text');
        $(this).addClass('hidden');
        $('.whr-hidden-pw-icon').removeClass('hidden');
    });

    $('.whr-hidden-pw-icon').click(function (e) {
        e.preventDefault();
        $('#whr-login-password').attr('type', 'password');
        $(this).addClass('hidden');
        $('.whr-show-pw-icon').removeClass('hidden');
    });

    // --------------------------------------------SHOW HIDE CONFIRM PASSWORD
    $('.whr-show-cfpw-icon').click(function (e) {
        e.preventDefault();
        $('#whr-login-cfpassword').attr('type', 'text');
        $(this).addClass('hidden');
        $('.whr-hidden-cfpw-icon').removeClass('hidden');
    });

    $('.whr-hidden-cfpw-icon').click(function (e) {
        e.preventDefault();
        $('#whr-login-cfpassword').attr('type', 'password');
        $(this).addClass('hidden');
        $('.whr-show-cfpw-icon').removeClass('hidden');
    });

    // ===========================================================
    $('#btn-signup').click(function () {
        JsLoadingOverlay.show();

        setTimeout(() => {
            $('#form-signup').submit();
        }, 500);

        setTimeout(() => {
            JsLoadingOverlay.hide();
        }, 3000);
    });

    // ================================================
    $('#btn-verify-account').click(function (e) {
        e.preventDefault();
        JsLoadingOverlay.show();
        setTimeout(() => {
            $('#form-verify-account').submit();
        }, 500);
    });

    // Resend Verify account
    $('#btn-resend-verify-account').click(function (e) {
        e.preventDefault();

        JsLoadingOverlay.show();
        $(this).attr('disabled', true);

        const csrf_token = $('input[name="csrf_token"]').val();

        setTimeout(() => {
            $.ajax({
                type: 'POST',
                url: URL_RESEND_VERIFY_ACCOUNT,
                data: {
                    csrf_token,
                },
                dataType: 'json',
                success: function (response) {
                    if (response) {
                        JsLoadingOverlay.hide();
                        toastr['success'](response.success.msg);
                        $('input[name="csrf_token"]').val(response.token);
                        setTimeout(() => {
                            $(this).attr('disabled', false);
                        }, 5000);
                    }
                },
                error: function (response) {
                    if (response) {
                        JsLoadingOverlay.hide();
                        toastr['error'](response.responseJson.error.msg);
                        $('input[name="csrf_token"]').val(response.responseJson.token);
                        setTimeout(() => {
                            $(this).attr('disabled', false);
                        }, 5000);
                    }
                },
            });
        }, 500);
    });

    // ------------------------------------------------------CHANGE BORDER FEEDBACK TEXTAREA
    $('.whr-feedback-textarea-content').focus(function () {
        $('.whr-feedback-textarea').addClass('border-blue-400');
        $('.whr-feedback-textarea').removeClass('border-gray-400');
    });

    $('.whr-feedback-textarea-content').blur(function () {
        $('.whr-feedback-textarea').addClass('border-gray-400');
        $('.whr-feedback-textarea').removeClass('border-blue-400');
    });

    // ------------------------------------------------------ACCEPT SEND FEEDBACK
    $('#feedback-content').on('input', function () {
        var value = $(this).val();
        if (value.length > 0) {
            $('#btn-feedback').removeClass('pointer-events-none opacity-25');
            $('#feedback-count').text(value.length + '/1000');
        } else {
            $('#btn-feedback').addClass('pointer-events-none opacity-25');
        }
    });

    // ----------------------------------------------------LOADMORE PRODUCT HOMEPAGE
    $('#homepage-loadMore-product').click(() => {
        var offset = $('#homepage-loadMore-product').data('offset');
        $.ajax({
            type: 'GET',
            url: URL_GETMORE_PRODUCT_HOMEPAGE,
            data: {
                offset: offset,
            },
            dataType: 'json',
            success: function (response) {
                if (response.data.length > 0) {
                    response.data.forEach((product) => {
                        $('.whr-product').append(`
                        <a href="${response.url}/product/${createSlug(product.product_name)}-${product.id}">
                        <div class="bg-white flex flex-col hover:shadow-full whr-product-content xl:min-h-[260px]">
                            <div class="whr-product-img py-2">
                            <img data-src="${product.product_image}" class="w-full h-full lazyload" alt="image">
                            </div>
                            <div class="px-2 xl:mt-1 pb-3">
                            <p class="text-[13px] xl:text-sm flash-sale-product-title px-2 xl:px-0">${product.product_name}</p>
                            <div class="product-price text-[13px] xl:text-sm xl:px-0 px-2">
                                <p class="text-orange-500">
                                ${
                                    product.f_discount_price > 0
                                        ? new Intl.NumberFormat('vi').format(product.price - (product.price * product.f_discount_price) / 100)
                                        : new Intl.NumberFormat('vi').format(product.price - (product.price * product.discount_price) / 100)
                                }
                                <u class="text-orange-500 ms-1">đ</u>
                                </p>
                                <div class="flex justify-between items-center">
                                <p class="flash-sale-product-price-sale ${
                                    product.discount_price > 0 || product.f_discount_pice > 0 ? '' : 'hidden'
                                } "><s class="opacity-50">đ${new Intl.NumberFormat('vi').format(product.price)}</s>
                                    <span class="text-white ms-2 bg-red-600 rounded-sm px-1 text-[9px] xl:text-[11px]">-${
                                        product.f_discount_price > 0
                                            ? new Intl.NumberFormat('vi').format(product.f_discount_price)
                                            : new Intl.NumberFormat('vi').format(product.discount_price)
                                    }%</span>
                                </p>
                                </div>
                            </div>
                            </div>
                        </div>
                        </a>
                        `);
                    });
                } else {
                    $('#homepage-loadMore-product').addClass('poiter-events-none opacity-50');
                }
                var newOfset = offset + parseInt(response.offset);
                $('#homepage-loadMore-product').data('offset', newOfset);
            },
        });
    });

    // ---------------------------------------------------------LOADMORE FLASHSALES PRODUCT
    $('#loadmore-product-fs').click(() => {
        var offset = $('#loadmore-product-fs').data('offset');
        $.ajax({
            type: 'GET',
            url: URL_GETMORE_FS_PRODUCT_HOMEPAGE,
            data: {
                offset: offset,
            },
            dataType: 'json',
            success: function (response) {
                // console.log(response);
                if (response.data.length > 0) {
                    response.data.forEach((product) => {
                        $('.whr-product-flash-sale').append(`
                            <a href="${response.url}/product/${createSlug(product.product_name)}-${product.product_id}" class="bg-white mb-3">
                            <div class="flex flex-col ">
                            <div class="whr-product-img py-2 h-[130px] xl:h-[180px]">
                                <img src="${product.product_image}" class="w-full h-full" alt="sanpham">
                            </div>
                            <div class="flash-sale-product mt-1 mx-2">
                                <p class="text-[13px] xl:text-sm flash-sale-product-titl">${product.product_name}</p>
                                <div class="flash-sale-product-price text-[13px] xl:text-sm">
                                <p class="text-orange-500">${new Intl.NumberFormat('vi').format(
                                    product.price - (product.price * product.discount_price) / 100
                                )}<u class="text-orange-500 ms-1">đ</u></p>
                                <p class="flash-sale-product-price-sale"><s class="opacity-50">đ${new Intl.NumberFormat('vi').format(product.price)}</s>
                                <span class="text-white ms-2 bg-red-600 rounded-sm px-1 text-[9px] xl:text-[11px]">-${new Intl.NumberFormat('vi').format(product.discount_price)}%</span></p>
                                </div>
                            </div>
                            </div>
                            <div class="flex justify-end px-1">
                            <p class="text-gray-400 text-[9px] xl:text-[11px]">còn ${product.quantity} sản phẩm</p>
                            </div>
                            <div class="flex" style="height: 16px;"></div>
                        </a>`);
                    });
                } else {
                    $('#loadmore-product-fs').addClass('poiter-events-none opacity-50');
                }
                var newOfset = offset + 10;
                $('#loadmore-product-fs').data('offset', newOfset);
            },
        });
    });

    // FEEDBACK
    // show images feebback
    $('#feedback-input').change(function (e) {
        e.preventDefault();
        $('#previewBox').empty(); // Xóa ảnh cũ nếu có

        const files = this.files;
        if (files.length > 0) {
            $.each(files, function (index, file) {
                if (file.type.startsWith('image/')) {
                    const reader = new FileReader();
                    reader.onload = function (e) {
                        const img = $('<img>', {
                            src: e.target.result,
                            css: {
                                width: '100px',
                                height: '100px',
                                objectFit: 'cover',
                                border: '1px solid #ccc',
                                borderRadius: '8px',
                            },
                        });
                        $('#previewBox').append(img);
                    };
                    reader.readAsDataURL(file);
                }
            });
        }
    });

    // Upload
    $('#btn-feedback').click(function (e) {
        JsLoadingOverlay.show();
    });

    // Save voucher
    $('.btn-save-voucher').click(function (e) {
        e.preventDefault();
        JsLoadingOverlay.show();

        const btn = $(this);

        btn.attr('disabled', true);
        setTimeout(() => {
            btn.attr('disabled', false);
        }, 3000);

        const voucherID = btn.data('id');

        setTimeout(() => {
            $.ajax({
                type: 'post',
                url: URL_SAVE_VOUCHER,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content'),
                },
                data: {
                    voucherID,
                },
                dataType: 'json',
                success: function (response) {
                    if (response) {
                        JsLoadingOverlay.hide();
                        $('meta[name="csrf_token"]').attr('content', response.token);
                        toastr['success'](response.success.msg);
                        btn.text(response.success.title);
                        btn.removeClass('bg-blue-500 btn-save-voucher').addClass('bg-gray-300 pointer-events-none');
                    }
                },
                error: function (response) {
                    if (response) {
                        $('meta[name="csrf_token"]').attr('content', response.responseJSON.token);
                        if (response.status == 401) {
                            window.location.href = response.responseJSON.login_url;
                        } else {
                            JsLoadingOverlay.hide();
                            toastr['error'](response.responseJSON.error.msg);
                        }
                    }
                },
            });
        }, 500);
    });
    // ------------CREATE SLUG-----------------------------------
    function createSlug(title) {
        return title
            .toLowerCase() // Chuyển thành chữ thường
            .normalize('NFD') // Tách dấu khỏi chữ cái có dấu
            .replace(/[\u0300-\u036f]/g, '') // Xóa dấu
            .replace(/đ/g, 'd') // Chuyển "đ" thành "d"
            .replace(/[^a-z0-9 -]/g, '') // Xóa ký tự đặc biệt
            .replace(/\s+/g, '-') // Thay khoảng trắng bằng dấu "-"
            .replace(/-+/g, '-') // Loại bỏ dấu "-" liên tiếp
            .trim(); // Xóa khoảng trắng đầu cuối
    }
});
