![enter image description here](https://res.cloudinary.com/whr-clound/image/upload/v1745418221/aqvjbcnbygopdofawxbx.jpg)

## Giới thiệu về dự án

Link demo: [https://wildhorizonbs.shoplands.store/](https://wildhorizonbs.shoplands.store/)

-   Mô tả dự án
    -   Dự án xây dựng hệ thống bán sách gồm có giao diện khách hàng và giao diện dành cho admin bằng ngôn ngữ php.
-   Các chức năng chính
    -   khách hàng
        -   Đăng nhập, đăng ký
        -   Xem sản phẩm, thêm vào giỏ hàng
        -   Đặt hàng, thanh toán
        -   Xem lại lịch sử đặt hàng
        -   Chỉnh sửa thông tin cá nhân
    -   Admin
        -   Quản lí sản phẩm
        -   Quản lí danh mục
        -   Quản lí đơn hàng
        -   Quản lí thuộc tính sản phẩm
        -   Quản lí đánh giá người dùng,...

# Khởi chạy dự án

Để chạy được dự án cần chuẩn bị trước:

-   Xampp: [https://www.apachefriends.org/download.html](https://www.apachefriends.org/download.html)
-   Nodejs: [https://nodejs.org/en/download](https://nodejs.org/en/download)
-   Composer: [https://getcomposer.org/](https://getcomposer.org/)
-   Công cụ hỗ trợ code: vscode,...

## Thiết lập dự án

-   Tải thư mục dự án về, đưa vào foder htdocs của xampp, giải nén và đổi tên thư mục thành WildHorizon-BookShop
-   Chạy xampp, mở phpmyadmin, tạo database tên whr_bookshop, sau đó import csdl vào
-   Mở vscode trỏ vào thư mục dự án chạy các lệnh
    -   `npm install`
    -   `composer install`

## Tạo file config

Trong thư mục dự án tạo một foder tên Config và tạo file tên config.php
Copy nội dung bên dưới vào file

      <?php
      define('BASE_PATH', dirname($_SERVER['SCRIPT_NAME']));
      define('BASE_URL', rtrim((isset($_SERVER['HTTPS']) ? 'https' : 'http') .  '://'  .  $_SERVER['HTTP_HOST'] . BASE_PATH, '/'));
      define('VIEW_PATH', $_SERVER['DOCUMENT_ROOT'] .  '/WildHorizon-BookShop/views/');
      define('VIEW_PATH_USER_LAYOUT', $_SERVER['DOCUMENT_ROOT'] .  '/WildHorizon-BookShop/views/user/layout/');
      define('BASE_URL_NAME', '/WildHorizon-BookShop');
      // database
      define("DB_HOST", 'localhost');
      define("DB_USER", 'root');
      define("DB_PASS", '');
      define("DB_NAME", 'whr_bookshop');
      define('UPLOAD_DIR', $_SERVER['DOCUMENT_ROOT'] .  '/WildHorizon-BookShop/Public/upload/');
      define('KEY', 'wildhorizonbookshopwiburomax');
      define('OTP_HASH_KEY', 'wildhorizon@@');
      define('PAYMENT_KEY', 'wildhorizonpaymentVNPAY');
      define('SERECT_KEY_VNPAY', 'vnpay_serect_key'); //serecr_key vnpay cung cấp
      define('SERECT_APP_VNPAY', 'vnpay_serect_app'); //serect app vnpay cung cấp
      // FB
      define('ID_APP_FB', 'ID_APP');
      define('SERECT_KEY_APP', 'Serect_key_app_fb');
      define('PW_DEFAULT', 'NQH@@123@@zz456@@');

-   Tích hợp thanh toán vnpay tham khảo thêm: [https://sandbox.vnpayment.vn/apis/docs/thanh-toan-pay/pay.html](https://sandbox.vnpayment.vn/apis/docs/thanh-toan-pay/pay.html)
-   Tích hợp login with fb tham khảo: [https://developers.facebook.com/docs/facebook-login/](https://developers.facebook.com/docs/facebook-login/)
-   Có thể chạy web bình thường

# Các link test

-   Vnpay account test (chỉ có thể test ngân hàng ncb): [https://sandbox.vnpayment.vn/apis/vnpay-demo/](https://sandbox.vnpayment.vn/apis/vnpay-demo/)
-   Account đăng nhập trang web mặc định:
    -   Email: khachhang@gmail.com
    -   pw: 123456
-   Account admin: truy cập trang web với: /dashboard
    -   Email: admin@gmail.com
    -   pw: 123456
