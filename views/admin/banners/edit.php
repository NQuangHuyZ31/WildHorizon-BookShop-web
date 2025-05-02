<?php

use Core\Session;
use GuzzleHttp\Promise\Is;

$messge = Session::get('message') ?? [];
$error_msg = Session::get('error-data') ?? [];
Session::delete('error-data');
// var_dump($_SESSION);
?>
<?php include VIEW_PATH . 'admin/layout/layout.php'; ?>

<!DOCTYPE html>
<html lang="vi">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Thêm banner quảng cáo</title>

</head>

<body class="font-sans bg-gray-100">

  <div class="flex min-h-screen">
    <!-- Sidebar -->
    <?php include VIEW_PATH . 'admin/layout/sidebar.php'; ?>

    <!-- Main Content -->
    <div class="flex-1 p-8 overflow-auto">
      <!-- Top Header -->
      <?php include VIEW_PATH . 'admin/layout/header.php'; ?>

      <!-- Content -->
      <div class="bg-white shadow-md rounded-md w-full p-6">
        <form action="<?php echo BASE_URL ?>/admin/banner/edit" method="post" enctype="multipart/form-data">
          <input type="hidden" name="csrf_token" value="<?php echo $csrf_token ?>">
          <input type="hidden" name="banner_id" value="<?php echo $banner['id'] ?>">
          <div class="w-full mb-5">
            <label class="w-full">
              <p class="text-[15px] font-semibold mb-2 ps-3">Mục tiêu quảng cáo</p>
              <input type="text" placeholder="Nhập mục tiêu quảng cáo" name="banner_name" value="<?php echo $banner['name'] ?>" class="input w-full <?php echo isset($error_msg['banner_name']) ? 'input-error' : 'input-info' ?>" />
            </label>
            <?php if (isset($error_msg['banner_name'])) { ?>
              <p class="text-red-500 text-[13px] ps-4 mt-1"><?php echo htmlspecialchars($error_msg['banner_name']) ?></p>
            <?php } ?>
          </div>
          <div class="w-full mb-5">
            <label class="w-full">
              <p class="text-[15px] font-semibold mb-2 ps-3">Chọn hình ảnh</p>
              <input type="file" name="banner_image" accept="image/png, image/jpeg, image/jpg, image/webp" class="file-input <?php echo isset($error_msg['banner_image']) ? 'file-input-error' : 'file-input-info' ?> w-full" />
            </label>
            <?php if (isset($error_msg['banner_image'])) { ?>
              <p class="text-red-500 text-[13px] ps-4 mt-1"><?php echo htmlspecialchars($error_msg['banner_image']) ?></p>
            <?php } ?>
            <div class="mt-3">
              <p class="px-3 py-1 text-[14px] font-semibold">Hình ảnh banner hiện tại</p>
              <img src="<?php echo $banner['image'] ?>" alt="banner_image">
            </div>

          </div>
          <div class="w-full mb-5">
            <p class="text-[15px] font-semibold mb-2 ps-3">Trạng thái</p>
            <div class="flex items-center">
              <label class="flex items-center cursor-pointer">
                <input type="radio" name="status" value="active" class="radio radio-sm radio-info" <?php echo $banner['status'] == 'active' ? 'checked="checked"' : '' ?> />
                <span class="ms-3">Hoạt động</span>
              </label>
              <label class="flex items-center ms-10 cursor-pointer">
                <input type="radio" name="status" value="no_active" class="radio radio-sm radio-info" <?php echo $banner['status'] == 'no_active' ? 'checked="checked"' : '' ?> />
                <span class="ms-3">Chưa hoạt động</span>
              </label>
            </div>
          </div>
          <div class="w-full mb-5">
            <select class="select <?php echo isset($error_msg['banner_position']) ? 'select-error' : 'select-info' ?> w-[50%]" name="banner_position">
              <option disabled selected>Chọn vị trí banner</option>
              <option value="homepage" <?php echo $banner['position'] == 'homepage' ? 'selected' : '' ?>>HomePage</option>
              <option value="sidebar" <?php echo $banner['position'] == 'sidebar' ? 'selected' : '' ?>>Sidebar</option>
              <option class="footer" <?php echo $banner['position'] == 'footer' ? 'selected' : '' ?>>Footer</option>
            </select>
            <?php if (isset($error_msg['banner_position'])) { ?>
              <p class="text-red-500 text-[13px] ps-4 mt-1"><?php echo htmlspecialchars($error_msg['banner_position']) ?></p>
            <?php } ?>
          </div>
          <div class="w-full mb-5 flex justify-end">
            <button type="submit" class="btn btn-accent text-white" onclick="JsLoadingOverlay.show();">Lưu thay đổi</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <?php include VIEW_PATH . 'admin/layout/footer.php'; ?>
</body>

<script>
  function confirmDelete(encryptedId) {
    // Sử dụng SweetAlert để hiển thị hộp thoại xác nhận
    Swal.fire({
      title: 'Bạn có chắc chắn muốn xóa thương hiệu này?',
      text: "Hành động này không thể hoàn tác.",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonText: 'Có, xóa nó!',
      cancelButtonText: 'Không, hủy bỏ!',
      reverseButtons: true
    }).then((result) => {
      if (result.isConfirmed) {
        // Nếu người dùng nhấn "Có, xóa nó!"
        document.getElementById('delete-form-' + encryptedId).submit();
        var messge = <?php echo json_encode($messge); ?>;

        if (messge.success) {
          toastr.success(messge.success);
        }
      }
    });
  }
</script>
<script>
  var messge = <?php echo json_encode($messge); ?>;

  if (messge.success) {
    toastr.success(messge.success);
  }
</script>
<?php
Session::delete('message');
?>

</html>