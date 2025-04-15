$(document).ready(function () {
  // Checkout Form  
  $('#checkout-province').click(() => {

    fetch('https://esgoo.net/api-tinhthanh/1/0.htm')
      .then(function (response) {
        return response.json();
      })
      .then(function (response) {
        response.data.forEach(province => {
          $('#checkout-province').append(
            `<option value="${province.name}" data-id="${province.id}">${province.name}</option>`
          );
        });
      })
      .catch(function (err) {
        console.log(err);
      })
  })

  $('#checkout-province').change(() => {
    const selectedOption = $('#checkout-province option:selected');
    const dataID = selectedOption.attr('data-id');

    fetch('https://esgoo.net/api-tinhthanh/2/' + dataID + '.htm')
      .then(function (response) {
        return response.json();
      })
      .then(function (response) {
        $("#checkout-district").html('<option value="">Chọn quận/huyện</option>');
        $("#checkout-ward").html('<option value="">Chọn phường xã</option>');
        response.data.forEach(district => {
          $('#checkout-district').append(
            `<option value="${district.name}" data-id="${district.id}">${district.name}</option>`
          );
        });
      })
    $('#checkout-district').removeAttr('disabled')
  })

  $('#checkout-district').change(() => {
    const selectedOption = $('#checkout-district option:selected');
    const dataID = selectedOption.attr('data-id');
    const val = $('#checkout-ward').val('');

    fetch('https://esgoo.net/api-tinhthanh/3/' + dataID + '.htm')
      .then(function (response) {
        return response.json();
      })
      .then(function (response) {
        $("#checkout-ward").html('<option value="">Chọn phường xã</option>');
        response.data.forEach(ward => {
          $('#checkout-ward').append(
            `<option value="${ward.name}" data-id="${ward.id}">${ward.name}</option>`
          );
        });
      })

    $('#checkout-ward').removeAttr('disabled')
  })

  // Change fee shipping
  $('.shipping-fee').change(()=>{
    var shipCost = parseInt($('input[name="shipping-fee"]:checked').val())
    var totalPrice = parseInt($('.total-price').data('total'))
    
    $('.shipping-cost').text(new Intl.NumberFormat('vi').format(shipCost) + 'đ')
    $('.total-price').text(new Intl.NumberFormat('vi').format(totalPrice + shipCost) + 'đ')
  })
});