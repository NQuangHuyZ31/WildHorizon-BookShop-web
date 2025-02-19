$(document).ready(function () {

  // ========================TEMP ADDRESS PRODUCT DETAIL=====================================
  $('#change-temp-address').click(() => {
    fetch('https://esgoo.net/api-tinhthanh/1/0.htm')
      .then(function (response) {
        return response.json();
      })
      .then(function (response) {
        console.log(response);
        response.data.forEach(province => {
          $('#temp-address-province').append(
            `<option value="${province.name}" data-id="${province.id}">${province.name}</option>`
          );
        });
      })
      .catch(function (err) {
        console.log(err);
      })

    $('#model_temp_address').addClass('modal-open');
  })

  $('#temp-address-province').change(() => {
    const selectedOption = $('#temp-address-province option:selected');
    const dataID = selectedOption.attr('data-id');

    fetch('https://esgoo.net/api-tinhthanh/2/' + dataID + '.htm')
      .then(function (response) {
        return response.json();
      })
      .then(function (response) {
        $("#temp-address-district").html('<option value="">Chọn quận/huyện</option>');
        $("#temp-address-ward").html('<option value="">Chọn phường xã</option>');
        response.data.forEach(district => {
          $('#temp-address-district').append(
            `<option value="${district.name}" data-id="${district.id}">${district.name}</option>`
          );
        });
      })
    $('#temp-address-district').removeAttr('disabled')
    $('#accept-temp-address').addClass('pointer-events-none opacity-25')
  })

  $('#temp-address-district').change(() => {
    const selectedOption = $('#temp-address-district option:selected');
    const dataID = selectedOption.attr('data-id');
    const val = $('#temp-address-ward').val('');

    fetch('https://esgoo.net/api-tinhthanh/3/' + dataID + '.htm')
      .then(function (response) {
        return response.json();
      })
      .then(function (response) {
        $("#temp-address-ward").html('<option value="">Chọn phường xã</option>');
        response.data.forEach(ward => {
          $('#temp-address-ward').append(
            `<option value="${ward.name}" data-id="${ward.id}">${ward.name}</option>`
          );
        });
      })

    $('#temp-address-ward').removeAttr('disabled')
    $('#accept-temp-address').addClass('pointer-events-none opacity-25')
  })

  $('#temp-address-ward').change(() => {
    const val = $('#temp-address-ward').val();
    if (val != '') {
      $('#accept-temp-address').removeClass('pointer-events-none opacity-25')
    } else {
      $('#accept-temp-address').addClass('pointer-events-none opacity-25')
    }
  })

  $('#accept-temp-address').click(() => {
    const province = $('#temp-address-province').val();
    const district = $('#temp-address-district').val();
    const ward = $('#temp-address-ward').val();

    $('#temp_address').text(ward + ', ' + district + ', ' + province);
    $.ajax({
      type: "post",
      url: "/WildHorizon-BookShop/savetempaddress",
      data: {
        province: province,
        district: district,
        ward: ward
      },

      dataType: "application/json",
      success: function (response) {
        console.log('save thành công');
      }
    });
    $('#model_temp_address').removeClass('modal-open');
  })
  // ======================================CLOSE MODAL TEMP ADDRESS
  $('#cancel-temp-address').click(() => {
    $('#model_temp_address').removeClass('modal-open');
  })

  // ============================CHANGE QUANTITY PRODUCT DETAIL==============
  $('.inc-quantity-product-detail').click(function () {

    const currentValue = parseInt($('.product-detail-quantity').val(), 10);

    $('.product-detail-quantity').val(currentValue + 1);

    $('.dec-quantity-product-detail').removeClass('pointer-events-none opacity-75');

    // data request
    const quantity = $('.product-detail-quantity').val();
    const productID = $('.product-detail-quantity').data('id');

    checkQuantity(quantity, productID);
  })

  $('.dec-quantity-product-detail').click(function () {

    const currentValue = parseInt($('.product-detail-quantity').val(), 10);

    const newValue = currentValue - 1;

    $('.product-detail-quantity').val(newValue);

    $('.inc-quantity-product-detail').removeClass('pointer-events-none opacity-75');

    if (newValue == 1) {
      $('.dec-quantity-product-detail').addClass('pointer-events-none opacity-75');
    }
  })

  function checkQuantity(quantity, productID) {
    $.ajax({
      type: "post",
      url: "/WildHorizon-BookShop/checkquantity",
      data: {
        quantity: quantity,
        productID: productID
      },
      dataType: "json",
      success: function (response) {

        if (response.success == 1) {

          $('.inc-quantity-product-detail').addClass('pointer-events-none opacity-75');
          toastr.error(response.message)
        } else {

          console.log(response.message)
        }
      },
      error: function (xhr, status, error) {
        console.error("Lỗi AJAX:", error);
      }
    });
  }

  // Add To Cart
  $('.addToCart').click(function (e) {
    e.preventDefault();
    var event = $(this).data('event');
    var productID = $(this).data('id');
    var quantity = parseInt($('.product-detail-quantity').val());

    $.ajax({
      type: "post",
      url: "/WildHorizon-BookShop/addtocart",
      data: {
        event: event,
        productID: productID,
        quantity: quantity,
      },
      dataType: "json",
      success: function (response) {
        if (response.event == 0) {
          if (response.success == 0) {
            toastr.error(response.message)
          } else {
            toastr.success(response.message)
          }
        } else {
          setTimeout(function () {
            window.location.href = "http://localhost/WildHorizon-BookShop/gio-hang";
          }, 200);
        }
      }
    });
  });
});