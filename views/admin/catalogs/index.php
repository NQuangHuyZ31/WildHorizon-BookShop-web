<?php

use Core\Session;

$messge = Session::get('message')??[];
// Session::delete('message');
?>
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
            <div class="bg-white p-6 rounded-lg shadow-lg">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-2xl font-semibold text-gray-800">Quản lý Danh mục</h2>
                    <a href="<?=BASE_URL_NAME?>/admin/catalogs/create">
                        <button class="bg-blue-500 text-white px-6 py-2 rounded-lg hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-400">
                            Thêm danh mục
                        </button>
                    </a>
                </div>
                <table class="min-w-full bg-white">
                    <thead>
                        <tr>
                            <th class="py-2 px-4 border-b text-left text-gray-600" >Tên danh mục</th>
                            <th class="py-2 px-4 border-b text-left text-gray-600" >Mô tả</th>
                            <th class="py-2 px-4 border-b text-left text-gray-600" >Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($catalogs as $catalog): ?>
                            <tr>
                                <td class="py-2 px-4 border-b"><?= htmlspecialchars($catalog['name']) ?></td>
                                <td class="py-2 px-4 border-b"><?= htmlspecialchars($catalog['description']) ?></td>
                                <td class="py-2 px-4 border-b text-center">
                                    <div class="flex justify-center space-x-4">
                                        <a href="<?= BASE_URL_NAME ?>/admin/catalogs/edit?id=<?= $catalog['catalog_id'] ?>" class="text-blue-500 hover:text-blue-700">
                                            <i class="fas fa-edit"></i>
                                            <span>Edit</span>
                                        </a>
                                        <form action="<?= BASE_URL_NAME ?>/admin/catalogs/delete" method="POST" id="delete-form-<?= $catalog['catalog_id'] ?>" style="display: inline;">
                                            <input type="hidden" name="id" value="<?= $catalog['catalog_id'] ?>">
                                            <button type="button" onclick="confirmDelete(<?= $catalog['catalog_id'] ?>)" class="text-red-500 hover:text-red-700">
                                                <i class="fas fa-trash-alt"></i>
                                                <span>Delete</span>
                                            </button>
                                        </form>
                                    </div>
                                </td>

                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>

            </div>

        </div>
    </div>
    
    <?php include VIEW_PATH . 'admin/layout/footer.php'; ?>
</body>

<script>
    function confirmDelete(catalogId) {
        // Sử dụng SweetAlert để hiển thị hộp thoại xác nhận
        Swal.fire({
            title: 'Bạn có chắc chắn muốn xóa danh mục này?',
            text: "Hành động này không thể hoàn tác.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Có, xóa nó!',
            cancelButtonText: 'Không, hủy bỏ!',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                // Nếu người dùng nhấn "Có, xóa nó!"
                
                document.getElementById('delete-form-' + catalogId).submit();
                var messge = <?php echo json_encode($messge); ?>;
    
                if(messge.success){
                    toastr.success(messge.success);
                }
            }
        });
    }
</script>
<script>
    var messge = <?php echo json_encode($messge); ?>;
    
    if(messge.success){
        toastr.success(messge.success);
    }
</script>
<?php
    Session::delete('message');
?>
</html>