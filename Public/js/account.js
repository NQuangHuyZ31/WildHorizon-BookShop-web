$(document).ready(function () {
    const baseUrl = '/WildHorizon-BookShop';

    const URL_UPDATE_INFO_CUSTOMER = `${baseUrl}/customer/account`;
    const URL_CUSTOMER_ADDRESS = `${baseUrl}/customer/address`;
    const URL_ADD_NEW_ADDRESS = `${baseUrl}/customer/address/add`;
    const URL_DELETE_ADDRESS = `${baseUrl}/customer/address/delete`;
    const URL_UPDATE_ADDRESS = `${baseUrl}/customer/address/edit`;
    const URL_SEND_MAIL_VERIFY = `${baseUrl}/customer/changepassword/sendmailverify`;
    const URL_VERIFY_CHANGEPW_PAGE = `${baseUrl}/customer/changepassword/verify`;
    const URL_RESEND_OTP = `${baseUrl}/customer/changepassword/verify/resend`;
    const URL_GET_ORDER_INFO = `${baseUrl}/customer/order/getorder`;
    const URL_SAVE_REVIEW = `${baseUrl}/customer/order/savereview`;
    const URL_GET_PRODUCT_REVIEW = `${baseUrl}/customer/order/getproductreview`;

    let PROVINCE = '#province';
    let DISTRICT = '#district';
    let WARD = '#ward';

    const province_value = '';
    const district_value = '';
    const ward_value = '';

    // UPDATE THÔNG TIN KHÁCH HÀNG
    $('#btn-update-customer').click((e) => {
        e.preventDefault();
        const username = $('input[name="username"]').val();
        const phone = $('input[name="phone"]').val();
        const gender = $('input[name="gender"]:checked').val();
        const day = $('input[name="day"]').val();
        const mounth = $('input[name="mounth"]').val();
        const year = $('input[name="year"]').val();
        const csrf_token = $('input[name="csrf_token"]').val();

        $.ajax({
            type: 'POST',
            url: URL_UPDATE_INFO_CUSTOMER,
            data: {
                username: username,
                phone: phone,
                gender: gender,
                day: day,
                mounth: mounth,
                year: year,
                csrf_token: csrf_token,
            },
            dataType: 'json',
            success: function (response) {
                if (response) {
                    toastr['success'](response.success.msg);
                    setTimeout(() => {
                        location.reload();
                    }, 1000);
                    $('input[name="csrf_token"]').val(response.token);
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
    // CUSTOMER ADDRESS
    // Lấy tên tỉnh thành phố
    window.getProvince = function (province_value) {
        fetch('https://esgoo.net/api-tinhthanh/1/0.htm')
            .then(function (response) {
                return response.json();
            })
            .then(function (response) {
                response.data.forEach((province) => {
                    $(PROVINCE).append(
                        `<option value="${province.name}" data-id="${province.id}" ${province_value != '' ? (province.name == province_value ? 'selected' : '') : ''}>${
                            province.name
                        }</option>`
                    );
                });

                if (response) {
                    setTimeout(() => getDistrict(), 300); // delay 1 chút để dropdown cập nhật xong
                }
            })
            .catch(function (err) {
                console.log(err);
            });
    };

    // Lấy danh sách quận huyện
    window.getDistrict = function (district_value) {
        const selectedOption = $(PROVINCE + ' option:selected');
        const dataID = selectedOption.attr('data-id');

        fetch('https://esgoo.net/api-tinhthanh/2/' + dataID + '.htm')
            .then(function (response) {
                return response.json();
            })
            .then(function (response) {
                $(DISTRICT).html('<option value="">Chọn quận/huyện</option>');
                $(WARD).html('<option value="">Chọn phường xã</option>');
                response.data.forEach((district) => {
                    $(DISTRICT).append(`<option value="${district.name}" data-id="${district.id}" ${district.name == district_value ? 'selected' : ''}>${district.name}</option>`);
                });
            });
        $(DISTRICT).removeAttr('disabled');
    };

    // Lấy danh sách phường xã
    window.getWard = function (ward_value) {
        const selectedOption = $(DISTRICT + ' option:selected');
        const dataID = selectedOption.attr('data-id');
        const val = $(WARD).val('');

        fetch('https://esgoo.net/api-tinhthanh/3/' + dataID + '.htm')
            .then(function (response) {
                return response.json();
            })
            .then(function (response) {
                $(WARD).html('<option value="">Chọn phường xã</option>');
                response.data.forEach((ward) => {
                    $(WARD).append(`<option value="${ward.name}" data-id="${ward.id}" ${ward_value != '' ? (ward.name == ward_value ? 'selected' : '') : ''}>${ward.name}</option>`);
                });
            });
    };

    // Load api tỉnh thành
    $(PROVINCE).click(function () {
        getProvince(province_value);
    });

    $(PROVINCE).change(() => {
        getDistrict(district_value);
    });

    $(DISTRICT).change(() => {
        getWard(ward_value);
    });

    // Hàm thêm địa chỉ mới
    function addNewAddress() {
        const username = $('input[name="username"]').val();
        const phone = $('input[name="phone"]').val();
        const province = $(PROVINCE).val();
        const district = $(DISTRICT).val();
        const ward = $(WARD).val();
        const address = $('input[name="address"]').val();
        const csrf_token = $('input[name="csrf_token"]').val();
        const default_address = $('input[name="default_address"]:checked').val();
        $.ajax({
            type: 'POST',
            url: URL_ADD_NEW_ADDRESS,
            data: {
                username,
                phone,
                province,
                district,
                ward,
                address,
                default_address,
                csrf_token,
            },
            dataType: 'json',
            success: function (response) {
                try {
                    if (response) {
                        toastr['success'](response.success.msg);
                        $('input[name="csrf_token"]').val(response.token);
                        setTimeout(() => {
                            window.location.href = URL_CUSTOMER_ADDRESS;
                        }, 500);
                    }
                } catch (error) {
                    console.log(error);
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

    // Gửi yêu cầu thêm địa chỉ
    $('#btn-save-address').click(() => {
        addNewAddress();
    });

    // Xóa địa chỉ
    $('.icon-delete-address').click(function () {
        const addressID = $(this).data('id');
        const csrf_token = $('input[name="csrf_token"]').val();
        console.log(addressID, csrf_token);
        $.ajax({
            type: 'POST',
            url: URL_DELETE_ADDRESS,
            data: {
                addressID,
                csrf_token,
            },
            dataType: 'json',
            success: function (response) {
                if (response.status == 200) {
                    $('input[name="csrf_token"]').val(response.token);
                }
                setTimeout(() => {
                    location.href = location.href;
                }, 200);
            },
            error: function (response) {
                $('input[name="csrf_token"]').val(response.responseJSON.token);
            },
        });
    });

    // Gửi yêu cầu cập nhật địa chỉ
    $('#btn-update-address').click(function (e) {
        e.preventDefault();
        const username = $('input[name="username"]').val();
        const phone = $('input[name="phone"]').val();
        const province = $(PROVINCE).val();
        const district = $(DISTRICT).val();
        const ward = $(WARD).val();
        const address = $('input[name="address"]').val();
        const default_address = $('input[name="default_address"]:checked').val();
        const csrf_token = $('input[name="csrf_token"]').val();
        const addressID = $('input[name="address"]').data('id');

        $.ajax({
            type: 'POST',
            url: URL_UPDATE_ADDRESS,
            data: {
                username,
                phone,
                province,
                district,
                ward,
                address,
                default_address,
                csrf_token,
                addressID,
            },
            dataType: 'json',
            success: function (response) {
                if (response) {
                    toastr['success'](response.success.msg);
                    setTimeout(() => {
                        location.href = URL_CUSTOMER_ADDRESS;
                    }, 600);
                    $('input[name="csrf_token"]').val(response.token);
                }
            },
            error: function (response) {
                if (response) {
                    $('input[name="csrf_token"]').val(response.responseJSON.token);
                    toastr['error'](response.responseJSON.error.msg);
                }
            },
        });
    });

    // Gọi hàm khi vào trang sửa địa chỉ
    if (window.location.pathname.includes('edit/')) {
        var province_set = $(PROVINCE).data('province');
        var district_set = $(DISTRICT).data('district');
        var ward_set = $(WARD).data('ward');

        getProvince(province_set);

        setTimeout(() => {
            getDistrict(district_set);
        }, 700);

        setTimeout(() => {
            getWard(ward_set);
        }, 1200);
    }

    // CUSTOMER CHANGE PASSWORD
    // Change password
    $('#btn-changepw').click(function (e) {
        e.preventDefault();
        JsLoadingOverlay.show();
        const old_password = $('input[name="old_password"]').val();
        const new_password = $('input[name="new_password"]').val();
        const confirm_new_password = $('input[name="confirm_new_password"]').val();
        const csrf_token = $('input[name="csrf_token"]').val();
        $.ajax({
            type: 'POST',
            url: URL_SEND_MAIL_VERIFY,
            data: {
                old_password,
                new_password,
                confirm_new_password,
                csrf_token,
            },
            dataType: 'json',
            success: function (response) {
                // console.log(response);
                if (response) {
                    JsLoadingOverlay.hide();

                    $('input[name="csrf_token"]').val(response.token);
                    toastr['success'](response.success.msg);
                    setTimeout(() => {
                        window.location.href = response.url + '/customer/changepassword/verify';
                    }, 500);
                }
            },
            error: function (response) {
                if (response) {
                    JsLoadingOverlay.hide();
                    toastr['error'](response.responseJSON.error.msg);
                    $('input[name="csrf_token"]').val(response.responseJSON.token);
                }
            },
        });
    });

    // Resend OTP
    $('#btn-otp-resend').click(function (e) {
        e.preventDefault();
        JsLoadingOverlay.show();

        const csrf_token = $('input[name="csrf_token"]').val();
        $.ajax({
            type: 'POST',
            url: URL_RESEND_OTP,
            data: {
                csrf_token,
            },
            dataType: 'json',
            success: function (response) {
                if (response) {
                    JsLoadingOverlay.hide();
                    toastr['success'](response.success.msg);
                    $('input[name="csrf_token"]').val(response.token);
                }
            },
            error: function (response) {
                if (response) {
                    JsLoadingOverlay.hide();
                    toastr['error'](response.responseJSON.error.msg);
                    $('input[name="csrf_token"]').val(response.responseJSON.token);
                }
            },
        });
    });

    // CUSTOMER ORDER
    // Show modal review order
    $('.review-order').click(function () {
        JsLoadingOverlay.show();

        const orderID = $(this).data('id');
        getOrderInfo(orderID);

        setTimeout(() => {
            JsLoadingOverlay.hide();
            review_order_modal.showModal();
        }, 500);
    });

    // Lấy dữ liệu đơn hàng
    function getOrderInfo(orderID) {
        $.ajax({
            type: 'GET',
            url: URL_GET_ORDER_INFO,
            data: {
                orderID,
            },
            dataType: 'json',
            success: function (response) {
                try {
                    if (response) {
                        $('#order_modal_id').text(response.success.order_id);
                        $('#order_modal_id').attr('data-id', response.success.order_id);
                        response.success.data.forEach((order_detail) => {
                            $('.product-review-content').append(
                                `<div class="product-review" data-product-id="${order_detail.product_id}">
                                    <div class="text-[14px] text-gray-400 mt-2">
                                        <div class="flex items-center ">
                                            <img src="${response.url}/Public/upload/products/${order_detail.product_image}" alt="hình ảnh" class="product-review-image">
                                            <p class="ms-3">${order_detail.product_name}</p>
                                        </div>
                                        <div class="mt-1 text-center">
                                            <div class="rating">
                                                <input type="radio" name="rating-product-${order_detail.product_id}" value="1" class="mask mask-star-2 w-[17px] h-[17px] bg-green-500" aria-label="1 star" />
                                                <input type="radio" name="rating-product-${order_detail.product_id}" value="2" class="mask mask-star-2 w-[17px] h-[17px] bg-green-500" aria-label="2 star" />
                                                <input type="radio" name="rating-product-${order_detail.product_id}" value="3" class="mask mask-star-2 w-[17px] h-[17px] bg-green-500" aria-label="3 star" />
                                                <input type="radio" name="rating-product-${order_detail.product_id}" value="4" class="mask mask-star-2 w-[17px] h-[17px] bg-green-500" aria-label="4 star" />
                                                <input type="radio" name="rating-product-${order_detail.product_id}" value="5" class="mask mask-star-2 w-[17px] h-[17px] bg-green-500" aria-label="5 star" checked />
                                            </div>
                                        </div>
                                        <textarea type="text" name="comment-product-${order_detail.product_id}" placeholder="Viết bình luận của bạn về sản phẩm" class="textarea textarea-info w-full mt-2"></textarea>
                                    </div>
                                </div>`
                            );
                        });
                    }
                } catch (error) {
                    console.log(error);
                }
            },
        });
    }

    // Lưu đánh giá
    $('#btn-save-review').click(function (e) {
        e.preventDefault();
        let product_comment = [];
        let product_rating = [];
        let product_id = [];

        // lấy rating và comment từng product
        $('.product-review').each(function () {
            const productID = $(this).data('product-id');
            product_id.push(productID);

            product_rating.push($(this).find(`input[name="rating-product-${productID}"]:checked`).val());

            product_comment.push($(this).find(`textarea[name="comment-product-${productID}"]`).val());
        });

        const orderID = $('#order_modal_id').data('id');
        const order_comment = $('textarea[name="comment-order"]').val();
        const order_rating = $('input[name="rating-order"]:checked').val();
        const csrf_token = $('input[name="csrf_token"]').val();
        $.ajax({
            type: 'POST',
            url: URL_SAVE_REVIEW,
            data: {
                orderID,
                order_rating,
                order_comment,
                product_id,
                product_rating,
                product_comment,
                csrf_token,
            },
            dataType: 'json',
            success: function (response) {
                if (response) {
                    toastr['success'](response.success.msg);
                    $('input[name="csrf_token"]').val(response.token);
                    setTimeout(() => {
                        review_order_modal.showModal();
                        location.reload();
                    }, 500);
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

    // CUSTOMER REVIEW

    // Xem lại product review
    $('.review-product-reseen').click(function (e) {
        e.preventDefault();
        JsLoadingOverlay.show();
        $('.review-product-content').html('');
        const orderID = $(this).data('id');
        getInfoProductReview(orderID);
        setTimeout(() => {
            JsLoadingOverlay.hide();
            review_product_modal.showModal();
        }, 500);
    });

    // Lấy thông tin product review
    function getInfoProductReview(orderID) {
        $.ajax({
            type: 'GET',
            url: URL_GET_PRODUCT_REVIEW,
            data: {
                orderID,
            },
            dataType: 'json',
            success: function (response) {
                if (response) {
                    response.success.data.forEach((review) => {
                        let rating = '';
                        for (let index = 1; index <= 5; index++) {
                            rating += `<input type="radio" name="rating-product-${
                                review.product_id
                            }" value="${index}" class="mask mask-star-2 w-[17px] h-[17px] bg-green-500" aria-label="${index} star" ${
                                review.product_rating == index ? 'checked' : ''
                            } disabled/>`;
                        }

                        $('.review-product-content').append(`
                             <div class="text-[14px] text-gray-400 mt-2">
                                <div class="flex items-center ">
                                    <img src="${response.url}/Public/upload/products/${review.product_image}" alt="hình ảnh" class="product-review-image">
                                    <p class="ms-3">${review.product_name}</p>
                                </div>
                                <div class="rating w-full">
                                    <div class="mt-1 text-center w-full">
                                         ${rating}
                                    </div>
                                </div>
                                <textarea type="text" name="comment-product-${
                                    review.product_id
                                }" placeholder="Viết bình luận của bạn về sản phẩm" class="textarea textarea-info w-full mt-2" readonly>${
                            review.product_comment != '' ? review.product_comment : 'Không có đánh giá cho sản phẩm này'
                        }</textarea>
                            </div>   
                                    
                        `);
                    });
                }
            },
        });
    }
});
