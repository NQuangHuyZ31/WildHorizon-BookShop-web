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
        <div class="overflow-x-auto rounded-box border border-base-content/5 bg-base-100 p-6">
          <?php if ($feedbacks != null) { ?>
            <table class="table">
              <!-- head -->
              <thead>
                <tr>
                  <th class="align-middle text-center text-[15px]">Khách hàng</th>
                  <th class="align-middle text-center text-[15px]">Loại</th>
                  <th class="align-middle text-center text-[15px]">Ngày</th>
                  <th class="align-middle text-center text-[15px]">Trạng thái</th>
                  <th class="align-middle text-center text-[15px]"></th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($feedbacks as $feedback) { ?>
                  <tr>
                    <td class="align-middle text-center"><?php echo $feedback['username'] ?></td>
                    <td class="align-middle text-center"><?php echo $feedback['type'] ?></td>
                    <td class="align-middle text-center"><?php echo date('d-m-Y', strtotime($feedback['created_at'])) ?></td>
                    <td class="align-middle text-center">
                      <button class="btn btn-outline min-h-[30px] h-[30px] text-[13px] pointer-events-none <?php echo $feedback['status'] == 'Chờ phản hồi' ? '' : 'btn-primary' ?>">
                        <?php echo $feedback['status'] ?>
                      </button>
                    </td>
                    <td>
                      <a href="<?php echo BASE_URL ?>/admin/user_feedback/<?php echo $feedback['id'] ?>">
                        <button class="btn mb-3">
                          Xem
                          <i class="fa-solid fa-eye text-orange-700"></i>
                        </button>
                      </a>
                    </td>
                  </tr>
                <?php } ?>
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
      </div>
    </div>
  </div>
  </div>

  <?php include VIEW_PATH . 'admin/layout/footer.php'; ?>
</body>
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