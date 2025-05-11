$(document).ready(function () {
    const baseURL = APP_CONFIG.appURL;

    let URL_SAVE_TEMP_ADDRESS = baseURL + '/savetempaddress';
    let URL_CHECK_QUANTITY_PRODUCT_DT = baseURL + '/checkquantity';
    let URL_ADD_TO_CART = baseURL + '/addtocart';
    let URL_CART = baseURL + '/gio-hang';

    // ========================TEMP ADDRESS PRODUCT DETAIL=====================================
    $('#change-temp-address').click(() => {
        fetch('https://esgoo.net/api-tinhthanh/1/0.htm')
            .then(function (response) {
                return response.json();
            })
            .then(function (response) {
                console.log(response);
                response.data.forEach((province) => {
                    $('#temp-address-province').append(`<option value="${province.name}" data-id="${province.id}">${province.name}</option>`);
                });
            })
            .catch(function (err) {
                console.log(err);
            });

        $('#model_temp_address').addClass('modal-open');
    });

    $('#temp-address-province').change(() => {
        const selectedOption = $('#temp-address-province option:selected');
        const dataID = selectedOption.attr('data-id');

        fetch('https://esgoo.net/api-tinhthanh/2/' + dataID + '.htm')
            .then(function (response) {
                return response.json();
            })
            .then(function (response) {
                $('#temp-address-district').html('<option value="">Chọn quận/huyện</option>');
                $('#temp-address-ward').html('<option value="">Chọn phường xã</option>');
                response.data.forEach((district) => {
                    $('#temp-address-district').append(`<option value="${district.name}" data-id="${district.id}">${district.name}</option>`);
                });
            });
        $('#temp-address-district').removeAttr('disabled');
        $('#accept-temp-address').addClass('pointer-events-none opacity-25');
    });

    $('#temp-address-district').change(() => {
        const selectedOption = $('#temp-address-district option:selected');
        const dataID = selectedOption.attr('data-id');
        const val = $('#temp-address-ward').val('');

        fetch('https://esgoo.net/api-tinhthanh/3/' + dataID + '.htm')
            .then(function (response) {
                return response.json();
            })
            .then(function (response) {
                $('#temp-address-ward').html('<option value="">Chọn phường xã</option>');
                response.data.forEach((ward) => {
                    $('#temp-address-ward').append(`<option value="${ward.name}" data-id="${ward.id}">${ward.name}</option>`);
                });
            });

        $('#temp-address-ward').removeAttr('disabled');
        $('#accept-temp-address').addClass('pointer-events-none opacity-25');
    });

    $('#temp-address-ward').change(() => {
        const val = $('#temp-address-ward').val();
        if (val != '') {
            $('#accept-temp-address').removeClass('pointer-events-none opacity-25');
        } else {
            $('#accept-temp-address').addClass('pointer-events-none opacity-25');
        }
    });

    $('#accept-temp-address').click(() => {
        const province = $('#temp-address-province').val();
        const district = $('#temp-address-district').val();
        const ward = $('#temp-address-ward').val();

        $('#temp_address').text(ward + ', ' + district + ', ' + province);

        $.ajax({
            type: 'post',
            url: URL_SAVE_TEMP_ADDRESS,
            data: {
                province: province,
                district: district,
                ward: ward,
            },

            dataType: 'application/json',
            success: function (response) {
                console.log('save thành công');
            },
        });
        $('#model_temp_address').removeClass('modal-open');
    });
    // ======================================CLOSE MODAL TEMP ADDRESS
    $('#cancel-temp-address').click(() => {
        $('#model_temp_address').removeClass('modal-open');
    });

    // ============================CHANGE QUANTITY PRODUCT DETAIL==============
    $('.inc-quantity-product-detail').click(function () {
        const currentValue = parseInt($('.product-detail-quantity').val(), 10);

        $('.product-detail-quantity').val(currentValue + 1);

        $('.dec-quantity-product-detail').removeClass('pointer-events-none opacity-75');

        // data request
        const quantity = $('.product-detail-quantity').val();
        const productID = $('.product-detail-quantity').data('id');

        checkQuantity(quantity, productID);
    });

    $('.dec-quantity-product-detail').click(function () {
        const currentValue = parseInt($('.product-detail-quantity').val(), 10);

        const newValue = currentValue - 1;

        $('.product-detail-quantity').val(newValue);

        $('.inc-quantity-product-detail').removeClass('pointer-events-none opacity-75');

        // data request
        const quantity = $('.product-detail-quantity').val();
        const productID = $('.product-detail-quantity').data('id');

        checkQuantity(quantity, productID);

        if (newValue == 1) {
            $('.dec-quantity-product-detail').addClass('pointer-events-none opacity-75');
        }
    });

    // Kiểm tra số lượng khi tăng giảm
    function checkQuantity(quantity, productID) {
        $.ajax({
            type: 'POST',
            url: URL_CHECK_QUANTITY_PRODUCT_DT,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content'),
            },
            data: {
                quantity: quantity,
                productID: productID,
            },
            dataType: 'json',
            success: function (response) {
                if (response) {
                    $('meta[name="csrf_token"]').attr('content', response.token);
                    $('.product-detail-quantity').val(response.quantity);
                }
            },
            error: function (response) {
                if (response) {
                    $('meta[name="csrf_token"]').attr('content', response.responseJSON.token);
                    $('.product-detail-quantity').val(response.responseJSON.quantity);
                    toastr['error'](response.responseJSON.error.msg);
                    if (response.responseJSON.error.status == 'error') {
                        $('.inc-quantity-product-detail').addClass('pointer-events-none opacity-75');
                        $('.dec-quantity-product-detail').addClass('pointer-events-none opacity-75');
                    } else {
                        $('.inc-quantity-product-detail').addClass('pointer-events-none opacity-75');
                    }
                }
            },
        });
    }

    // Add To Cart
    $('.addToCart').click(function (e) {
        e.preventDefault();

        const $btn = $(this); // đảm bảo an toàn khi dùng trong async

        $btn.find('button').addClass('opacity-50 cursor-not-allowed').prop('disabled', true);

        setTimeout(() => {
            $btn.find('button').removeClass('opacity-50 cursor-not-allowed').prop('disabled', false);
        }, 3000);

        const event = $(this).data('event');
        const productID = $(this).data('id');
        const quantity = parseInt($('.product-detail-quantity').val());

        $.ajax({
            type: 'POST',
            url: URL_ADD_TO_CART,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content'),
            },
            data: {
                event: event,
                productID: productID,
                quantity: quantity,
            },
            dataType: 'json',
            success: function (response) {
                if (response) {
                    $('meta[name="csrf_token"]').attr('content', response.token);
                    if (response.event == 0) {
                        toastr['success'](response.success.msg);
                    } else {
                        setTimeout(function () {
                            window.location.href = URL_CART;
                        }, 200);
                    }
                }
            },
            error: function (response) {
                if (response) {
                    $('meta[name="csrf_token"]').attr('content', response.responseJSON.token);
                    toastr['error'](response.responseJSON.error.msg);
                }
            },
        });
    });
});
