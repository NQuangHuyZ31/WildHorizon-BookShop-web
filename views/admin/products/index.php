<!-- index.php -->
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
                    <a href="<?= BASE_URL_NAME ?>/admin/products/create">
                        <button class="bg-blue-500 text-white px-6 py-2 rounded-lg hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-400">
                            Thêm sản phẩm
                        </button>
                    </a>
                </div>
                <table class="min-w-full bg-white">
                    <thead>
                        <tr>
                            <th class="py-2 px-4 border-b text-left text-gray-600" style="width: 25%;">Tên Sản phẩm</th>
                            <th class="py-2 px-4 border-b text-left text-gray-600" style="width: 15%;">Hình ảnh</th>
                            <th class="py-2 px-4 border-b text-left text-gray-600" style="width: 20%;">Danh mục</th>
                            <th class="py-2 px-4 border-b text-left text-gray-600" style="width: 15%;">Giá</th>
                            <th class="py-2 px-4 border-b text-left text-gray-600" style="width: 10%;">Kho</th>
                            <th class="py-2 px-4 border-b text-left text-gray-600" style="width: 15%;">Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($products as $product): ?>
                            <tr>
                                <td class="py-2 px-4 border-b"><?= htmlspecialchars($product['name']) ?></td>
                                <td class="py-2 px-4 border-b">
                                    <img src="<?= '../Public/upload/products/' . htmlspecialchars($product['image']) ?>" alt="<?= htmlspecialchars($product['name']) ?>" class="w-24 h-30 object-cover">
                                </td>
                                <td class="py-2 px-4 border-b"><?= htmlspecialchars($product['catalog_name']) ?></td>
                                <td class="py-2 px-4 border-b"><?= number_format($product['price'], 0, ',', '.') ?> VND</td>
                                <td class="py-2 px-4 border-b"><?= $product['stock'] ?></td>
                                <td class="py-2 px-4 border-b text-center">
                                    <div class="flex justify-center space-x-4">
                                        <a href="<?= BASE_URL_NAME ?>/admin/products/edit?id=<?= $product['product_id'] ?>" class="text-blue-500 hover:text-blue-700">
                                            <i class="fas fa-edit"></i>
                                            <span>Edit</span>
                                        </a>
                                        <form action="<?= BASE_URL_NAME ?>/admin/products/delete" method="POST" id="delete-form-<?= $product['product_id'] ?>" style="display: inline;">
                                            <input type="hidden" name="id" value="<?= $product['product_id'] ?>">
                                            <button type="button" onclick="confirmDelete(<?= $product['product_id'] ?>)" class="text-red-500 hover:text-red-700">
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
                                    <a href="<?= BASE_URL_NAME ?>/admin/products?page=<?= $currentPage - 1 ?>" 
                                    class="px-3 py-1 bg-gray-200 text-gray-700 rounded hover:bg-gray-300">
                                        Trước
                                    </a>
                                </li>
                            <?php endif; ?>

                            <!-- Hiển thị trang đầu tiên nếu không phải trang 1 -->
                            <?php if ($currentPage > 3): ?>
                                <li>
                                    <a href="<?= BASE_URL_NAME ?>/admin/products?page=1" 
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
                                    <a href="<?= BASE_URL_NAME ?>/admin/products?page=<?= $i ?>" 
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
                                    <a href="<?= BASE_URL_NAME ?>/admin/products?page=<?= $totalPages ?>" 
                                    class="px-3 py-1 bg-gray-200 text-gray-700 rounded hover:bg-gray-300">
                                        <?= $totalPages ?>
                                    </a>
                                </li>
                            <?php endif; ?>

                            <!-- Nút "Trang sau" -->
                            <?php if ($currentPage < $totalPages): ?>
                                <li>
                                    <a href="<?= BASE_URL_NAME ?>/admin/products?page=<?= $currentPage + 1 ?>" 
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
    function confirmDelete(productId) {
        // Sử dụng SweetAlert để hiển thị hộp thoại xác nhận
        Swal.fire({
            title: 'Bạn có chắc chắn muốn xóa sản phẩm này?',
            text: "Hành động này không thể hoàn tác.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Có, xóa nó!',
            cancelButtonText: 'Không, hủy bỏ!',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                // Nếu người dùng nhấn "Có, xóa nó!"
                document.getElementById('delete-form-' + productId).submit();
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