<?php include VIEW_PATH . 'admin/layout/layout.php'; ?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <title>Chi tiết Đơn hàng - <?= htmlspecialchars($order['id']) ?></title>
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
                    <h2 class="text-2xl font-semibold text-gray-800">Chi tiết Đơn hàng #<?= htmlspecialchars($order['id']) ?></h2>
                </div>

                <!-- Thông tin khách hàng -->
                <div class="mb-6">
                    <h3 class="text-xl font-semibold">Thông tin Khách hàng</h3>
                    <ul>
                        <li><strong>Tên khách hàng:</strong> <?= htmlspecialchars($user['firstname'] . ' ' . $user['lastname']) ?></li>
                        <li><strong>Số điện thoại:</strong> <?= htmlspecialchars($shippingAddress['phone']) ?></li>
                        <li><strong>Địa chỉ nhận hàng:</strong> <?= htmlspecialchars($shippingAddress['address_line1'] . ', ' . $shippingAddress['ward'] . ', ' . $shippingAddress['district'] . ', ' . $shippingAddress['province']) ?></li>
                    </ul>
                </div>
                
                <div class="mt-6">

                    <?php
                    // Các trạng thái đơn hàng theo thứ tự
                    $statuses = [
                        'Chờ xác nhận',
                        'Chuẩn bị hàng',
                        'Đang giao hàng',
                        'Đã giao hàng'
                    ];

                    // Lấy trạng thái hiện tại
                    $currentStatus = $order['status'];

                    // Tìm vị trí trạng thái hiện tại trong danh sách
                    $currentIndex = array_search($currentStatus, $statuses);
                    ?>

                    <!-- Thanh tiến trình -->
                    <div class="relative h-2 bg-gray-300 rounded-lg overflow-hidden">
                        <div
                            class="absolute top-0 left-0 h-full bg-blue-500 transition-all duration-300"
                            style="width: <?= (($currentIndex + 1) / count($statuses)) * 100 ?>%;">
                        </div>
                    </div>

                    <!-- Danh sách trạng thái -->
                    <div class="flex justify-between mt-4 text-sm font-medium">
                        <?php foreach ($statuses as $index => $status): ?>
                            <div class="flex flex-col items-center">
                                <!-- Vòng tròn trạng thái -->
                                <div class="<?= $index <= $currentIndex ? 'bg-blue-500' : 'bg-gray-300' ?> 
                                            w-6 h-6 flex items-center justify-center rounded-full text-white font-bold">
                                    <?= $index + 1 ?>
                                </div>
                                <!-- Tên trạng thái -->
                                <span
                                    class="mt-2 <?= $index <= $currentIndex ? 'text-blue-600' : 'text-gray-500' ?>">
                                    <?= htmlspecialchars($status) ?>
                                </span>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
                <!-- Chi tiết đơn hàng -->
                <div class="mb-6 mt-6">
                    <table class="min-w-full table-auto border-collapse border border-gray-200 rounded-lg">
                        <thead>
                            <tr class="bg-gray-50">
                                <th class="py-3 px-4 border border-gray-200 text-center text-sm font-medium text-gray-600 uppercase tracking-wide">Thứ tự</th>
                                <th class="py-3 px-4 border border-gray-200 text-center text-sm font-medium text-gray-600 uppercase tracking-wide">Tên sản phẩm</th>
                                <th class="py-3 px-4 border border-gray-200 text-center text-sm font-medium text-gray-600 uppercase tracking-wide">Số lượng</th>
                                <th class="py-3 px-4 border border-gray-200 text-center text-sm font-medium text-gray-600 uppercase tracking-wide">Đơn giá</th>
                                <th class="py-3 px-4 border border-gray-200 text-center text-sm font-medium text-gray-600 uppercase tracking-wide">Tổng tiền</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($orderDetails as $index => $detail):
                            ?>
                                <tr class="hover:bg-gray-100">
                                    <td class="py-3 px-4 border border-gray-200 text-center text-gray-700"><?= $index + 1 ?></td>
                                    <td class="py-3 px-4 border border-gray-200 text-center text-gray-700">
                                        <img src="<?= BASE_URL . '/Public/upload/products/' . htmlspecialchars($detail['product_image']) ?>" alt="<?= htmlspecialchars($detail['product_name']) ?>" class="w-12 h-12 object-cover mx-auto">
                                        <p class="mt-2"><?= htmlspecialchars($detail['product_name']) ?></p>
                                    </td>
                                    <td class="py-3 px-4 border border-gray-200 text-center text-gray-700"><?= htmlspecialchars($detail['quantity']) ?></td>
                                    <td class="py-3 px-4 border border-gray-200 text-center text-gray-700"><?= number_format($detail['product_price'], 0, ',', '.') ?> VND</td>
                                    <td class="py-3 px-4 border border-gray-200 text-center text-gray-700"><?= number_format($detail['total'], 0, ',', '.') ?> VND</td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

                <!-- Tổng giá sản phẩm -->
                <div class="flex justify-between items-center mb-2">
                    <h3 class="text-xl font-semibold">Tổng tiền:</h3>
                    <p class="text-xl text-gray-800"><?= number_format($order['total_price'] - $order['shipping_fee'], 0, ',', '.') ?> VND</p>
                </div>

                <!-- Tiền ship -->
                <div class="flex justify-between items-center mb-2">
                    <h3 class="text-xl font-semibold">Tiền ship:</h3>
                    <p class="text-xl text-gray-800"><?= number_format($order['shipping_fee'], 0, ',', '.') ?> VND</p>
                </div>

                <!-- Tổng giá -->
                <div class="flex justify-between items-center mb-2">
                    <h3 class="text-xl font-semibold">Tổng giá đơn hàng:</h3>
                    <p class="text-xl text-gray-800"><?= number_format($order['total_price'], 0, ',', '.') ?> VND</p>
                </div>

            </div>
        </div>
    </div>

    <?php include VIEW_PATH . 'admin/layout/footer.php'; ?>
</body>

</html>