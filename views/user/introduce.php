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
          <div class="overflow-x-auto rounded-box border border-base-content/5 bg-base-100 mt-3">
            <table class="table font-normal text-[12px] xl:text-sm">
              <!-- head -->
              <thead>
                <tr>
                  <th></th>
                  <th class="align-middle text-center">Tên</th>
                  <th class="align-middle text-center">Công việc tham gia</th>
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
        <div class="">
          <p class="font-semibold text-sm xl:text-lg">1. Các giai đoạn dự án</p>
          <div class="mt-2 ps-3">
            <div class="text-[12px] xl:text-sm flex flex-col gap-2">
              <p class="font-semibold">Giai đoạn 1</p>
              <p class="ps-2">Phân tích yêu câu: bao gồm yêu cầu chức năng, yêu cầu phi chức năng, yêu cầu nghiệp vụ.</p>
            </div>
          </div>
          <div class="mt-2 ps-3">
            <div class="text-[12px] xl:text-sm flex flex-col gap-2">
              <p class="font-semibold">Giai đoạn 2</p>
              <p class="ps-2">Thiết kế hệ thống: bao gồm vẽ sơ đồ usecase, sơ đồ activity.</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<?php include_once VIEW_PATH_USER_LAYOUT . 'footer.php'; ?>