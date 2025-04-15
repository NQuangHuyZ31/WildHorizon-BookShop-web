<?php

use Core\Session;

$messge = Session::get('message') ?? [];

?>

<?php include VIEW_PATH . 'admin/layout/layout.php'; ?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Quản lý Flash Sale</title>
</head>

<body class="font-sans bg-gray-100">
    <div class="flex min-h-screen">
        <?php include VIEW_PATH . 'admin/layout/sidebar.php'; ?>

        <div class="flex-1 p-8 overflow-auto">
            <?php include VIEW_PATH . 'admin/layout/header.php'; ?>

            <div class="bg-white p-6 rounded-lg shadow-lg">
                <div class="flex justify-between items-center mb-4">
                    <form action="<?= BASE_URL ?>/admin/flash-sales" method="GET" class="relative w-1/2 max-w-[400px]">
                        <!-- Icon search -->
                        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                            <i class="fas fa-search text-gray-500"></i>
                        </div>
                        <!-- Input -->
                        <input
                            type="search"
                            name="search"
                            class="block w-full p-4 pl-10 pr-20 text-sm text-gray-900 border border-gray-300 rounded-lg focus:ring-blue-500 focus:outline-none focus:border-blue-500"
                            placeholder="Tìm kiếm sản phẩm..."
                            value="<?= htmlspecialchars($_GET['search'] ?? '') ?>" />
                        <!-- Nút tìm kiếm -->
                        <button
                            type="submit"
                            class="absolute right-2 top-1/2 transform -translate-y-1/2 bg-blue-500 text-white px-3 py-1 rounded-lg hover:bg-blue-600 focus:ring-4 focus:outline-none focus:ring-blue-300">
                            Tìm kiếm
                        </button>
                    </form>

                    <a href="<?= BASE_URL ?>/admin/flash-sales/create">
                        <button class="bg-blue-500 text-white px-6 py-2 rounded-lg hover:bg-blue-600">Thêm Flash Sale</button>
                    </a>
                </div>

                <table class="min-w-full bg-white">
                    <thead>
                        <tr>
                            <th class="py-2 px-4 border-b text-center" style="width: 41%;">Sản phẩm</th>
                            <th class="py-2 px-4 border-b text-center" style="width: 10%;">Giảm giá</th>
                            <th class="py-2 px-4 border-b text-center" style="width: 10%;">Số lượng</th>
                            <th class="py-2 px-4 border-b text-center" style="width: 12%;">Ngày bắt đầu</th>
                            <th class="py-2 px-4 border-b text-center" style="width: 12%;">Ngày kết thúc</th>
                            <th class="py-2 px-4 border-b text-center" style="width: 15%;">Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($flashsales as $fs): ?>
                            <tr>
                                <td class="py-2 px-4 border-b">
                                    <div class="flex items-center gap-3">
                                        <img src="<?= BASE_URL ?>/Public/upload/products/<?= $fs['product_image'] ?>" class="w-12 h-15 object-cover">
                                        <span class="text-gray-800"><?= htmlspecialchars($fs['product_name']) ?></span>
                                    </div>
                                </td>

                                <td class="py-2 px-4 border-b text-center"><?= number_format($fs['discount_price'], 0, ',', '.') ?>%</td>
                                <td class="py-2 px-4 border-b text-center"><?= $fs['quantity'] ?></td>
                                <td class="py-2 px-4 border-b text-center">
                                    <?= date('d-m-Y', strtotime($fs['start_date'])) ?>
                                </td>
                                <td class="py-2 px-4 border-b text-center">
                                    <?= date('d-m-Y', strtotime($fs['end_date'])) ?>
                                </td>

                                <td class="py-2 px-4 border-b text-center">
                                    <div class="flex justify-center space-x-4">
                                        <?php $encryptedId = \Core\Encrypt::encryptId($fs['id'], KEY); ?>
                                        <a href="<?= BASE_URL ?>/admin/flash-sales/edit?id=<?= $encryptedId ?>" class="text-blue-500 hover:text-blue-700">
                                            <i class="fas fa-edit"></i> Edit
                                        </a>
                                        <form action="<?= BASE_URL ?>/admin/flash-sales/delete" method="POST" id="delete-form-<?= $fs['id'] ?>">
                                            <input type="hidden" name="id" value="<?= $encryptedId ?>">
                                            <button type="button" onclick="confirmDelete(<?= $encryptedId ?>)" class="text-red-500 hover:text-red-700">
                                                <i class="fas fa-trash-alt"></i> Delete
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>

                <!-- Phân trang -->
                <div class="mt-4 flex justify-center">
                    <nav aria-label="Pagination">
                        <ul class="flex space-x-2">
                            <?php if ($currentPage > 1): ?>
                                <li><a href="?page=<?= $currentPage - 1 ?>" class="px-3 py-1 bg-gray-200 text-gray-700 rounded">Trước</a></li>
                            <?php endif; ?>

                            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                                <li>
                                    <a href="?page=<?= $i ?>"
                                        class="px-3 py-1 <?= $i == $currentPage ? 'bg-blue-500 text-white' : 'bg-gray-200 text-gray-700' ?> rounded">
                                        <?= $i ?>
                                    </a>
                                </li>
                            <?php endfor; ?>

                            <?php if ($currentPage < $totalPages): ?>
                                <li><a href="?page=<?= $currentPage + 1 ?>" class="px-3 py-1 bg-gray-200 text-gray-700 rounded">Sau</a></li>
                            <?php endif; ?>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <?php include VIEW_PATH . 'admin/layout/footer.php'; ?>

    <script>
    function confirmDelete(encryptedId) {
        // Sử dụng SweetAlert để hiển thị hộp thoại xác nhận
        Swal.fire({
            title: 'Bạn có chắc chắn muốn xóa flashsale này?',
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
</body>

</html>