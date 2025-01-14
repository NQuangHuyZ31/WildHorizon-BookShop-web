$(document).ready(function () {
  // Check all 
  $('.')
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
  $(document).on('click', '.dec-quantity', function () {
    const item = $(this).closest('.cart-product-item');
    const quantityInput = item.find('.cart-product-quantity');
    const decButton = $(this);
    const currentValue = parseInt(quantityInput.val(), 10);
   
    if (currentValue > 1) {
      const newValue = currentValue - 1;
      quantityInput.val(newValue);
      // Vô hiệu hóa nút giảm nếu giá trị giảm về 1
      if (newValue === 1) {
        decButton.addClass('pointer-events-none');
      }
    }
  });

  // // Xử lý khi nhấn nút tăng số lượng
  $(document).on('click', '.inc-quantity', function () {
    const item = $(this).closest('.cart-product-item');
    const quantityInput = item.find('.cart-product-quantity');
    const decButton = item.find('.dec-quantity');
    const currentValue = parseInt(quantityInput.val(), 10);

    // Tăng giá trị
    const newValue = currentValue + 1;
    quantityInput.val(newValue);

    // Kích hoạt lại nút giảm nếu giá trị vượt 1
    if (newValue > 1) {
      decButton.removeClass('pointer-events-none');
    }
  });
});