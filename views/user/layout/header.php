<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="/CNMoi/public/css/app.css">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Noto+Sans:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="./Public/fontawesome/css/fontawesome.min.css">
  <!-- <link rel="stylesheet" href="./Public/css/bootstrap.min.css"> -->
  <link href="./Public/css/output.css" rel="stylesheet">
  <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css" />
  <title>ABC</title>
</head>

<body style="background-color: #f5f5f5;">
  <?php if (isset($homePage)) { ?>
    <div class=" banner-top w-screen bg-banner-top py-2">
      <div class="flex align-middle relative">
        <img class="mx-auto" src="./Public//images/banners/1fa52232-27a7-427f-93c5-c8ed1cb0e0ca_VN-1188-80.gif_2200x2200q80.gif_.webp" alt="banner-top">
      </div>
      <div class="absolute z-50 cursor-pointer hover:opacity-60" style="top: 15px;right: 10%" id="banner-top-ee">
        <i class="fa-solid fa-xmark text-lg text-white"></i>
      </div>
    </div>
  <?php } ?>
  <div class="container mx-auto">
    <div class="container-fuild mx-auto">
      <ul class="flex justify-around py-1" style="font-size: 12px;margin-left: 200px;">
        <li class=""><a href="#" class="text-blue-900 hover:text-orange-400 uppercase">feedback</a></li>
        <li class=""><a href="#" class="text-blue-900 hover:text-orange-400 uppercase">SAVE MORE ON APP</a></li>
        <li class=""><a href="#" class="text-blue-900 hover:text-orange-400 uppercase">sell on shop</a></li>
        <li class=""><a href="#" class="text-blue-900 hover:text-orange-400 uppercase">CUSTOMER CARE</a></li>
        <li class=""><a href="#" class="text-gray-400 hover:text-orange-400 uppercase">Track my order</a></li>
        <li class=""><a href="#" class="text-gray-400 hover:text-orange-400 uppercase">login</a></li>
        <li class=""><a href="#" class="text-gray-400 hover:text-orange-400 uppercase">signup</a></li>
        <li class=""><a href="#" class="text-gray-400 hover:text-orange-400 uppercase">THAY ĐỔI NGÔN NGỮ</a></li>
    </div>
    <div class="w-full pt-2 bg-white">
      <div class="container-fuild mx-auto flex justify-start items-center ">
        <div>
          <img src="./Public/images/logo.png" alt="">
        </div>
        <div>
          <form action="" class="flex justify-start">
            <input type="text" name="search" id="search">
            <div>
              <i class="fa-solid fa-magnifying-glass"></i>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>