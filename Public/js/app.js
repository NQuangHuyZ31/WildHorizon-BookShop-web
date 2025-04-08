// config toastr
document.addEventListener("DOMContentLoaded", function () {
  toastr.options = {
    "closeButton": false,
    "debug": false,
    "newestOnTop": false,
    "progressBar": false,
    "positionClass": "toast-top-right",
    "preventDuplicates": false,
    "onclick": null,
    "showDuration": "1500",
    "hideDuration": "1500",
    "timeOut": "1500",
    "extendedTimeOut": "1500",
    "showEasing": "swing",
    "hideEasing": "linear",
    "showMethod": "fadeIn",
    "hideMethod": "fadeOut"
  };
});

// Hàm main hanle logic
$(document).ready(function () {

  let URL_GETMORE_PRODUCT_HOMEPAGE = '/WildHorizon-BookShop/product/loadmore';
  let URL_GETMORE_FS_PRODUCT_HOMEPAGE ='/WildHorizon-BookShop/loadmorefs';


  // Ẩn banner top
  $('#banner-top-ee').click(function () {

    $('.banner-top').addClass('hidden');
  })

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

  // -------------------------------------------------------CLOSE MODAL HOME PAGE
  // $('#btn-close-modal').click(function () {
  //   $('#my_modal_1').removeClass('modal-open');
  // })

  // ------------------------------------------------------CHANGE BORDER FEEDBACK TEXTAREA
  $('.whr-feedback-textarea-content').focus(function () {
    $('.whr-feedback-textarea').addClass('border-blue-400');
    $('.whr-feedback-textarea').removeClass('border-gray-400');
  })

  $('.whr-feedback-textarea-content').blur(function () {
    $('.whr-feedback-textarea').addClass('border-gray-400');
    $('.whr-feedback-textarea').removeClass('border-blue-400');
  })

  // ------------------------------------------------------ACCEPT SEND FEEDBACK
  $('#feedback-content').on('input', function () {
    var value = $(this).val();
    if (value.length > 0) {
      $('#btn-feedback').removeClass('pointer-events-none opacity-25');
      $('#feedback-count').text(value.length + '/1000');
    } else {
      $('#btn-feedback').addClass('pointer-events-none opacity-25');
    }
  })

  // ----------------------------------------------------LOADMORE PRODUCT HOMEPAGE
  $('#loadMore-product').click(() => {

    var offset = $('#loadMore-product').data('offset');
    var event = $('#loadMore-product').data('event');
    var dataLoad = $('#loadMore-product').data('load');
    console.log(event);
    $.ajax({
      type: "GET",
      url: URL_GETMORE_PRODUCT_HOMEPAGE,
      data: {
        offset: offset,
        event: event,
        dataLoad: dataLoad,
      },
      dataType: "json",
      success: function (response) {
        if (response.products.length > 0) {
          response.products.forEach(product => {
            $('.whr-product').append(`
             <a href="${response.url}/product/${createSlug(product.product_name)}-${product.id}" class="mr-3 mb-4">
              <div class="bg-white flex flex-col hover:shadow-md hover:rounded-sm whr-product-content">
                <div class="whr-product-img py-2">
                  <img src="${response.url}/Public/upload/products/${product.product_image}" class="w-full h-full" alt="image">
                </div>
                <div class="px-2 mt-2">
                  <p class="product-title text-sm">${product.product_name}</p>
                  <div class="product-price-sale">
                    <p class="text-orange-500">
                      ${product.f_discount_pice > 0 ? new Intl.NumberFormat('vi').format(product.price - (product.price * product.f_discount_pice / 100)) : new Intl.NumberFormat('vi').format(product.price - (product.price * product.discount_price / 100))}
                      <u class="text-orange-500 ms-1">đ</u>
                    </p>
                    <div class="flex justify-between items-center">
                      <p class="flash-sale-product-price-sale ${product.discount_price > 0 || product.f_discount_pice > 0 ? '' : 'hidden'} "><s class="opacity-50">đ${new Intl.NumberFormat('vi').format(product.price)}</s>
                        <span class="text-white ms-2 bg-red-600 rounded-sm px-1">-${product.f_discount_pice > 0 ? new Intl.NumberFormat('vi').format(product.f_discount_pice) : new Intl.NumberFormat('vi').format(product.discount_price)}%</span>
                      </p>
                      <img src="${response.url}/Public/images/icon/label-flashsale.svg" alt="icon_fs" width="70" height="40" class="mr-2 ${response.join_fs == 1 && product.f_quantity > 0 ? '' : 'hidden'}">
                    </div>
                  </div>
                    <div class="flex justify-end px-1 ${response.join_fs == 1 && product.f_quantity > 0 ? '' : 'hidden'}">
                      <p class="text-gray-400" style="font-size: 11px;">còn ${product.f_quantity} sản phẩm</p>
                    </div>
                </div>
              </div>
            </a>
            `);
          });
        } else {
          $('#loadMore-product').addClass('poiter-events-none opacity-50');
        }
        var newOfset = offset + parseInt(response.offset);
        $('#loadMore-product').data('offset', newOfset);
      }
    });
  })

  // ---------------------------------------------------------LOADMORE FLASHSALES PRODUCT
  $('#loadmore-product-fs').click(() => {

    var offset = $('#loadmore-product-fs').data('offset');
    $.ajax({
      type: "GET",
      url: URL_GETMORE_FS_PRODUCT_HOMEPAGE,
      data: {
        offset: offset,
      },
      dataType: "json",
      success: function (response) {
        // console.log(response);
        if (response.products.length > 0) {
          response.products.forEach(product => {
            $('.whr-product-flash-sale').append(`
              <a href="/WildHorizon-BookShop/product/${createSlug(product.product_name)}-${product.product_id}" class="mr-2 bg-white mb-3">
            <div class="flex flex-col ">
              <div class="whr-product-img py-2">
                <img src="./Public/upload/products/${product.product_image}" class="w-full h-full" alt="sanpham">
              </div>
              <div class="flash-sale-product mt-1 mx-2">
                <p class="text-sm flash-sale-product-title">${product.product_name}</p>
                <div class="product-price-sale">
                  <p class="text-orange-500">${new Intl.NumberFormat('vi').format(product.price - (product.price * product.discount_price / 100))}<u class="text-orange-500 ms-1">đ</u></p>
                  <p class="flash-sale-product-price-sale"><s class="opacity-50">đ${new Intl.NumberFormat('vi').format(product.price)}</s>
                  <span class="text-white ms-2 bg-red-600 rounded-sm px-1">-${new Intl.NumberFormat('vi').format(product.discount_price)}%</span></p>
                </div>
              </div>
            </div>
            <div class="flex justify-end px-1">
              <p class="text-gray-400" style="font-size: 11px;">còn ${product.quantity} sản phẩm</p>
            </div>
            <div class="flex" style="height: 16px;"></div>
          </a>`);
          });
        } else {
          $('#loadmore-product-fs').addClass('poiter-events-none opacity-50');
        }
        var newOfset = offset + 10;
        $('#loadmore-product-fs').data('offset', newOfset);
      }
    });
  })

  // ------------CREATE SLUG-----------------------------------
  function createSlug(title) {
    return title
      .toLowerCase() // Chuyển thành chữ thường
      .normalize("NFD") // Tách dấu khỏi chữ cái có dấu
      .replace(/[\u0300-\u036f]/g, "") // Xóa dấu
      .replace(/đ/g, "d") // Chuyển "đ" thành "d"
      .replace(/[^a-z0-9 -]/g, "") // Xóa ký tự đặc biệt
      .replace(/\s+/g, "-") // Thay khoảng trắng bằng dấu "-"
      .replace(/-+/g, "-") // Loại bỏ dấu "-" liên tiếp
      .trim(); // Xóa khoảng trắng đầu cuối
  }
});