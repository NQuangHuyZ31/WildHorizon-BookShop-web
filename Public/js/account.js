$(document).ready(function () {
    let URL_CUSTOMER_ADDRESS = '/WildHorizon-BookShop/customer/address';
    let URL_UPDATE_INFO_CUSTOMER = '/WildHorizon-BookShop/customer/account';
    let URL_ADD_NEW_ADDRESS = '/WildHorizon-BookShop/customer/address/add';
    let URL_DELETE_ADDRESS = '/WildHorizon-BookShop/customer/address/delete';
    let URL_UPDATE_ADDRESS = '/WildHorizon-BookShop/customer/address/edit';
    let URL_SEND_MAIL_VERIFY = '/WildHorizon-BookShop/customer/changepassword/sendmailverify';
    let URL_VERIFY_CHANGEPW_PAGE = '/WildHorizon-BookShop/customer/changepassword/verify';

    let PROVINCE = '#province';
    let DISTRICT = '#district';
    let WARD = '#ward';

    const province_value = '';
    const district_value = '';
    const ward_value = '';

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
                    if (response.success.status == 1) {
                        toastr['success'](response.success.msg);
                        setTimeout(() => {
                            window.location.href = URL_CUSTOMER_ADDRESS;
                        }, 500);
                    }

                    $('input[name="csrf_token"]').val(response.token);
                } catch (error) {
                    console.log(error);
                }
            },
            error: function (response) {
                if (response.status >= 400) {
                    toastr['error'](response.responseJSON.msg);
                }
                $('input[name="csrf_token"]').val(response.responseJSON.token);
            },
        });
    }

    // Gửi yêu cầu thêm địa chỉ
    $('#btn-save-address').click(() => {
        addNewAddress();
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
                console.log(response);
                if (response.status == 200) {
                    toastr['success'](response.msg);
                    setTimeout(() => {
                        location.href = URL_CUSTOMER_ADDRESS;
                    }, 600);
                    $('input[name="csrf_token"]').val(response.token);
                }
            },
            error: function (response) {
                console.log(response.responseJSON.msg);
                $('input[name="csrf_token"]').val(response.responseJSON.token);
            },
        });
    });

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
                if (response.success.status == 1) {
                    toastr['success'](response.success.msg);
                    setTimeout(() => {
                        location.reload();
                    }, 1000);
                } else {
                    toastr['error'](response.success.msg);
                }
                $('input[name="csrf_token"]').val(response.token);
            },
        });
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
                console.log(response.responseJSON.msg);
                $('input[name="csrf_token"]').val(response.responseJSON.token);
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

    // Change password
    $('#btn-changepw').click(function (e) {
        e.preventDefault();

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
                console.log(response);
                if (response.status == 200) {
                    $('input[name="csrf_token"]').val(response.token);
                    toastr['success'](response.msg);
                    // setTimeout(() => {
                    //     window.location.href = response.url + '/customer/changepassword/verify';
                    // }, 1000);
                }
            },
            error: function (response) {
                if (response.status >= 400) {
                    toastr['error'](response.responseJSON.msg);
                    $('input[name="csrf_token"]').val(response.responseJSON.token);
                }
            },
        });
    });
});
