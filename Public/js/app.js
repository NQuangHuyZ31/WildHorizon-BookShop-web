$(document).ready(function () {
  // Ẩn banner top
  $('#banner-top-ee').click(function(){

    $('.banner-top').addClass('hidden');
    // console.log('aaa')

  })
  $('.single-item').slick({
    arrows:true,
    autoplay: true,
    autoplaySpeed: 5000,
    // fade: true,
  });
  // LOGIN
  // SHOW, HIDE PASSWORD
  $('.whr-show-pw-icon').click(function(e){
    e.preventDefault();
    $('#whr-login-password').attr('type','text');
    $(this).addClass('hidden');
    $('.whr-hidden-pw-icon').removeClass('hidden');
  });

  $('.whr-hidden-pw-icon').click(function(e){
    e.preventDefault();
    $('#whr-login-password').attr('type','password');
    $(this).addClass('hidden');
    $('.whr-show-pw-icon').removeClass('hidden');
  });

  // CONFIRM PASSWORD
  $('.whr-show-cfpw-icon').click(function(e){
    e.preventDefault();
    $('#whr-login-cfpassword').attr('type','text');
    $(this).addClass('hidden');
    $('.whr-hidden-cfpw-icon').removeClass('hidden');
  });

  $('.whr-hidden-cfpw-icon').click(function(e){
    e.preventDefault();
    $('#whr-login-cfpassword').attr('type','password');
    $(this).addClass('hidden');
    $('.whr-show-cfpw-icon').removeClass('hidden');
  });

  // CLOSE MODAL IN TRANG CHU
  $('#btn-close-modal').click(function(){
    $('#my_modal_1').removeClass('modal-open');
  })

  // CHANGE BORDER FEEDBACK TEXTAREA
  $('.whr-feedback-textarea-content').focus(function(){
    $('.whr-feedback-textarea').addClass('border-blue-400');
    $('.whr-feedback-textarea').removeClass('border-gray-400');
  })

  $('.whr-feedback-textarea-content').blur(function(){
    $('.whr-feedback-textarea').addClass('border-gray-400');
    $('.whr-feedback-textarea').removeClass('border-blue-400');
  })

  // ACCEPT SEND FEEDBACK
  $('#feedback-content').on('input',function(){
    var value = $(this).val();
    if(value.length > 0){
      $('#btn-feedback').removeClass('pointer-events-none opacity-25');
      $('#feedback-count').text(value.length + '/1000');
    }else{
      $('#btn-feedback').addClass('pointer-events-none opacity-25');
    }
  })

  // CART
  // checkall 
  $('#cart-checkall').click(function(){
    console.log('aaa')

  })
  
});