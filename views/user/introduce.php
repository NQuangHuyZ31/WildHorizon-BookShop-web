<?php include_once VIEW_PATH_USER_LAYOUT . 'header.php'; ?>
<div class="w-full xl:container mt-3 px-2 xl:px-0">
  <div class="w-full xl:max-w-screen-xl xl:mx-auto min-h-[500px] bg-white rounded-md">
    <div class="p-4">
      <div class="flex items-center justify-center w-full">
        <img src="https://res.cloudinary.com/whr-clound/image/upload/v1747215942/zygzvqgbmarudnizljdj.png" alt="logo" class="w-1/2 h-auto">
      </div>
      <div class="flex flex-col items-center justify-center mt-3 border-b border-gray-200">
        <div class="text-lg xl:text-xl uppercase font-bold py-1">
          <p>Project môn công nghệ mới - Chuyên ngành hệ thống thông tin</p>
        </div>
        <div class="flex flex-col items-center justify-center text-sm xl:text-lg font-semibold py-1">
          <p>Thành viên tham gia</p>
          <div class="overflow-x-auto rounded-box border border-base-content/5 bg-base-100 mt-3 bg-white">
            <table class="table font-normal text-[12px] xl:text-sm">
              <!-- head -->
              <thead>
                <tr>
                  <th></th>
                  <th class="align-middle text-center text-black">Tên</th>
                  <th class="align-middle text-center text-black">Công việc tham gia</th>
                </tr>
              </thead>
              <tbody>
                <!-- row 1 -->
                <tr>
                  <th>1</th>
                  <td>Nguyễn Quang Huy</td>
                  <td>Phân tích yêu cầu, thiết kế hệ thống, lập trình chức năng</td>
                </tr>
                <!-- row 2 -->
                <tr>
                  <th>2</th>
                  <td>Nguyễn Xuân Dương</td>
                  <td>Phân tích yêu cầu, thiết kế hệ thống, lập trình chức năng</td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
      <div class="mt-3">
        <div class="ps-2">
          <p class="font-semibold text-sm xl:text-lg">1. Các giai đoạn dự án</p>
          <div class="mt-2 ps-2">
            <div class="text-[12px] xl:text-sm flex flex-col gap-2">
              <p class="font-semibold">Giai đoạn 1</p>
              <p class="ps-2">Phân tích yêu câu: bao gồm yêu cầu chức năng, yêu cầu phi chức năng, yêu cầu nghiệp vụ.</p>
            </div>
          </div>
          <div class="mt-2 ps-2">
            <div class="text-[12px] xl:text-sm flex flex-col gap-2">
              <p class="font-semibold">Giai đoạn 2</p>
              <p class="ps-2">Thiết kế hệ thống: bao gồm vẽ sơ đồ usecase, sơ đồ activity, csdl.</p>
            </div>
          </div>
          <div class="mt-2 ps-2">
            <div class="text-[12px] xl:text-sm flex flex-col gap-2">
              <p class="font-semibold">Giai đoạn 3</p>
              <p class="ps-2">Lập trình: xây dựng chức năng, giao diện.</p>
            </div>
          </div>
          <div class="mt-2 ps-2">
            <div class="text-[12px] xl:text-sm flex flex-col gap-2">
              <p class="font-semibold">Giai đoạn 4</p>
              <p class="ps-2">Kiểm thử: Viết testcase, manual-test.</p>
            </div>
          </div>
        </div>
      </div>
      <div class="mt-3">
        <div class="ps-2">
          <p class="font-semibold text-sm xl:text-lg">2. Các chức năng chính</p>
          <div class="mt-2 ps-2">
            <div class="text-[12px] xl:text-sm flex flex-col gap-2">
              <p class="font-semibold">Khách hàng</p>
              <ul class="ps-2">
                <li class="py-1">Đăng kí</li>
                <li class="py-1">Đăng nhập (fb, gg)</li>
                <li class="py-1">Đăng xuất</li>
                <li class="py-1">Tìm kiếm sản phẩm</li>
                <li class="py-1">Xem sản phẩm</li>
                <li class="py-1">Thêm vào giỏ hàng</li>
                <li class="py-1">Đặt hàng</li>
                <li class="py-1">Thanh toán (có tích hợp vnpay)</li>
                <li class="py-1">
                  Quản lí tài khoản
                  <ul class="ps-4">
                    <li class="py-1">Chỉnh sửa thông tin cá nhân</li>
                    <li class="py-1">Quản lí địa chỉ</li>
                    <li class="py-1">Thay đổi mật khẩu</li>
                    <li class="py-1">Xem lịch sử đặt hàng</li>
                    <li class="py-1">Xem chi tiết đơn hàng đã đặt,...</li>
                  </ul>
                </li>
                <li>Gửi góp ý</li>
              </ul>
            </div>
            <div class="text-[12px] xl:text-sm flex flex-col gap-2">
              <p class="font-semibold">Admin</p>
              <ul class="ps-2">
                <li class="py-1">Đăng nhập</li>
                <li class="py-1">Quản lí sản phẩm</li>
                <li class="py-1">Quản lí danh mục</li>
                <li class="py-1">Quản lí đơn hàng</li>
                <li class="py-1">Quản lí nhà cung cấp</li>
                <li class="py-1">Xem và trả lời góp ý người dùng</li>
                <li class="py-1">..................</li>
              </ul>
            </div>
          </div>
        </div>
      </div>
      <div class="mt-3">
        <div class="ps-2">
          <p class="font-semibold text-sm xl:text-lg">1. Các giai đoạn dự án</p>
          <div class="mt-2 ps-2">
            <div class="text-[12px] xl:text-sm flex flex-col gap-2">
              <p class="font-semibold">Giai đoạn 1</p>
              <p class="ps-2">Phân tích yêu câu: bao gồm yêu cầu chức năng, yêu cầu phi chức năng, yêu cầu nghiệp vụ.</p>
            </div>
          </div>
          <div class="mt-2 ps-2">
            <div class="text-[12px] xl:text-sm flex flex-col gap-2">
              <p class="font-semibold">Giai đoạn 2</p>
              <p class="ps-2">Thiết kế hệ thống: bao gồm vẽ sơ đồ usecase, sơ đồ activity, csdl.</p>
            </div>
          </div>
          <div class="mt-2 ps-2">
            <div class="text-[12px] xl:text-sm flex flex-col gap-2">
              <p class="font-semibold">Giai đoạn 3</p>
              <p class="ps-2">Lập trình: xây dựng chức năng, giao diện.</p>
            </div>
          </div>
          <div class="mt-2 ps-2">
            <div class="text-[12px] xl:text-sm flex flex-col gap-2">
              <p class="font-semibold">Giai đoạn 4</p>
              <p class="ps-2">Kiểm thử: Viết testcase, manual-test.</p>
            </div>
          </div>
        </div>
      </div>
      <div class="mt-3">
        <div class="ps-2 mt-2">
          <p class="font-semibold text-sm xl:text-lg">3. Nghiên cứu bảo mật web</p>
          <div class="mt-2 ps-2">
            <div class="text-[12px] xl:text-sm flex flex-col gap-2">
              <p class="font-semibold">Bảo mật web bằng HTTPS</p>
              <p class="ps-2">Sử dụng chứng chỉ SSL: SSL (Secure Sockets Layer) là chứng chỉ giúp mã hóa dữ liệu truyền giữa trình duyệt và máy chủ, tránh bị đánh cắp. Khi website có SSL, URL sẽ là https://</p>
            </div>
          </div>
        </div>
        <div class="ps-2 mt-2">
          <div class="ms-2">
            <div class="text-[12px] xl:text-sm flex flex-col gap-2">
              <p class="font-semibold">Chống tấn công CSRF</p>
              <p class="ps-2">CSRF ( Cross Site Request Forgery) là kỹ thuật tấn công bằng cách sử dụng quyền chứng thực của người dùng đối với một website. CSRF là kỹ thuật tấn công vào người dùng, dựa vào đó hacker có thể thực thi những thao tác phải yêu cầu sự chứng thực</p>
              <p>Mục tiêu tấn công:
              <ul class="ms-4">
                <li>Chuyển tiền</li>
                <li>Thay đổi mật khẩu</li>
                <li>Xóa dữ liệu</li>
                <li>Thay đổi email, cấu hình tài khoản</li>
              </ul>
              </p>
              <p>Biện pháp: sử dụng token, xác thực mỗi khi gửi dữ liệu
              <ul class="ps-4">
                <li>Tạo token và lưu vào session</li>
                <li>Chèn token vào form và gửi kèm</li>
                <li>Xác thực csrf token được gửi đi</li>
              </ul>
              </p>
            </div>
          </div>
        </div>
        <div class="ps-2 mt-2">
          <div class="ms-2">
            <div class="text-[12px] xl:text-sm flex flex-col gap-2">
              <p class="font-semibold">Mã hóa dữ liệu</p>
              <p class="ps-2">Mã hóa mật khẩu khi đăng ký, mật khóa dữ liệu thanh toán</p>
            </div>
          </div>
        </div>
        <div class="ps-2 mt-2">
          <div class="ms-2">
            <div class="text-[12px] xl:text-sm flex flex-col gap-2">
              <p class="font-semibold">SQL Injection</p>
              <p class="ps-2">SQL injection (SQLi) là một lỗ hổng bảo mật web cho phép kẻ tấn công can thiệp vào các truy vấn mà ứng dụng thực hiện đối với cơ sở dữ liệu của ứng dụng. Điều này có thể cho phép kẻ tấn công xem dữ liệu mà thông thường chúng không thể truy xuất được</p>
              <p class="ps-2">Ví dụ: url http://localhost/WildHorizon-BookShop/product?search=nam</p>
              <p class="ps-2">=> Câu lệnh truy vấn sẽ là: Select *from products where name like '%nam%'</p>
              <p class="ps-2">Tấn công SQl Injection: truyền url: http://localhost/WildHorizon-BookShop/product?search=' OR 1=1 --</p>
              <p class="ps-2">=> Câu lệnh sẽ là: SELECT * FROM products WHERE name LIKE '%' OR 1=1 -- %' => Lấy toàn bộ dữ liệu</p>
              <p class="ps-2">Biện pháp khắc phục: <span class="text-black">Sử dụng PDO - prepared statements</span></p>
            </div>
          </div>
        </div>
        <div class="ps-2 mt-2">
          <div class="ms-2">
            <div class="text-[12px] xl:text-sm flex flex-col gap-2">
              <p class="font-semibold">Kiểm tra dữ liệu đầu vào</p>
              <p class="ps-2">Tất cả dữ liệu được gửi qua đều nên được kiểm tra trước khi thực thi, có thể sử dụng regex hoặc các hàm có sẵn để kiểm tra dữ liệu</p>
            </div>
          </div>
        </div>
        <div class="ps-2 mt-2">
          <div class="ms-2">
            <div class="text-[12px] xl:text-sm flex flex-col gap-2">
              <p class="font-semibold">Bảo mật tệp được tải lên</p>
              <p class="ps-2">Kiểm tra tệp được tải lên bằng cách: kiểm tra phần mở rộng file không cho phép file .php, .exe, ..., giới hạn kích thước tệp tải lên, Đổi tên file ngẫu nhiên</p>
            </div>
          </div>
        </div>
        <div class="ps-2 mt-2">
          <div class="ms-2">
            <div class="text-[12px] xl:text-sm flex flex-col gap-2">
              <p class="font-semibold">Xác thực 2 yếu tố (2FA)</p>
              <p class="ps-2">Sử dụng mã được gửi qua email để xác thực khi thực hiện đăng kí tài khoản hoặc thay đổi mật khẩu, giới hạn thời gian sử dụng mã</p>
            </div>
          </div>
        </div>
        <div class="ps-2 mt-2">
          <div class="ms-2">
            <div class="text-[12px] xl:text-sm flex flex-col gap-2">
              <p class="font-semibold">Cấu hình session an toàn</p>
            </div>
          </div>
        </div>
        <div class="ps-2 mt-2">
          <div class="ms-2">
            <div class="text-[12px] xl:text-sm flex flex-col gap-2">
              <p class="font-semibold">Phân quyền truy cập người dùng</p>
              <p>Phân quyền truy cập cho tài khoản khách hàng và quản trị, chỉ cho phép người dùng thay đổi thông tin của mình</p>
            </div>
          </div>
        </div>
      </div>
      <div class="mt-3">
        <div class="ps-2 mt-2">
          <p class="font-semibold text-sm xl:text-lg">4. Tài liệu hỗ trợ</p>
          <div class="ms-2 text-[12px] xl:text-sm flex flex-col gap-2">
            <p>1. Đăng nhập với facebook: <a href="https://developers.facebook.com/docs/facebook-login" class="text-blue-500">https://developers.facebook.com/docs/facebook-login</a></p>
            <p>2. Đăng nhập với google: <a href="https://developers.google.com/identity/sign-in/web/sign-in?hl=vi" class="text-blue-500">https://developers.google.com/identity/sign-in/web/sign-in?hl=vi</a></p>
            <p>3. Tích hợp thanh toán vnpay: <a href="https://sandbox.vnpayment.vn/apis/docs/thanh-toan-pay/pay.html" class="text-blue-500">https://sandbox.vnpayment.vn/apis/docs/thanh-toan-pay/pay.html</a></p>
            <p>4. Tài khoản test thanh toán: <a href="https://sandbox.vnpayment.vn/apis/vnpay-demo/" class="text-blue-500">https://sandbox.vnpayment.vn/apis/vnpay-demo/</a></p>
            <p>5. Nghiên cứu bảo mật: <a href="https://viblo.asia/p/owasp-la-gi-top-10-owasp-2023-bXP4WzZKV7G" class="text-blue-500">https://viblo.asia/p/owasp-la-gi-top-10-owasp-2023-bXP4WzZKV7G</a></p>
            <p>6. Link source code: <a href="https://github.com/NQuangHuyZ31/WildHorizon-BookShop-web" class="text-blue-500">https://github.com/NQuangHuyZ31/WildHorizon-BookShop-web</a></p>
            <p>7. Link demo: <a href="https://wildhorizonbs.shoplands.store/" class="text-blue-500">https://wildhorizonbs.shoplands.store/</a></p>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<?php include_once VIEW_PATH_USER_LAYOUT . 'footer.php'; ?>