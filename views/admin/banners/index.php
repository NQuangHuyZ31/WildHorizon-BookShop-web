<?php

use Core\Session;

$messge = Session::get('message') ?? [];
// Session::delete('message');
?>
<?php include VIEW_PATH . 'admin/layout/layout.php'; ?>

<!DOCTYPE html>
<html lang="vi">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Dashboard</title>

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
      <div class="bg-white shadow-md rounded-md min-h-[500px]">
        <div class="p-6">
          <button type="button" class="bg-sky-500 text-white p-3 rounded-md"><a href="<?php echo BASE_URL ?>/admin/banner/create" class="w-full">Thêm banner quảng cáo mới</a></button>
        </div>
        <div class="overflow-x-auto rounded-box border border-base-content/5 bg-base-100 p-6 mt-4">
          <?php if (!empty($banners)) { ?>
            <table class="table">
              <!-- head -->
              <thead class="text-center">
                <tr>
                  <th class="text-[14px]">Name</th>
                  <th class="text-[14px]">Hình ảnh</th>
                  <th class="text-[14px]">Trạng Thái</th>
                  <th class="text-[14px]">Vị trí</th>
                  <th class="text-[14px]">Năm</th>
                  <th class="text-[14px]"></th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($banners as $banner) { ?>
                  <tr>
                    <td class="align-middle text-center"><?php echo $banner['name'] ?></td>
                    <td class="w-[35%] align-middle text-center"><img src="<?php echo $banner['image'] ?>" data-lity alt="banner_image" class="w-full h-[40%] cursor-pointer"></td>
                    <td class="align-middle text-center">
                      <form action="<?php echo BASE_URL ?>/admin/banner/changestatus" method="post">
                        <input type="hidden" name="csrf_token" value="<?php echo $csrf_token ?>">
                        <input type="hidden" name="banner_id" value="<?php echo $banner['id'] ?>">
                        <button type="button" class="btn btn-outline h-[35px] text-[13px] <?php echo $banner['status'] == 'active' ? 'btn-success' : '' ?>" onclick="confirmChangeStatus(event)">
                          <?php echo $banner['status'] == 'active' ? 'Đang hiển thị' : 'Chưa được hiển thị' ?>
                        </button>
                      </form>
                    </td>
                    <td class="align-middle text-center"><?php echo $banner['position'] ?></td>
                    <td class="align-middle text-center"><?php echo date('Y', strtotime($banner['created_at'])) ?></td>
                    <td class="align-middle text-center">
                      <a href="<?php echo BASE_URL ?>/admin/banner/edit/<?php echo $banner['id'] ?>">
                        <button class="btn mb-3">
                          Sửa
                          <i class="fa-solid fa-pen-to-square text-orange-700"></i>
                        </button>
                      </a>
                      <form action="<?php echo BASE_URL ?>/admin/banner/delete" method="post">
                        <input type="hidden" name="csrf_token" value="<?php echo $csrf_token ?>">
                        <input type="hidden" name="banner_id" value="<?php echo $banner['id'] ?>">
                        <button type="button" class="btn mb-3" onclick="confirmDeleteBanner(event)">
                          Xóa
                          <i class="fa-solid fa-trash-can text-red-700"></i>
                        </button>
                      </form>
                    </td>
                  </tr>
                <?php  } ?>
              </tbody>
            </table>
          <?php } else { ?>
            <div role="alert" class="alert alert-info text-white">
              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" class="h-6 w-6 shrink-0 stroke-current">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
              </svg>
              <span>Không có banner quảng cáo nào.</span>
            </div>
          <?php } ?>
        </div>
        <?php if ($page > 1) { ?>
          <div class="flex items-center justify-between border-t border-gray-200 bg-white px-4 py-3 sm:px-6">
            <div class="hidden sm:flex sm:flex-1 sm:items-center sm:justify-between">
              <div>
                <nav class="isolate inline-flex -space-x-px rounded-md shadow-xs" aria-label="Pagination">
                  <!-- Previous button -->
                  <a href="<?php echo BASE_URL ?>/admin/banner?page=<?php echo $currentPage > 1 ? $currentPage - 1 : 1 ?>"
                    class="relative inline-flex items-center rounded-l-md px-2 py-2 text-gray-400 ring-1 ring-gray-300 ring-inset hover:bg-gray-50 focus:z-20 focus:outline-offset-0">
                    <span class="sr-only">Previous</span>
                    <svg class="size-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                      <path fill-rule="evenodd" d="M11.78 5.22a.75.75 0 0 1 0 1.06L8.06 10l3.72 3.72a.75.75 0 1 1-1.06 1.06l-4.25-4.25a.75.75 0 0 1 0-1.06l4.25-4.25a.75.75 0 0 1 1.06 0Z" clip-rule="evenodd" />
                    </svg>
                  </a>

                  <?php
                  $range = 2; // số lượng trang xung quanh trang hiện tại sẽ hiển thị
                  $currentPage = isset($_GET['page']) && is_numeric($_GET['page']) ? intval($_GET['page']) : 1;

                  $dots = false;
                  for ($i = 1; $i <= $page; $i++) {
                    if (
                      $i == 1 || $i == $page ||
                      ($i >= $currentPage - $range && $i <= $currentPage + $range)
                    ) {
                      $isActive = $i == $currentPage;
                      $classes = $isActive
                        ? 'z-10 bg-indigo-600 text-white focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600'
                        : 'text-gray-900 ring-1 ring-gray-300 ring-inset hover:bg-gray-50';

                      echo '<a href="' . BASE_URL . '/admin/banner?page=' . $i . '" class="relative inline-flex items-center px-4 py-2 text-sm font-semibold focus:z-20 ' . $classes . '">' . $i . '</a>';
                      $dots = true;
                    } elseif ($dots) {
                      echo '<span class="relative inline-flex items-center px-4 py-2 text-sm font-semibold text-gray-700 ring-1 ring-gray-300 ring-inset focus:outline-offset-0">...</span>';
                      $dots = false;
                    }
                  }

                  ?>

                  <!-- Next button -->
                  <a href="<?php echo BASE_URL ?>/admin/banner?page=<?php echo $currentPage < $page ? $currentPage + 1 : $page ?>"
                    class="relative inline-flex items-center rounded-r-md px-2 py-2 text-gray-400 ring-1 ring-gray-300 ring-inset hover:bg-gray-50 focus:z-20 focus:outline-offset-0">
                    <span class="sr-only">Next</span>
                    <svg class="size-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                      <path fill-rule="evenodd" d="M8.22 5.22a.75.75 0 0 1 1.06 0l4.25 4.25a.75.75 0 0 1 0 1.06l-4.25 4.25a.75.75 0 0 1-1.06-1.06L11.94 10 8.22 6.28a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd" />
                    </svg>
                  </a>
                </nav>
              </div>
            </div>
          </div>
        <?php } ?>
      </div>
    </div>
  </div>
  </div>

  <?php include VIEW_PATH . 'admin/layout/footer.php'; ?>
</body>

<script>
  function confirmChangeStatus(e) {
    e.preventDefault();

    const form = e.target.closest('form'); // lưu form từ nút đang được click

    Swal.fire({
      title: 'Bạn có chắc chắn muốn thay đổi trạng thái banner này?',
      icon: 'warning',
      showCancelButton: true,
      confirmButtonText: 'Thay đổi!',
      cancelButtonText: 'Không, hủy bỏ!',
      reverseButtons: true
    }).then((result) => {
      if (result.isConfirmed) {
        form.submit(); // dùng form đã lưu
      }
    });
  }

  function confirmDeleteBanner(e) {
    e.preventDefault();

    const form = e.target.closest('form'); // lưu form từ nút đang được click

    Swal.fire({
      title: 'Bạn có chắc chắn muốn xóa banner này?',
      icon: 'warning',
      showCancelButton: true,
      confirmButtonText: 'Có',
      cancelButtonText: 'Không, hủy bỏ!',
      reverseButtons: true
    }).then((result) => {
      if (result.isConfirmed) {
        form.submit(); // dùng form đã lưu
      }
    });
  }
</script>
<script>
  var messge = <?php echo json_encode($messge); ?>;

  if (messge.success) {
    toastr.success(messge.success);
  }

  if (messge.error) {
    toastr.error(messge.error)
  }
</script>
<?php
Session::delete('message');
?>

</html>