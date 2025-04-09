$(document).ready(function () {
  let URL_UPDATE_INFO_CUSTOMER = '/WildHorizon-BookShop/customer/account';
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
      type: "POST",
      url: URL_UPDATE_INFO_CUSTOMER,
      data:
      {
        username: username,
        phone: phone,
        gender: gender,
        day: day,
        mounth: mounth,
        year: year,
        csrf_token:csrf_token
      }
      ,
      dataType: "json",
      success: function (response) {
        if(response.success.status == 1){
          toastr['success'](response.success.msg)
        }else{
          toastr['error'](response.success.msg)
        }
        $('input[name="csrf_token"]').val(response.token)
      }
    });
  })
});