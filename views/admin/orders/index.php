<?php

use Core\Session;

$messge = Session::get('message') ?? [];
// Session::delete('message');
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
                            value="<?= htmlspecialchars($_GET['search'] ?? '') ?>" />
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
                                <?php $encryptedId = \Core\Encrypt::encryptId($order['id'], KEY); ?>
                                <tr
                                    class="hover:bg-gray-100 cursor-pointer"
                                    onclick="window.location.href='<?= BASE_URL . '/admin/orders/detail?id=' . $encryptedId ?>';">
                                    <td class="py-3 px-4 border border-gray-200 text-center text-gray-700">
                                        <?= htmlspecialchars($order['id']) ?>
                                    </td>
                                    <td class="py-3 px-4 border border-gray-200 text-center text-gray-700">
                                        <?= date('d-m-Y', strtotime($order['order_date'])) ?? date('d-m-Y') ?>
                                    </td>
                                    <td class="py-3 px-4 border border-gray-200 text-center text-gray-700">
                                        <?= htmlspecialchars($order['payment_method']) ?>
                                    </td>

                                    <td class="py-3 px-4 border border-gray-200 text-center">
                                        <form method="POST" action="<?= BASE_URL . '/admin/orders/update' ?>" id="order-form-<?= $encryptedId ?>">
                                            <input type="hidden" name="order_id" value="<?= $encryptedId ?>">
                                            <input type="hidden" name="page" value="<?= $_GET['page'] ?? 1 ?>">
                                            <select name="status" class="px-3 py-1 text-xs font-semibold rounded-full" onchange="confirmUpdate('<?= $encryptedId ?>')" onclick="event.stopPropagation()">
                                                <option value="Chờ xác nhận" <?= $order['status'] == 'Chờ xác nhận' ? 'selected' : '' ?>>Chờ xác nhận</option>
                                                <option value="Chuẩn bị hàng" <?= $order['status'] == 'Chuẩn bị hàng' ? 'selected' : '' ?>>Chuẩn bị hàng</option>
                                                <option value="Đang giao hàng" <?= $order['status'] == 'Đang giao hàng' ? 'selected' : '' ?>>Đang giao hàng</option>
                                                <option value="Đã giao hàng" <?= $order['status'] == 'Đã giao hàng' ? 'selected' : '' ?>>Đã giao hàng</option>
                                            </select>
                                        </form>
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

<script>
    var safeId = <?php echo json_encode($encryptedId); ?>;
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
</html>