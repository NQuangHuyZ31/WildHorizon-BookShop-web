<?php include VIEW_PATH . 'admin/layout/layout.php'; ?>

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
                <form action="<?= BASE_URL_NAME ?>/admin/orders" method="GET" class="relative w-1/2 max-w-[400px]">
                        <!-- Icon search -->
                        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                            <i class="fas fa-search text-gray-500"></i>
                        </div>
                        <!-- Input -->
                        <input
                            type="search"
                            name="search"
                            class="block w-full p-4 pl-10 pr-20 text-sm text-gray-900 border border-gray-300 rounded-lg focus:ring-blue-500 focus:outline-none focus:border-blue-500"
                            placeholder="Tìm kiếm đơn hàng"
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
                                <?php $encryptedId = \Core\Encrypt::encryptId($order['order_id'], KEY); ?>
                                <tr
                                    class="hover:bg-gray-100 cursor-pointer"
                                    onclick="window.location.href='<?= BASE_URL . '/admin/orders/detail?id=' . $encryptedId ?>';">
                                    <td class="py-3 px-4 border border-gray-200 text-center text-gray-700">
                                        <?= htmlspecialchars($order['order_id']) ?>
                                    </td>
                                    <td class="py-3 px-4 border border-gray-200 text-center text-gray-700">
                                        <?= htmlspecialchars($order['order_date']) ?>
                                    </td>
                                    <td class="py-3 px-4 border border-gray-200 text-center text-gray-700">
                                        <?php
                                        if (htmlspecialchars($order['payment_method']) === 'cash') {
                                            echo 'Thanh toán khi nhận hàng';
                                        } elseif (htmlspecialchars($order['payment_method']) === 'bank') {
                                            echo 'Chuyển khoản ngân hàng';
                                        } elseif (htmlspecialchars($order['payment_method']) === 'momo') {
                                            echo 'Thanh toán qua ví điện tử MOMO';
                                        } else {
                                            echo 'Phương thức thanh toán không xác định';
                                        }
                                        ?>
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