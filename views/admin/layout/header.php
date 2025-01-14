<!-- header.php -->
<?php
use Core\Session;

$admin = Session::get('admin');

?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
<link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet"/>
<script src="https://cdn.tailwindcss.com"></script>
<link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet"/>
<script>
    var $admin = <?php echo json_encode($admin); ?>;
</script>
<div class="flex justify-between items-center mb-8">
    <h2 class="text-3xl font-semibold text-gray-800">Chào mừng đến với trang quản trị</h2>
    <div class="flex items-center space-x-4">
        <img src="<?= BASE_URL_NAME ?>/Public/images/admin/alibaba.jpg" alt="User Avatar" class="w-10 h-10 rounded-full">
        <span class="text-gray-700">Xin chào <?php echo $admin['name'] ?></span>
    </div>
</div>