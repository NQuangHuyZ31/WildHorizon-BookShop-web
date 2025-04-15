<?php

use Core\Session;

$messge = Session::get('message') ?? [];
?>
<?php include VIEW_PATH . 'admin/layout/layout.php'; ?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý Nhà Cung Cấp</title>
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
                    <!-- Form tìm kiếm -->
                    <form action="<?= BASE_URL_NAME ?>/admin/suppliers" method="GET" class="relative w-1/2 max-w-[400px]">
                        <!-- Icon search -->
                        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                            <i class="fas fa-search text-gray-500"></i>
                        </div>
                        <!-- Input -->
                        <input
                            type="search"
                            name="search"
                            class="block w-full p-4 pl-10 pr-20 text-sm text-gray-900 border border-gray-300 rounded-lg focus:ring-blue-500 focus:outline-none focus:border-blue-500"
                            placeholder="Tìm kiếm nhà cung cấp"
                            value="<?= htmlspecialchars($_GET['search'] ?? '') ?>"
                            />
                        <!-- Nút tìm kiếm -->
                        <button
                            type="submit"
                            class="absolute right-2 top-1/2 transform -translate-y-1/2 bg-blue-500 text-white px-3 py-1 rounded-lg hover:bg-blue-600 focus:ring-4 focus:outline-none focus:ring-blue-300">
                            Tìm kiếm
                        </button>
                    </form>
                    <a href="<?= BASE_URL_NAME ?>/admin/suppliers/create">
                        <button class="bg-blue-500 text-white px-6 py-2 rounded-lg hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-400">
                            Thêm Nhà Cung Cấp
                        </button>
                    </a>
                </div>
                <table class="min-w-full bg-white">
                    <thead>
                        <tr>
                            <th class="py-2 px-4 border-b text-left text-gray-600">Tên nhà cung cấp</th>
                            <th class="py-2 px-4 border-b text-left text-gray-600">Số điện thoại</th>
                            <th class="py-2 px-4 border-b text-left text-gray-600">Email</th>
                            <th class="py-2 px-4 border-b text-left text-gray-600">Địa chỉ</th>
                            <th class="py-2 px-4 border-b text-left text-gray-600">Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($suppliers as $supplier): ?>
                            <tr>
                                <td class="py-2 px-4 border-b"><?= htmlspecialchars($supplier['supplier_name']) ?></td>
                                <td class="py-2 px-4 border-b"><?= htmlspecialchars($supplier['phone']) ?></td>
                                <td class="py-2 px-4 border-b"><?= htmlspecialchars($supplier['email']) ?></td>
                                <td class="py-2 px-4 border-b"><?= htmlspecialchars($supplier['address']) ?></td>
                                <td class="py-2 px-4 border-b">
                                    <div class="flex justify-center space-x-4">
                                        <?php $encryptedId = \Core\Encrypt::encryptId($supplier['id'], KEY); ?>
                                        <a href="<?= BASE_URL_NAME ?>/admin/suppliers/edit?id=<?= $encryptedId ?>" class="text-blue-500 hover:text-blue-700">
                                            <i class="fas fa-edit"></i>
                                            <span>Edit</span>
                                        </a>
                                        <form action="<?= BASE_URL_NAME ?>/admin/suppliers/delete" method="POST" id="delete-form-<?= $encryptedId ?>" style="display: inline;">
                                            <input type="hidden" name="id" value="<?= $encryptedId ?>">
                                            <button type="button" onclick="confirmDelete('<?= $encryptedId ?>')" class="text-red-500 hover:text-red-700">
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
                <div class="mt-4 flex justify-center">
                    <nav aria-label="Pagination">
                        <ul class="flex space-x-2">
                            <!-- Nút "Trang trước" -->
                            <?php if ($currentPage > 1): ?>
                                <li>
                                    <a href="<?= BASE_URL_NAME ?>/admin/suppliers?page=<?= $currentPage - 1 ?>"
                                        class="px-3 py-1 bg-gray-200 text-gray-700 rounded hover:bg-gray-300">
                                        Trước
                                    </a>
                                </li>
                            <?php endif; ?>

                            <!-- Hiển thị trang đầu tiên nếu không phải trang 1 -->
                            <?php if ($currentPage > 3): ?>
                                <li>
                                    <a href="<?= BASE_URL_NAME ?>/admin/suppliers?page=1"
                                        class="px-3 py-1 bg-gray-200 text-gray-700 rounded hover:bg-gray-300">
                                        1
                                    </a>
                                </li>
                                <!-- Hiển thị dấu "..." nếu cần -->
                                <?php if ($currentPage > 4): ?>
                                    <li>
                                        <span class="px-3 py-1">...</span>
                                    </li>
                                <?php endif; ?>
                            <?php endif; ?>

                            <!-- Hiển thị các trang xung quanh trang hiện tại -->
                            <?php for ($i = max(1, $currentPage - 2); $i <= min($totalPages, $currentPage + 2); $i++): ?>
                                <li>
                                    <a href="<?= BASE_URL_NAME ?>/admin/suppliers?page=<?= $i ?>"
                                        class="px-3 py-1 <?= $i == $currentPage ? 'bg-blue-500 text-white' : 'bg-gray-200 text-gray-700' ?> rounded hover:bg-gray-300">
                                        <?= $i ?>
                                    </a>
                                </li>
                            <?php endfor; ?>

                            <!-- Hiển thị trang cuối cùng nếu không phải trang cuối -->
                            <?php if ($currentPage < $totalPages - 2): ?>
                                <!-- Hiển thị dấu "..." nếu cần -->
                                <?php if ($currentPage < $totalPages - 3): ?>
                                    <li>
                                        <span class="px-3 py-1">...</span>
                                    </li>
                                <?php endif; ?>
                                <li>
                                    <a href="<?= BASE_URL_NAME ?>/admin/suppliers?page=<?= $totalPages ?>"
                                        class="px-3 py-1 bg-gray-200 text-gray-700 rounded hover:bg-gray-300">
                                        <?= $totalPages ?>
                                    </a>
                                </li>
                            <?php endif; ?>

                            <!-- Nút "Trang sau" -->
                            <?php if ($currentPage < $totalPages): ?>
                                <li>
                                    <a href="<?= BASE_URL_NAME ?>/admin/suppliers?page=<?= $currentPage + 1 ?>"
                                        class="px-3 py-1 bg-gray-200 text-gray-700 rounded hover:bg-gray-300">
                                        Sau
                                    </a>
                                </li>
                            <?php endif; ?>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <?php include VIEW_PATH . 'admin/layout/footer.php'; ?>
</body>

<script>
    function confirmDelete(safeId) {
        Swal.fire({
            title: 'Bạn có chắc chắn muốn xóa nhà cung cấp này?',
            text: "Hành động này không thể hoàn tác.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Có, xóa nó!',
            cancelButtonText: 'Không, hủy bỏ!',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('delete-form-' + safeId).submit();
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
