$(document).ready(function () {
    const baseURL = window.location.origin + '/WildHorizon-BookShop';
    let URL_UPDATE_PRICE_CART = baseURL + '/updatepricecart';
    let URL_CHECK_QUANTITY_CART = baseURL + '/checkquantitycart';
    let URL_DELETE_ITEM_CART = baseURL + '/gio-hang/delete';
    let URL_ADD_ADDRESS_CHECKOUT = baseURL + '/checkout/addnewaddress';
    let URL_GET_ADDRESS_CHECKOUT = baseURL + '/checkout/getaddress';

    // check từng sản phẩm
    $('.cart-item-checkbox').on('click', function (e) {
        var item = $(this);
        var checkbox = item.find('.cart-input-checkbox');
        var quantityInput = item.closest('.cart-product-item').find('.cart-product-quantity');

        // Đảo trạng thái của checkbox input
        checkbox.prop('checked', !checkbox.prop('checked'));

        // Cập nhật trạng thái của input số lượng
        quantityInput.prop('disabled', !checkbox.prop('checked'));

        // Cập nhật giao diện dựa trên trạng thái mới của checkbox
        item.toggleClass('bg-orange-500', checkbox.prop('checked'));
        item.find('.cart-icon-checkbox').toggleClass('opacity-0', !checkbox.prop('checked'));

        updatePrice();
    });

    // Xử lí tăng giảm quantity
    $('.cart-product-item').each(function () {
        const item = $(this);
        const quantityInput = item.find('.cart-product-quantity');
        const decButton = item.find('.dec-quantity');

        // Vô hiệu hóa nút giảm nếu giá trị ban đầu là 1
        if (parseInt(quantityInput.val(), 10) === 1) {
            decButton.addClass('pointer-events-none');
        } else {
            decButton.removeClass('pointer-events-none');
        }
    });

    // // Xử lý khi nhấn nút giảm số lượng
    $('.dec-quantity').click(function (e) {
        e.preventDefault();

        const item = $(this).closest('.cart-product-item');
        const quantityInput = item.find('.cart-product-quantity');
        const decButton = $(this);
        const currentValue = parseInt(quantityInput.val(), 10);
        const productID = item.find('.cart-product-quantity').data('productid');
        item.find('.inc-quantity').removeClass('pointer-events-none');
        if (currentValue > 1) {
            const newValue = currentValue - 1;
            quantityInput.val(newValue);

            checkQuantityCart(newValue, productID, $(this));
            // Vô hiệu hóa nút giảm nếu giá trị giảm về 1
            if (newValue === 1) {
                decButton.addClass('pointer-events-none');
            }
        }
    });

    // // Xử lý khi nhấn nút tăng số lượng
    $('.inc-quantity').click(function (e) {
        e.preventDefault();
        const item = $(this).closest('.cart-product-item');
        const decButton = item.find('.dec-quantity');

        // Data request
        const quantityInput = item.find('.cart-product-quantity');
        const productID = item.find('.cart-product-quantity').data('productid');
        const currentValue = parseInt(quantityInput.val(), 10);

        // Tăng giá trị
        const newValue = currentValue + 1;
        quantityInput.val(newValue);

        // Check quantity cart
        checkQuantityCart(newValue, productID, $(this));
        // Kích hoạt lại nút giảm nếu giá trị vượt 1
        if (newValue > 1) {
            decButton.removeClass('pointer-events-none');
        }
    });

    // Update giá trên giỏ hàng
    function updatePrice() {
        var data = [];
        $('.cart-input-checkbox:checked').each(function () {
            quantity = parseInt($(this).closest('.cart-product-item').find('.cart-product-quantity').val());
            productID = parseInt($(this).closest('.cart-product-item').find('.cart-product-quantity').data('productid'));

            data.push({ productID, quantity });
        });

        $.ajax({
            type: 'post',
            url: URL_UPDATE_PRICE_CART,
            data: { data: data },
            dataType: 'json',
            success: function (response) {
                $('#cart-subtotal').text(response.data.totalprice);
                $('#cart-saved').text(response.data.saveprice);
                $('#cart-total').text(response.data.total);
                if (response.data.total == 0) {
                    $('#cart-checkout').removeClass('bg-orange-500').addClass('bg-gray-300');
                    $('#btn-checkout').addClass('pointer-event-none');
                } else {
                    $('#cart-checkout').addClass('bg-orange-500').removeClass('bg-gray-300');
                    $('#btn-checkout').removeClass('pointer-event-none');
                }
            },
        });
    }

    // check quantity cart
    function checkQuantityCart(quantity, productID, btn) {
        $.ajax({
            type: 'post',
            url: URL_CHECK_QUANTITY_CART,
            data: {
                quantity: quantity,
                productID: productID,
            },
            dataType: 'json',
            success: function (response) {
                if (response.error) {
                    toastr.error(response.error.message);
                    btn.addClass('pointer-events-none');
                    btn.closest('.cart-product-item').find('.cart-product-quantity').val(response.quantity);
                    console.log(btn.closest('.cart-product-item').find('.cart-product-quantity').val());
                } else if (response.success) {
                    updatePrice();
                }
            },
        });
    }

    // Submit form delete  product
    $('.cart-delete-product').on('click', function (e) {
        e.preventDefault(); // Ngăn chặn hành vi mặc định của form nếu có
        var productID = $(this).data('id');
        $.ajax({
            type: 'POST',
            url: URL_DELETE_ITEM_CART,
            data: { productID: productID }, // Định dạng đúng của dữ liệu
            dataType: 'json',
            success: function (response) {
                if (response.success == 1) {
                    location.reload(); // Reload lại trang nếu xóa thành công
                } else {
                    alert('Xóa thất bại, vui lòng thử lại!');
                }
            },
            error: function () {
                alert('Có lỗi xảy ra khi gửi yêu cầu!');
            },
        });
    });

    // Checkout address
    $('.add-orther-address').click(function (e) {
        e.preventDefault();
        JsLoadingOverlay.show();
        setTimeout(() => {
            JsLoadingOverlay.hide();
            checkout_new_address_modal.showModal();
        }, 500);
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
                    setTimeout(() => {
                        $('#checkout-new-address').prop('disabled', false);
                    }, 3000);
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
                    $('input[name="csrf_token"]').val(response.token);
                    $('.checkout-address-content').html('');
                    response.success.data.forEach((address) => {
                        $('.checkout-address-content').append(`
                         <div class="flex items-center justify-between mb-3">
                            <label class="flex items-center text-[14px] cursor-pointer">
                            <input
                                type="radio"
                                name="checkout-address"
                                value="${address.id}"
                                data-id="${address.id}"
                                class="radio radio-success mr-3"
                                ${address.default_address == 1 ? 'checked="checked"' : ''} />
                            <!--  -->
                            ${address.username}
                            <span class="h-[17px] w-[2px] bg-gray-200 mx-3"></span>
                            ${address.address}, ${address.ward}, ${address.district}, ${address.province}
                            <span class="h-[17px] w-[2px] bg-gray-200 mx-3"></span>
                            ${address.phone}
                            </label>
                            <div class="text-[14px] flex justify-start w-[100px] font-semibold text-blue-500">
                            ${address.default_address == 0 ? '<button type="button" class="update-address-checkout">Xóa</button>' : ''}
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
