<?php

use Core\Session;

$messge = Session::get('message') ?? [];
// Session::delete('message');
$error_msg = Session::get('error-data') ?? [];
Session::delete('error-data');
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
          <div class="text-[17px] font-semibold text-gray-500 flex items-center justify-between">
            <p>Thông tin ý kiến từ khách hàng</p>
            <p class="text-[13px] text-gray-400">Ngày gửi: <?php echo date('d-m-Y', strtotime($feedback['created_at'])) ?></p>
          </div>
          <div class="border border-slate-200 rounded-md mt-3 p-2">
            <p class="font-semibold text-[15px] p-1 ">Khách hàng: <span class="font-normal text-[16px]"><?php echo $customer['username'] ?></span></p>
            <p class="font-semibold text-[15px] p-1 ">Số điện thoại: <span class="font-normal text-[16px]"><?php echo $customer['phone'] ?></span></p>
          </div>
          <div class="border border-slate-200 rounded-md mt-3 p-2">
            <p class="font-semibold text-[15px] p-1 ">Loại ý kiến: <span class="font-normal text-[16px]"><?php echo $feedback['type'] ?></span></p>
            <p class="font-semibold text-[15px] p-1 ">Nội dung: <span class="font-normal text-[16px]"><?php echo $feedback['content'] ?></span></p>
            <p class="font-semibold text-[15px] p-1 ">Hình ảnh kèm theo:</p>
            <?php if ($feedback['image'] != null) { ?>
              <img src="<?php echo $feedback['image'] ?>" data-lity alt="" class="w-[240px] h-[240px]">
            <?php } else { ?>
              <p class="ms-3 text-[13px] text-orange-700">Không có hình ảnh. </p>
            <?php } ?>
          </div>
          <div class="border border-slate-200 rounded-md mt-3 p-2">
            <form action="<?php echo BASE_URL ?>/admin/user_feedback/answer" method="post">
              <input type="hidden" name="csrf_token" value="<?php echo $csrf_token ?>">
              <input type="hidden" name="feedback_id" value="<?php echo $feedback['id'] ?>">
              <p class="font-semibold text-[15px] p-1 ">Phản hồi với khách hàng</p>
              <textarea type="text" name="fb_answer" placeholder="Nhập câu trả lời" class="textarea textarea-info w-full h-[120px] mt-2"><?php if ($feedback_anwser != null) {
                                                                                                                                            echo $feedback_anwser['answer'];
                                                                                                                                          } ?></textarea>
              <?php if (isset($error_msg['fb_answer'])) { ?>
                <p class="ms-3 text-red-700 text-[13px] mt-1"><?php echo $error_msg['fb_answer'] ?></p>
              <?php } ?>
              <?php if ($feedback_anwser == null) { ?>
                <div class="flex justify-end mt-3"><button type="submit" class="btn btn-success">Xác nhận</button></div>
              <?php } ?>
            </form>
          </div>
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