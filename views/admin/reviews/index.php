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
            <div class="bg-white p-6 rounded-lg shadow-lg">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-2xl font-semibold text-gray-800">Quản lý Đánh giá</h2>
                    <form action="<?= BASE_URL_NAME ?>/admin/reviews" method="GET" class="relative w-1/2 max-w-[400px]">
                        <!-- Icon search -->
                        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                            <i class="fas fa-search text-gray-500"></i>
                        </div>
                        <!-- Input -->
                        <input
                            type="search"
                            name="search"
                            class="block w-full p-4 pl-10 pr-20 text-sm text-gray-900 border border-gray-300 rounded-lg focus:ring-blue-500 focus:outline-none focus:border-blue-500"
                            placeholder="Tìm kiếm sản phẩm hoặc danh mục..."
                            value="<?= htmlspecialchars($_GET['search'] ?? '') ?>"
                            />
                        <!-- Nút tìm kiếm -->
                        <button
                            type="submit"
                            class="absolute right-2 top-1/2 transform -translate-y-1/2 bg-blue-500 text-white px-3 py-1 rounded-lg hover:bg-blue-600 focus:ring-4 focus:outline-none focus:ring-blue-300">
                            Tìm kiếm
                        </button>
                    </form>
                </div>
                <table class="min-w-full bg-white">
                    <thead>
                        <tr>
                            <th class="py-2 px-4 border-b text-left text-gray-600" style="width: 30%">Tên sản phẩm</th>
                            <th class="py-2 px-4 border-b text-center text-gray-600" style="width: 25%">Hình ảnh</th>
                            <th class="py-2 px-4 border-b text-center text-gray-600" style="width: 10%">Điểm</th>
                            <th class="py-2 px-4 border-b text-center text-gray-600" style="width: 15%">Lượt đánh giá</th>
                            <th class="py-2 px-4 border-b text-center text-gray-600" style="width: 20%">Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($reviews as $review): ?>
                            <tr>
                                <td class="py-2 px-4 border-b"><?= htmlspecialchars($review['product_name']) ?></td>
                                <td class="py-2 px-4 border-b text-center">
                                    <img src="<?= BASE_URL ?>/Public/upload/products/<?= $review['product_image'] ?>" class="w-24 h-30 object-cover mx-auto" alt="<?= $review['product_name'] ?>">
                                </td>
                                <td class="py-2 px-4 border-b text-center"><?= htmlspecialchars(number_format($review['average_rating'], 2)) ?></td>
                                <td class="py-2 px-4 border-b text-center"><?= htmlspecialchars($review['total_reviews']) ?></td>
                                <td class="py-2 px-4 border-b text-center">
                                    <div class="flex justify-center space-x-4">
                                        <?php $encryptedId = \Core\Encrypt::encryptId($review['product_id'], KEY); ?>
                                        <a href="<?= BASE_URL_NAME ?>/admin/reviews/product?id=<?= $encryptedId ?>" class="text-blue-500 hover:text-blue-700">
                                            <i class="fas fa-eye"></i>
                                            <span>Xem đánh giá</span>
                                        </a>
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
                                    <a href="<?= BASE_URL_NAME ?>/admin/reviews?page=<?= $currentPage - 1 ?>"
                                        class="px-3 py-1 bg-gray-200 text-gray-700 rounded hover:bg-gray-300">
                                        Trước
                                    </a>
                                </li>
                            <?php endif; ?>

                            <!-- Hiển thị trang đầu tiên nếu không phải trang 1 -->
                            <?php if ($currentPage > 3): ?>
                                <li>
                                    <a href="<?= BASE_URL_NAME ?>/admin/reviews?page=1"
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
                                    <a href="<?= BASE_URL_NAME ?>/admin/reviews?page=<?= $i ?>"
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
                                    <a href="<?= BASE_URL_NAME ?>/admin/reviews?page=<?= $totalPages ?>"
                                        class="px-3 py-1 bg-gray-200 text-gray-700 rounded hover:bg-gray-300">
                                        <?= $totalPages ?>
                                    </a>
                                </li>
                            <?php endif; ?>

                            <!-- Nút "Trang sau" -->
                            <?php if ($currentPage < $totalPages): ?>
                                <li>
                                    <a href="<?= BASE_URL_NAME ?>/admin/reviews?page=<?= $currentPage + 1 ?>"
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


</html>