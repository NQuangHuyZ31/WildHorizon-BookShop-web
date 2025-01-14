<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Quản lý Đơn hàng</title>
    
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
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-semibold text-gray-800">Quản lý Đơn hàng</h2>
                </div>
                <div>
                    <table class="min-w-full table-auto border-collapse border border-gray-200 rounded-lg">
                        <thead>
                            <tr class="bg-gray-50">
                                <th class="py-3 px-4 border border-gray-200 text-center text-sm font-medium text-gray-600 uppercase tracking-wide">Mã đơn hàng</th>
                                <th class="py-3 px-4 border border-gray-200 text-center text-sm font-medium text-gray-600 uppercase tracking-wide">Ngày đặt hàng</th>
                                <th class="py-3 px-4 border border-gray-200 text-center text-sm font-medium text-gray-600 uppercase tracking-wide">Phương thức thanh toán</th>
                                <th class="py-3 px-4 border border-gray-200 text-center text-sm font-medium text-gray-600 uppercase tracking-wide">Trạng thái</th>
                                <!-- <th class="py-3 px-4 border border-gray-200 text-center text-sm font-medium text-gray-600 uppercase tracking-wide">Hành động</th> -->
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($orders as $order): ?>
                                <tr 
                                    class="hover:bg-gray-100 cursor-pointer" 
                                    onclick="window.location.href='<?= BASE_URL . '/admin/orders/detail?id=' . $order['order_id'] ?>';"
                                >
                                    <td class="py-3 px-4 border border-gray-200 text-center text-gray-700">
                                        <?= htmlspecialchars($order['order_id']) ?>
                                    </td>
                                    <td class="py-3 px-4 border border-gray-200 text-center text-gray-700">
                                        <?= htmlspecialchars($order['order_date']) ?>
                                    </td>
                                    <td class="py-3 px-4 border border-gray-200 text-center text-gray-700">
                                        <?= htmlspecialchars($order['payment_method']) ?>
                                    </td>
                                    <td class="py-3 px-4 border border-gray-200 text-center">
                                        <?php 
                                            $statusClass = '';
                                            switch ($order['status']) {
                                                case 'Chờ xác nhận':
                                                    $statusClass = 'bg-gray-100 text-gray-700';
                                                    break;
                                                case 'Đang chuẩn bị hàng':
                                                    $statusClass = 'bg-blue-100 text-blue-700';
                                                    break;
                                                case 'Đang giao hàng':
                                                    $statusClass = 'bg-yellow-100 text-yellow-700';
                                                    break;
                                                case 'Đã giao hàng':
                                                    $statusClass = 'bg-green-100 text-green-700';
                                                    break;
                                                default:
                                                    $statusClass = 'bg-red-100 text-red-700'; // Trạng thái không xác định
                                                    break;
                                            }
                                        ?>
                                        <span class="px-3 py-1 text-xs font-semibold rounded-full <?= $statusClass ?>">
                                            <?= htmlspecialchars($order['status']) ?>
                                        </span>
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
                                        <a href="<?= BASE_URL_NAME ?>/admin/orders?page=<?= $currentPage - 1 ?>" 
                                        class="px-3 py-1 bg-gray-200 text-gray-700 rounded hover:bg-gray-300">
                                            Trước
                                        </a>
                                    </li>
                                <?php endif; ?>

                                <!-- Hiển thị trang đầu tiên nếu không phải trang 1 -->
                                <?php if ($currentPage > 3): ?>
                                    <li>
                                        <a href="<?= BASE_URL_NAME ?>/admin/orders?page=1" 
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
                                        <a href="<?= BASE_URL_NAME ?>/admin/orders?page=<?= $i ?>" 
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
                                        <a href="<?= BASE_URL_NAME ?>/admin/orders?page=<?= $totalPages ?>" 
                                        class="px-3 py-1 bg-gray-200 text-gray-700 rounded hover:bg-gray-300">
                                            <?= $totalPages ?>
                                        </a>
                                    </li>
                                <?php endif; ?>

                                <!-- Nút "Trang sau" -->
                                <?php if ($currentPage < $totalPages): ?>
                                    <li>
                                        <a href="<?= BASE_URL_NAME ?>/admin/orders?page=<?= $currentPage + 1 ?>" 
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
    </div>

    <?php include VIEW_PATH . 'admin/layout/footer.php'; ?>
</body>


</html>
