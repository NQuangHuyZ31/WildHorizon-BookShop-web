$(document).ready(function () {
    const baseUrl = APP_CONFIG.appURL;
    let URL_ADD_ADDRESS_CHECKOUT = baseUrl + '/checkout/addnewaddress';
    let URL_GET_ADDRESS_CHECKOUT = baseUrl + '/checkout/getaddress';
    let URL_DELETE_ADDRESS_CHECKOUT = baseUrl + '/checkout/delete';
    // Checkout Form
    $('#checkout-province').click(() => {
        fetch('https://esgoo.net/api-tinhthanh/1/0.htm')
            .then(function (response) {
                return response.json();
            })
            .then(function (response) {
                response.data.forEach((province) => {
                    $('#checkout-province').append(`<option value="${province.name}" data-id="${province.id}">${province.name}</option>`);
                });
            })
            .catch(function (err) {
                console.log(err);
            });
    });

    $('#checkout-province').change(() => {
        const selectedOption = $('#checkout-province option:selected');
        const dataID = selectedOption.attr('data-id');

        fetch('https://esgoo.net/api-tinhthanh/2/' + dataID + '.htm')
            .then(function (response) {
                return response.json();
            })
            .then(function (response) {
                $('#checkout-district').html('<option value="">Chọn quận/huyện</option>');
                $('#checkout-ward').html('<option value="">Chọn phường xã</option>');
                response.data.forEach((district) => {
                    $('#checkout-district').append(`<option value="${district.name}" data-id="${district.id}">${district.name}</option>`);
                });
            });
        $('#checkout-district').removeAttr('disabled');
    });

    $('#checkout-district').change(() => {
        const selectedOption = $('#checkout-district option:selected');
        const dataID = selectedOption.attr('data-id');
        const val = $('#checkout-ward').val('');

        fetch('https://esgoo.net/api-tinhthanh/3/' + dataID + '.htm')
            .then(function (response) {
                return response.json();
            })
            .then(function (response) {
                $('#checkout-ward').html('<option value="">Chọn phường xã</option>');
                response.data.forEach((ward) => {
                    $('#checkout-ward').append(`<option value="${ward.name}" data-id="${ward.id}">${ward.name}</option>`);
                });
            });

        $('#checkout-ward').removeAttr('disabled');
    });

    // Change fee shipping
    $('.shipping-fee').change(() => {
        var shipCost = parseInt($('input[name="shipping-fee"]:checked').val());
        var totalPrice = parseInt($('.total-price').data('total'));

        $('.shipping-cost').text(new Intl.NumberFormat('vi').format(shipCost) + 'đ');
        $('.total-price').text(new Intl.NumberFormat('vi').format(totalPrice + shipCost) + 'đ');
    });

    // Add new address checkout
    $('#checkout-new-address').click(function (e) {
        e.preventDefault();
        $(this).prop('disabled', true);
        const csrf_token = $('input[name="csrf_token"]').val();
        const username = $('input[name="username"]').val();
        const phone = $('input[name="phone"]').val();
        const province = $('select[name="province"]').val();
        const district = $('select[name="district"]').val();
        const ward = $('select[name="ward"]').val();
        const address = $('input[name="address"]').val();

        setTimeout(() => {
            $('#checkout-new-address').prop('disabled', false);
        }, 3000);

        $.ajax({
            type: 'POST',
            url: URL_ADD_ADDRESS_CHECKOUT,
            data: {
                csrf_token,
                username,
                phone,
                province,
                district,
                ward,
                address,
            },
            dataType: 'json',
            success: function (response) {
                if (response.success) {
                    checkout_new_address_modal.close();
                    $('input[name="csrf_token"]').val(response.token);
                    JsLoadingOverlay.show();
                    getAddressCheckout();
                    setTimeout(() => {
                        JsLoadingOverlay.hide();
                    }, 700);
                }
            },
            error: function (response) {
                if (response) {
                    toastr['error'](response.responseJSON.error.msg);
                    $('input[name="csrf_token"]').val(response.responseJSON.token);
                }
            },
        });
    });

    // Xóa địa chỉ ở checkout
    $(document).on('click', '.delete-address-checkout', function (e) {
        e.preventDefault();
        const addressID = $(this).data('id');
        $(this).prop('disabled', true);
        setTimeout(() => {
            $(this).prop('disabled', false);
        }, 3000);

        $.ajax({
            type: 'POST',
            url: URL_DELETE_ADDRESS_CHECKOUT,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content'),
            },
            data: {
                addressID,
            },
            dataType: 'json',
            success: function (response) {
                if (response) {
                    $('input[name="csrf_token"]').val(response.token);
                    $('meta[name="csrf_token"]').attr('content', response.token);
                    if (response.success) {
                        getAddressCheckout();
                    }
                }
            },
            error: function (response) {
                if (response) {
                    $('meta[name="csrf_token"]').attr('content', response.responseJSON.token);
                    toastr['error'](response.responseJSON.token);
                }
            },
        });
    });

    // Get address
    function getAddressCheckout() {
        const csrf_token = $('input[name="csrf_token"]').val();
        $.ajax({
            type: 'POST',
            url: URL_GET_ADDRESS_CHECKOUT,
            data: { csrf_token },
            dataType: 'json',
            success: function (response) {
                if (response) {
                    $('meta[name="csrf_token"]').attr('content', response.token);
                    $('input[name="csrf_token"]').val(response.token);
                    $('.checkout-address-content').html('');
                    response.success.data.forEach((address) => {
                        $('.checkout-address-content').append(`
                         <div class="flex items-center justify-between mb-3">
                            <label class="flex items-center text-[12px] lg:text-sm cursor-pointer">
                                <input
                                    type="radio"
                                    name="checkout-address"
                                    value="${address.id}"
                                    data-id="${address.id}"
                                    class="radio radio-success mr-3"
                                    ${address.default_address == 1 ? 'checked="checked"' : ''} />
                                    <!--  -->
                                <p>${address.username}</p>
                                <span class="h-[17px] w-[2px] bg-gray-200 mx-3"></span>
                                <p>${address.address}, ${address.ward}, ${address.district}, ${address.province}</p>
                                <span class="h-[17px] w-[2px] bg-gray-200 mx-3"></span>
                                <p>${address.phone}</p>
                            </label>
                            <div class="text-[12px] flex justify-start font-semibold text-blue-500 ms-2 lg:w-[100px] lg:text-[14px]">
                            ${address.default_address == 0 ? `<button type="button" class="delete-address-checkout" data-id="${address.id}">Xóa</button` : ''}
                            </div>
                        </div>
                        `);
                    });
                }
            },
            error: function (response) {
                if (response) {
                    toastr['error'](response.responseJSON.error.msg);
                    $('input[name="csrf_token"]').val(response.responseJSON.token);
                }
            },
        });
    }

    // Submit form checkout
    $('#cart-checkout').click((e) => {
        e.preventDefault();
        if ($('#btn-checkout').hasClass('pointer-event-none')) {
            return;
        }
        $('#form-checkout').submit();
    });
});
