$(document).ready(function () {

  // check từng sản phẩm
  $('.cart-item-checkbox').on('click', function (e) {

    var item = $(this);
    var checkbox = item.find('.cart-input-checkbox');

    // Đảo trạng thái của checkbox input
    checkbox.prop('checked', !checkbox.prop('checked'));

    // Cập nhật giao diện dựa trên trạng thái mới của checkbox
    item.toggleClass('bg-orange-500', checkbox.prop('checked'));
    item.find('.cart-icon-checkbox').toggleClass('opacity-0', !checkbox.prop('checked'));

    updatePrice()
  });

  function updatePrice() {
    var data = [];
    $('.cart-input-checkbox:checked').each(function () {
      quantity = parseInt($(this).closest('.cart-product-item').find('.cart-product-quantity').val())
      productID = parseInt($(this).closest('.cart-product-item').find('.cart-product-quantity').data('productid'))

      data.push({ productID, quantity });
    })

    $.ajax({
      type: "post",
      url: "/WildHorizon-BookShop/updatepricecart",
      data:
        { data: data },
      dataType: "json",
      success: function (response) {
        $('#cart-subtotal').text(response.totalprice);
        $('#cart-saved').text(response.saveprice);
        $('#cart-total').text(response.total);
        if (response.success == 0) {
          $('#cart-checkout').removeClass('bg-orange-500').addClass('bg-gray-300 pointer-event-none');
        } else {
          $('#cart-checkout').addClass('bg-orange-500').removeClass('bg-gray-300 pointer-event-none');
        }
      }
    });
  }

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
    e.preventDefault()

    const item = $(this).closest('.cart-product-item');
    const quantityInput = item.find('.cart-product-quantity');
    const decButton = $(this);
    const currentValue = parseInt(quantityInput.val(), 10);
    const productID = item.find('.cart-product-quantity').data('productid');
    item.find('.inc-quantity').removeClass('pointer-events-none')
    if (currentValue > 1) {

      const newValue = currentValue - 1;
      quantityInput.val(newValue);
      updatePrice();
      checkQuantityCart(newValue,productID,$(this))
      // Vô hiệu hóa nút giảm nếu giá trị giảm về 1
      if (newValue === 1) {

        decButton.addClass('pointer-events-none');
      }
    }
  });

  // // Xử lý khi nhấn nút tăng số lượng
  $('.inc-quantity').click(function (e) {
    e.preventDefault()
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
    checkQuantityCart(newValue, productID, $(this))
    updatePrice();
    // Kích hoạt lại nút giảm nếu giá trị vượt 1
    if (newValue > 1) {
      decButton.removeClass('pointer-events-none');
    }
  });

  // check quantity cart
  function checkQuantityCart(quantity, productID, btn) {
    $.ajax({
      type: "post",
      url: "/WildHorizon-BookShop/checkquantitycart",
      data: {
        quantity: quantity,
        productID: productID
      },
      dataType: "json",
      success: function (response) {
        if (response.success == 1) {
          toastr.error(response.message);
          btn.addClass('pointer-events-none');
          btn.closest('.cart-product-item').find('.cart-product-quantity').val(response.quantity);
          console.log(btn.closest('.cart-product-item').find('.cart-product-quantity').val())
        }
      }
    });
  }

  // Update quantity
  // function updateQuantity(quantity, productID) {
  //   $.ajax({
  //     type: "post",
  //     url: "/WildHorizon-BookShop/updatequantity",
  //     data: {
  //       quantity: quantity,
  //       productID: productID
  //     },
  //     dataType: "json",
  //     success: function (response) {

  //     }
  //   });
  // }
});