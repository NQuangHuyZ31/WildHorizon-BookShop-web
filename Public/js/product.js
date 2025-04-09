$(document).ready(function () {

  const baseURL = window.location.origin + '/WildHorizon-BookShop';
  let URL_GET_PRODUCT_FILTER = baseURL + '/product/search-filter';

  if (window.location.search) {

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
    var [from, to] = getParamValue("price").split('-');
    var supplier = getParamValue("supplier");
    var brand = getParamValue("brand");
    var color = getParamValue("color");
    var category = $('.category-checked').data('id')

    var selectedFilters = {
      search: search,
      price: {
        from: from,
        to: typeof to === 'undefined' ? '' : to
      },
      supplier: supplier,
      brand: brand,
      color: color,
      category: category ? category : 0
    };

    // Xử lí check khi reload lại trang
    if (from && to) {
      $(`.filter[data-from="${selectedFilters.price.from}"][data-to="${selectedFilters.price.to}"]`).removeClass('price-unchecked').addClass('price-checked')
    }

    if (supplier) {
      $(`#supplier-m-${selectedFilters.supplier}`).removeClass('supplier-unchecked').addClass('supplier-checked')
    }

    if (brand) {
      $(`#brand-m-${selectedFilters.brand}`).removeClass('brand-unchecked').addClass('brand-checked')
    }

    if (color) {
      $(`a[data-value="${selectedFilters.color}"]`).removeClass('color-unchecked').addClass('color-checked')
    }

    // Gọi ajax lấy sản phẩm
    fetchProductFilter(selectedFilters)

    console.log(selectedFilters)

    $(".filter").click(function () {
      var $this = $(this);
      var filterType = "";

      if ($this.hasClass("price-unchecked") || $this.hasClass("price-checked")) {
        filterType = "price";
      } else if ($this.hasClass("supplier-unchecked") || $this.hasClass("supplier-checked")) {
        filterType = "supplier";
      } else if ($this.hasClass("brand-unchecked") || $this.hasClass("brand-checked")) {
        filterType = "brand";
      } else if ($this.hasClass("color-unchecked") || $this.hasClass("color-checked")) {
        filterType = "color";
      }

      if (filterType) {
        $(`.${filterType}-checked`).not($this).removeClass(`${filterType}-checked`).addClass(`${filterType}-unchecked`);
      }

      $this.toggleClass(`${filterType}-checked`).toggleClass(`${filterType}-unchecked`);

      // Cập nhật giá trị bộ lọc
      selectedFilters.price = $(".price-checked").data() || { from: "", to: "" };
      selectedFilters.supplier = $(".supplier-checked").data("id") || "";
      selectedFilters.brand = $(".brand-checked").data("id") || "";
      selectedFilters.color = $(".color-checked").data("value") || "";

      console.log('new filter', selectedFilters)
      fetchProductFilter(selectedFilters);
      // Cập nhật url
      if (selectedFilters.price.from || selectedFilters.price.to) {
        urlParams.set("price", selectedFilters.price.from + "-" + selectedFilters.price.to);
      } else {
        urlParams.delete('price')
      }

      if (selectedFilters.supplier) {
        urlParams.set("supplier", selectedFilters.supplier);
      } else {
        urlParams.delete('supplier')
      }

      if (selectedFilters.brand) {
        urlParams.set("brand", selectedFilters.brand);
      } else {
        urlParams.delete('brand')
      }

      if (selectedFilters.color) {
        urlParams.set("color", selectedFilters.color);
      } else {
        urlParams.delete('color')
      }

      window.history.pushState({}, "", `${window.location.pathname}?${urlParams.toString()}`);
      console.log(selectedFilters)
    })

    // gọi Ajax tìm theo filter
    function fetchProductFilter(data) {
      $.ajax({
        type: "GET",
        url: URL_GET_PRODUCT_FILTER,
        data: data,
        dataType: "json",
        success: function (response) {
          if (response.success == 1) {
            if (response.product_count > 0) {
              $('.whr-product').html('');
              $('.whr-product').removeClass('grid-cols-1').addClass('grid-cols-4')
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
                            ${product.f_quantity > 0 ? new Intl.NumberFormat('vi').format(product.price - (product.price * product.f_discount_price / 100)) : new Intl.NumberFormat('vi').format(product.price - (product.price * product.discount_price / 100))}
                            <u class="text-orange-500 ms-1">đ</u>
                          </p>
                          <div class="flex justify-between items-center">
                            <p class="flash-sale-product-price-sale ${product.f_quantity > 0 || product.discount_price > 0 ? '' : 'hidden'}"><s class="opacity-50">đ${new Intl.NumberFormat('vi').format(product.price)}</s>
                              <span class="text-white ms-2 bg-red-600 rounded-sm px-1">-${product.f_quantity > 0 ? new Intl.NumberFormat('vi').format(product.f_discount_price) : new Intl.NumberFormat('vi').format(product.discount_price)}%</span>
                            </p>
                            <img src="/WildHorizon-BookShop/Public/images/icon/label-flashsale.svg" alt="icon_fs" width="70" height="40" class="mr-2 ${product.f_quantity > 0 ? '' : 'hidden'}">
                          </div>
                        </div>
                       ${product.f_quantity > 0 ?
                    `<div class="flex justify-end px-1">
                            <p class="text-gray-400" style="font-size: 11px;">còn ${product.f_quantity} sản phẩm</p>
                          </div>`
                    : ''}
                      </div>
                    </div>
                  </a>
                `)
              })
            } else {
              $('.whr-product').html('');
              $('.whr-product').addClass('grid-cols-1').removeClass('grid-cols-4')
              $('.whr-product').append(`
                 <div class="text-center mt-4">
                    <p class="text-2xl text-red-400">Không có sản phẩm.</p>
                  </div>
                  <div class="flex flex-col justify-center text-center mt-4">
                    <p class="text-sm text-gray-500">Quay lại mua sắm</p>
                    <div class="text-center mt-2">
                      <button type="button" class="bg-orange-400 rounded-sm text-white" style="width: 240px;height: 50px;"><a href="/WildHorizon-BookShop/product" class="w-full">Go to Shopping</a></button>
                    </div>
                  </div>
              `);
            }

            $('html, body').animate({
              scrollTop: $('.whr-product').offset().top - 100 // căn lề đẹp hơn
            }, 400);
            $('.product-count').text(response.products.length)
            $('#loadMore-product').addClass('hidden')
          } else {
            console.log('Đang ở trang chính')
          }
        }
      });
    }
  }

  // Tạo slug
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