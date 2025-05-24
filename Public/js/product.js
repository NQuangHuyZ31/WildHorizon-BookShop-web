$(document).ready(function () {
    const baseURL = APP_CONFIG.appURL;
    let URL_GET_PRODUCT_FILTER = baseURL + '/product/search-filter';
    let URL_LOADMORE_PRODUCT = baseURL + '/product/loadmoreproduct';

    window.toggleContent = function (e) {
        '200px' == $(e + '.auto-maxheight').css('max-height')
            ? ($(e + '.auto-maxheight').css('max-height', 'fit-content'), $(e).closest('div').find('button').text('Thu gọn'))
            : ($(e + '.auto-maxheight').css('max-height', '200px'),
              $([document.documentElement, document.body]).animate(
                  {
                      scrollTop: $(e).offset().top,
                  },
                  500
              ),
              $(e).closest('div').find('button').text('Xem thêm'));
    };

    // Load thêm sản phẩm
    $('#loadMore-product').click(function (e) {
        e.preventDefault();
        const btn = $(this);
        const offset = $(this).data('offset');

        $.ajax({
            type: 'get',
            url: URL_LOADMORE_PRODUCT,
            data: {
                offset,
            },
            dataType: 'json',
            success: function (response) {
                if (response) {
                    var newOfset = offset + parseInt(response.offset);
                    btn.data('offset', newOfset);
                    if (response.success.count > 0) {
                        response.success.data.forEach((product) => {
                            $('.whr-product').append(`
                             <a href="${response.url}/product/${createSlug(product.product_name)}-${product.id}" class="">
                                <div class="bg-white flex flex-col hover:shadow-full whr-product-content pb-2 xl:pb-0 xl:min-h-[260px]">
                                    <div class="py-2 h-[130px] xl:h-[180px]">
                                    <img src="${product.product_image}" class="w-full h-full" alt="image">
                                    </div>
                                    <div class="px-2 mt-2">
                                    <p class="text-[13px] xl:text-sm flash-sale-product-title">${product.product_name}</p>
                                    <div class="product-price-sale text-[12px] xl:text-sm">
                                        <p class="text-orange-500">
                                        ${
                                            product.f_discount_pice > 0
                                                ? new Intl.NumberFormat('vi').format(product.price - (product.price * product.f_discount_pice) / 100)
                                                : new Intl.NumberFormat('vi').format(product.price - (product.price * product.discount_price) / 100)
                                        }
                                        <u class="text-orange-500 ms-1">đ</u>
                                        </p>
                                        <div class="flex justify-between items-center">
                                        <p class="flash-sale-product-price-sale ${
                                            product.discount_price > 0 || product.f_discount_pice > 0 ? '' : 'hidden'
                                        }"><s class="opacity-50">đ${new Intl.NumberFormat('vi').format(product.price)}</s>
                                            <span class="text-white ms-1 bg-red-600 rounded-sm px-1 text-[9px] xl:text-[11px]">-${
                                                product.f_discount_price > 0
                                                    ? new Intl.NumberFormat('vi').format(product.f_discount_price)
                                                    : new Intl.NumberFormat('vi').format(product.discount_price)
                                            }</span>
                                        </p>
                                        <div class="hidden xl:block">
                                            <img src="https://res.cloudinary.com/whr-clound/image/upload/v1745417547/xumhjzw0igzdwwgosq1k.svg" alt="icon_fs" class="px-1 w-[40px] h-[auto] xl:w-[70px] ${
                                                product.f_quantity > 0 ? '' : 'hidden'
                                            }">
                                        </div>
                                        </div>
                                    </div>
                                    </div>
                                </div>
                            </a>
                        `);
                        });
                    } else {
                        btn.addClass('poiter-events-none opacity-50');
                    }
                }
            },
        });
    });

    // Tìm theo filter
    const urlActive = window.location.pathname.split('/', 3)[2];
    if (urlActive == 'product' || urlActive == 'category') {
        innitProductFilter();
    }

    function innitProductFilter() {
        //
        var urlParams = new URLSearchParams(window.location.search);

        // Xử lí nếu value url rỗng
        function getParamValue(param) {
            var value = urlParams.get(param);
            return value ? value : ''; // Giải mã URL nếu có ký tự đặc biệt
        }
        // Lấy từng giá trị từ URL
        var search = getParamValue('search');
        var [from, to] = getParamValue('price').split('-');
        var supplier = getParamValue('supplier');
        var brand = getParamValue('brand');
        var color = getParamValue('color');
        var category = $('.category-checked').data('id');

        var selectedFilters = {
            search: search,
            price: {
                from: from,
                to: typeof to === 'undefined' ? '' : to,
            },
            supplier: supplier,
            brand: brand,
            color: color,
            category: category ? category : 0,
        };
        // Gọi ajax lấy sản phẩm (chỉ khi có tham số filter)
        if ((from && from !== '') || (to && to !== '') || (supplier && supplier !== '') || (brand && brand !== '') || (color && color !== '')) {
            fetchProductFilter(selectedFilters);
        }
        // console.log(selectedFilters);

        // Xử lí check khi reload lại trang
        if (from && to) {
            $(`.filter[data-from="${selectedFilters.price.from}"][data-to="${selectedFilters.price.to}"]`).removeClass('price-unchecked').addClass('price-checked');
        }

        if (supplier) {
            $(`#supplier-m-${selectedFilters.supplier}`).removeClass('supplier-unchecked').addClass('supplier-checked');
        }

        if (brand) {
            $(`#brand-m-${selectedFilters.brand}`).removeClass('brand-unchecked').addClass('brand-checked');
        }

        if (color) {
            $(`a[data-value="${selectedFilters.color}"]`).removeClass('color-unchecked').addClass('color-checked');
        }

        // Click vào filter
        $('.filter').click(function () {
            var $this = $(this);
            var filterType = '';

            if ($this.hasClass('price-unchecked') || $this.hasClass('price-checked')) {
                filterType = 'price';
            } else if ($this.hasClass('supplier-unchecked') || $this.hasClass('supplier-checked')) {
                filterType = 'supplier';
            } else if ($this.hasClass('brand-unchecked') || $this.hasClass('brand-checked')) {
                filterType = 'brand';
            } else if ($this.hasClass('color-unchecked') || $this.hasClass('color-checked')) {
                filterType = 'color';
            }

            if (filterType) {
                $(`.${filterType}-checked`).not($this).removeClass(`${filterType}-checked`).addClass(`${filterType}-unchecked`);
            }

            $this.toggleClass(`${filterType}-checked`).toggleClass(`${filterType}-unchecked`);

            // Cập nhật giá trị bộ lọc
            selectedFilters.price = $('.price-checked').data() || {
                from: '',
                to: '',
            };
            selectedFilters.supplier = $('.supplier-checked').data('id') || '';
            selectedFilters.brand = $('.brand-checked').data('id') || '';
            selectedFilters.color = $('.color-checked').data('value') || '';

            // Cập nhật url
            if (selectedFilters.price.from || selectedFilters.price.to) {
                urlParams.set('price', selectedFilters.price.from + '-' + selectedFilters.price.to);
            } else {
                urlParams.delete('price');
            }

            if (selectedFilters.supplier) {
                urlParams.set('supplier', selectedFilters.supplier);
            } else {
                urlParams.delete('supplier');
            }

            if (selectedFilters.brand) {
                urlParams.set('brand', selectedFilters.brand);
            } else {
                urlParams.delete('brand');
            }

            if (selectedFilters.color) {
                urlParams.set('color', selectedFilters.color);
            } else {
                urlParams.delete('color');
            }

            window.history.pushState({}, '', `${window.location.pathname}?${urlParams.toString()}`);

            // Gọi ajax lấy sản phẩm (chỉ khi có tham số filter)
            if (search != '' || from != '' || to != '' || supplier != '' || brand != '' || color != '') {
                fetchProductFilter(selectedFilters);
            }
            console.log(selectedFilters);
        });

        // gọi Ajax tìm theo filter
        function fetchProductFilter(data) {
            JsLoadingOverlay.show();
            setTimeout(() => {
                $.ajax({
                    type: 'GET',
                    url: URL_GET_PRODUCT_FILTER,
                    data: data,
                    dataType: 'json',
                    success: function (response) {
                        if (response.success == 1) {
                            $('.whr-product').html('');
                            $('.whr-product').removeClass('aa').addClass('grid xl:grid-cols-5');
                            response.products.forEach((product) => {
                                $('.whr-product').append(`
                                <a href="${response.url}/product/${createSlug(product.product_name)}-${product.id}" class="">
                                <div class="bg-white flex flex-col hover:shadow-md hover:rounded-sm whr-product-content pb-2 xl:pb-0 xl:min-h-[260px]">
                                    <div class="py-2 h-[130px] xl:h-[180px]">
                                    <img src="${product.product_image}" class="w-full h-full" alt="image">
                                    </div>
                                    <div class="px-2 mt-2">
                                    <p class="text-[13px] xl:text-sm flash-sale-product-title">${product.product_name}</p>
                                    <div class="product-price-sale text-[12px] xl:text-sm">
                                        <p class="text-orange-500">
                                        ${
                                            product.f_discount_pice > 0
                                                ? new Intl.NumberFormat('vi').format(product.price - (product.price * product.f_discount_pice) / 100)
                                                : new Intl.NumberFormat('vi').format(product.price - (product.price * product.discount_price) / 100)
                                        }
                                        <u class="text-orange-500 ms-1">đ</u>
                                        </p>
                                        <div class="flex justify-between items-center">
                                        <p class="flash-sale-product-price-sale ${
                                            product.discount_price > 0 || product.f_discount_pice > 0 ? '' : 'hidden'
                                        }"><s class="opacity-50">đ${new Intl.NumberFormat('vi').format(product.price)}</s>
                                            <span class="text-white ms-1 bg-red-600 rounded-sm px-1 text-[9px] xl:text-[11px]">-${
                                                product.f_discount_price > 0
                                                    ? new Intl.NumberFormat('vi').format(product.f_discount_price)
                                                    : new Intl.NumberFormat('vi').format(product.discount_price)
                                            }%</span>
                                        </p>
                                        <div class="hidden xl:block">
                                            <img src="https://res.cloudinary.com/whr-clound/image/upload/v1745417547/xumhjzw0igzdwwgosq1k.svg" alt="icon_fs" class="px-1 w-[40px] h-[auto] xl:w-[70px] ${
                                                product.f_quantity > 0 ? '' : 'hidden'
                                            }">
                                        </div>
                                        </div>
                                    </div>
                                    </div>
                                </div>
                            </a>
                              `);
                            });
                        } else if (response.success == 0) {
                            $('.whr-product').html('');
                            $('.whr-product').addClass('aa').removeClass('grid xl:grid-cols-5');
                            $('.whr-product').append(`
                            <div class="flex flex-col justify-center bg-white h-auto mt-2 rounded-md py-3 mb-3 xl:mb-0 xl:py-6">
                                <div class="text-center">
                                    <p class="text-[15px] xl:text-xl text-red-400">Không có sản phẩm.</p>
                                </div>
                                <div class="flex flex-col justify-center text-center xl:mt-2">
                                    <p class="text-[12px] xl:text-sm text-gray-500">Quay lại mua sắm</p>
                                    <div class="text-center mt-2 text-[12px] xl:text-sm">
                                    <button type="button" class="bg-orange-400 rounded-md text-white px-4 py-1 xl:px-7 xl:py-2"><a href="<?php echo BASE_URL . '/product' ?>" class="w-full">Go to Shopping</a></button>
                                    </div>
                                </div>
                            </div>
                          `);
                        }
                        JsLoadingOverlay.hide();
                        $('html, body').animate(
                            {
                                scrollTop: $('.whr-product').offset().top - 100, // căn lề đẹp hơn
                            },
                            400
                        );
                        $('.product-count').text(response.products.length);
                        $('#loadMore-product').addClass('hidden');
                    },
                });
            }, 500);
        }
    }

    // =======================================
    $('#filter_on_off').click(function () {
        $('#sidebar_product').toggleClass('block hidden');
    });
    // Tạo slug
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
