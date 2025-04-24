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
            <div class="bg-white p-8 rounded-lg shadow-lg">
                <!-- Search Bar -->
                <div class="flex justify-between items-center mb-6">
                    <form action="<?= BASE_URL ?>/admin/orders" method="GET" class="relative w-1/2 max-w-[400px]">
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
                            value="<?= htmlspecialchars($_GET['search'] ?? '') ?>" />
                        <!-- Nút tìm kiếm -->
                        <button
                            type="submit"
                            class="absolute right-2 top-1/2 transform -translate-y-1/2 bg-blue-500 text-white px-3 py-1 rounded-lg hover:bg-blue-600 focus:ring-4 focus:outline-none focus:ring-blue-300">
                            Tìm kiếm
                        </button>
                    </form>
                </div>

                <!-- Orders Table -->
                <div class="overflow-x-auto">
                    <table class="min-w-full">
                        <thead>
                            <tr class="text-left text-sm text-gray-700 uppercase">
                                <th class="py-3 px-4 border-b text-center">Mã đơn hàng</th>
                                <th class="py-3 px-4 border-b text-center">Ngày đặt hàng</th>
                                <th class="py-3 px-4 border-b text-center">Khách hàng</th>
                                <th class="py-3 px-4 border-b text-center">Trạng thái</th>
                                <th class="py-3 px-4 border-b text-center">Hành động</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($orders as $order): ?>
                                <?php $encryptedId = \Core\Encrypt::encryptId($order['id'], KEY); ?>
                                <tr>
                                    <td class="py-3 border-b text-center text-gray-800"><?= htmlspecialchars($order['id']) ?></td>
                                    <td class="py-3 border-b text-center text-gray-800"><?= date('d-m-Y', strtotime($order['order_date'])) ?></td>
                                    <td class="py-3 border-b text-center text-gray-800"><?= htmlspecialchars($order['username'] ?? 'Admin') ?></td>
                                    <td class="py-3 border-b text-center">
                                        <form method="POST" action="<?= BASE_URL . '/admin/orders/update' ?>" id="order-form-<?= $encryptedId ?>">
                                            <input type="hidden" name="order_id" value="<?= $encryptedId ?>">
                                            <select name="status" class="px-3 py-1 text-xs font-semibold text-gray-700 rounded-full border focus:outline-none focus:ring-2 focus:ring-indigo-300" onchange="confirmUpdate('<?= $encryptedId ?>')" onclick="event.stopPropagation()">
                                                <option value="Chờ xác nhận" <?= $order['status'] == 'Chờ xác nhận' ? 'selected' : '' ?>>Chờ xác nhận</option>
                                                <option value="Chuẩn bị hàng" <?= $order['status'] == 'Chuẩn bị hàng' ? 'selected' : '' ?>>Chuẩn bị hàng</option>
                                                <option value="Đang giao hàng" <?= $order['status'] == 'Đang giao hàng' ? 'selected' : '' ?>>Đang giao hàng</option>
                                                <option value="Đã giao hàng" <?= $order['status'] == 'Đã giao hàng' ? 'selected' : '' ?>>Đã giao hàng</option>
                                            </select>
                                        </form>
                                    </td>
                                    <td class="py-3 border-b text-center">
                                        <a href="<?= BASE_URL . '/admin/orders/detail?id=' . $encryptedId ?>" class="text-indigo-600 hover:text-indigo-800 font-semibold">Xem</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="mt-6 flex justify-center">
                    <nav aria-label="Pagination">
                        <ul class="flex space-x-2">
                            <?php if ($currentPage > 1): ?>
                                <li>
                                    <a href="<?= BASE_URL ?>/admin/orders?page=<?= $currentPage - 1 ?>" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition duration-200">Trước</a>
                                </li>
                            <?php endif; ?>

                            <?php for ($i = max(1, $currentPage - 2); $i <= min($totalPages, $currentPage + 2); $i++): ?>
                                <li>
                                    <a href="<?= BASE_URL ?>/admin/orders?page=<?= $i ?>" class="px-4 py-2 <?= $i == $currentPage ? 'bg-indigo-600 text-white' : 'bg-gray-200 text-gray-700' ?> rounded-lg hover:bg-indigo-500 hover:text-white transition duration-200"><?= $i ?></a>
                                </li>
                            <?php endfor; ?>

                            <?php if ($currentPage < $totalPages): ?>
                                <li>
                                    <a href="<?= BASE_URL ?>/admin/orders?page=<?= $currentPage + 1 ?>" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition duration-200">Sau</a>
                                </li>
                            <?php endif; ?>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <?php include VIEW_PATH . 'admin/layout/footer.php'; ?>

    <script>
        function confirmUpdate(safeId) {
            Swal.fire({
                title: 'Xác nhận thay đổi trạng thái?',
                text: "Bạn có chắc chắn muốn cập nhật trạng thái đơn hàng này?",
                icon: 'info',
                showCancelButton: true,
                confirmButtonText: 'Thay đổi',
                cancelButtonText: 'Hủy bỏ',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('order-form-' + safeId).submit();
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
</body>

</html>
