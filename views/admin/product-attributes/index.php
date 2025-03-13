<!-- index.php -->
<?php

use Core\Session;

$message = Session::get('message') ?? [];

?>

<?php include VIEW_PATH . 'admin/layout/layout.php'; ?>
<title>Quản lý Thuộc tính Sản phẩm</title>

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
                    <form action="<?= BASE_URL_NAME ?>/admin/product-attributes" method="GET" class="relative w-1/2 max-w-[400px]">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                            <i class="fas fa-search text-gray-500"></i>
                        </div>
                        <input type="search" name="search"
                            class="block w-full p-4 pl-10 pr-20 text-sm text-gray-900 border border-gray-300 rounded-lg focus:ring-blue-500 focus:outline-none focus:border-blue-500"
                            placeholder="Tìm kiếm thuộc tính..."
                            value="<?= htmlspecialchars($_GET['search'] ?? '') ?>" />
                        <button type="submit"
                            class="absolute right-2 top-1/2 transform -translate-y-1/2 bg-blue-500 text-white px-3 py-1 rounded-lg hover:bg-blue-600 focus:ring-4 focus:outline-none focus:ring-blue-300">
                            Tìm kiếm
                        </button>
                    </form>

                    <!-- Nút thêm thuộc tính -->
                    <a href="<?= BASE_URL_NAME ?>/admin/product-attributes/create" class="ml-4">
                        <button class="bg-blue-500 text-white px-6 py-2 rounded-lg hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-400">
                            Thêm Thuộc Tính
                        </button>
                    </a>
                </div>

                <table class="min-w-full bg-white">
                    <thead>
                        <tr>
                            <th class="py-2 px-4 border-b text-left text-gray-600">Tên Sản phẩm</th>
                            <th class="py-2 px-4 border-b text-left text-gray-600">Tên Thuộc Tính</th>
                            <th class="py-2 px-4 border-b text-left text-gray-600">Giá trị</th>
                            <th class="py-2 px-4 border-b text-left text-gray-600">Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $previousProductName = null; // Biến để lưu tên sản phẩm trước đó
                        foreach ($attributes as $attribute):
                            $currentProductName = htmlspecialchars($attribute['product_name']);
                        ?>
                            <tr>
                                <td class="py-2 px-4 border-b">
                                    <?php if ($currentProductName !== $previousProductName): ?>
                                        <?= $currentProductName ?>
                                        <?php $previousProductName = $currentProductName; // Cập nhật tên sản phẩm trước đó 
                                        ?>
                                    <?php else: ?>
                                        <!-- Nếu tên sản phẩm giống nhau, để ô trống -->
                                        &nbsp;
                                    <?php endif; ?>
                                </td>
                                <td class="py-2 px-4 border-b"><?= htmlspecialchars($attribute['attr_name']) ?></td>
                                <td class="py-2 px-4 border-b"><?= htmlspecialchars($attribute['attr_value']) ?></td>
                                <td class="py-2 px-4 border-b text-center">
                                    <div class="flex justify-center space-x-4">
                                        <?php $encryptedId = \Core\Encrypt::encryptId($attribute['id'], KEY); ?>
                                        <a href="javascript:void(0)" onclick="openEditModal('<?= $encryptedId ?>', '<?= htmlspecialchars($attribute['attr_name']) ?>', '<?= htmlspecialchars($attribute['attr_value']) ?>')" class="text-blue-500 hover:text-blue-700">
                                            <i class="fas fa-edit"></i>
                                            <span>Edit</span>
                                        </a>

                                        <form action="<?= BASE_URL_NAME ?>/admin/product-attributes/delete" method="POST" id="delete-form-<?= $encryptedId ?>" style="display: inline;">
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
                                    <a href="<?= BASE_URL_NAME ?>/admin/product-attributes?page=<?= $currentPage - 1 ?>"
                                        class="px-3 py-1 bg-gray-200 text-gray-700 rounded hover:bg-gray-300">
                                        Trước
                                    </a>
                                </li>
                            <?php endif; ?>

                            <!-- Hiển thị trang đầu tiên nếu không phải trang 1 -->
                            <?php if ($currentPage > 3): ?>
                                <li>
                                    <a href="<?= BASE_URL_NAME ?>/admin/product-attributes?page=1"
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
                                    <a href="<?= BASE_URL_NAME ?>/admin/product-attributes?page=<?= $i ?>"
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
                                    <a href="<?= BASE_URL_NAME ?>/admin/product-attributes?page=<?= $totalPages ?>"
                                        class="px-3 py-1 bg-gray-200 text-gray-700 rounded hover:bg-gray-300">
                                        <?= $totalPages ?>
                                    </a>
                                </li>
                            <?php endif; ?>

                            <!-- Nút "Trang sau" -->
                            <?php if ($currentPage < $totalPages): ?>
                                <li>
                                    <a href="<?= BASE_URL_NAME ?>/admin/product-attributes?page=<?= $currentPage + 1 ?>"
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

<!-- Modal Edit -->
<div id="edit-modal" class="fixed inset-0 flex items-center justify-center bg-gray-900 bg-opacity-50 hidden">
    <div class="bg-white p-6 rounded-lg shadow-lg w-96">
        <h2 class="text-xl font-bold mb-4">Chỉnh sửa thuộc tính</h2>
        
        <form id="edit-form" action="<?= BASE_URL_NAME ?>/admin/product-attributes/update?page=<?= $_GET['page'] ?? 1 ?>" method="POST">
            <input type="hidden" name="id" id="edit_id">
            
            <div class="mb-4">
                <label for="edit-name" class="block text-gray-700 font-semibold mb-2">Tên Thuộc Tính</label>
                <input type="text" id="edit_name" name="edit_name"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
            </div>

            <div class="mb-4">
                <label for="edit-value" class="block text-gray-700 font-semibold mb-2">Giá Trị</label>
                <input type="text" id="edit_value" name="edit_value"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
            </div>

            <div class="flex justify-end space-x-4">
                <button type="button" onclick="closeModal()" class="px-4 py-2 bg-gray-400 text-white rounded-lg">Hủy</button>
                <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-lg">Cập Nhật</button>
            </div>
        </form>
    </div>
</div>

    <?php include VIEW_PATH . 'admin/layout/footer.php'; ?>
</body>

<!-- Thông báo thành công -->
<script>
    function confirmDelete(id) {
        Swal.fire({
            title: 'Bạn có chắc chắn muốn xóa?',
            text: "Hành động này không thể hoàn tác.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Có, xóa nó!',
            cancelButtonText: 'Không, hủy bỏ!',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('delete-form-' + id).submit();
            }
        });
    }
</script>

<script>
// Hàm mở modal chỉnh sửa
function openEditModal(id, name, value) {
    document.getElementById('edit_id').value = id;
    document.getElementById('edit_name').value = name;
    document.getElementById('edit_value').value = value;
    
    document.getElementById('edit-modal').classList.remove('hidden');
}

// Hàm đóng modal chỉnh sửa
function closeModal() {
    document.getElementById('edit-modal').classList.add('hidden');
}

</script>


<script>
    var message = <?php echo json_encode($message); ?>;
    if (message.success) {
        toastr.success(message.success);
    }
    else if(message.error) {
        toastr.error(message.error);
    }
</script>

<?php
Session::delete('message');
?>

</html>