<?php include VIEW_PATH . 'admin/layout/layout.php'; ?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chi tiết Đơn hàng - <?= htmlspecialchars($order['id']) ?></title>
</head>

<body class="bg-gray-100 font-sans">
    <div class="flex min-h-screen">
        <!-- Sidebar -->
        <?php include VIEW_PATH . 'admin/layout/sidebar.php'; ?>

        <!-- Main Content -->
        <div class="flex-1 p-6 md:p-10 overflow-auto">
            <?php include VIEW_PATH . 'admin/layout/header.php'; ?>

            <section class="bg-white p-8 rounded-xl shadow-lg">
                <!-- Header -->
                <h2 class="text-3xl font-bold text-gray-800 mb-4">Chi tiết Đơn hàng #<?= htmlspecialchars($order['id']) ?></h2>

                <!-- Grid: Order Info -->
                <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8 border-y py-6">
                    <div>
                        <p class="text-gray-500 mb-1">Ngày đặt hàng</p>
                        <p class="text-xl font-semibold text-black"><?= date('d/m/Y', strtotime($order['order_date'])) ?></p>
                    </div>
                    <div>
                        <p class="text-gray-500 mb-1">Khách hàng</p>
                        <p class="text-xl font-semibold text-black"><?= htmlspecialchars($user['username']) ?></p>
                    </div>
                    <div>
                        <p class="text-gray-500 mb-1">Số điện thoại</p>
                        <p class="text-xl font-semibold text-black"><?= htmlspecialchars($shippingAddress['phone']) ?></p>
                    </div>
                    <div>
                        <p class="text-gray-500 mb-1">Phương thức thanh toán</p>
                        <p class="text-xl font-semibold text-black"><?= htmlspecialchars($order['payment_method']) ?></p>
                    </div>
                    <div class="md:col-span-3">
                        <p class="text-gray-500 mb-1">Địa chỉ nhận hàng</p>
                        <p class="text-lg text-black">
                            <?= htmlspecialchars($shippingAddress['address_line1'] . ', ' . $shippingAddress['ward'] . ', ' . $shippingAddress['district'] . ', ' . $shippingAddress['province']) ?>
                        </p>
                    </div>
                </div>

                <!-- Progress Bar -->
                <?php
                $statuses = ['Chờ xác nhận', 'Chuẩn bị hàng', 'Đang giao hàng', 'Đã giao hàng'];
                $currentIndex = array_search($order['status'], $statuses);
                ?>
                <div class="relative h-2 bg-gray-300 rounded-lg overflow-hidden mb-4">
                    <div class="absolute top-0 left-0 h-full bg-blue-600" style="width: <?= (($currentIndex + 1) / count($statuses)) * 100 ?>%;"></div>
                </div>
                <div class="flex justify-between text-sm font-medium mb-10">
                    <?php foreach ($statuses as $index => $status): ?>
                        <div class="text-center">
                            <div class="w-6 h-6 rounded-full mx-auto mb-1 flex items-center justify-center text-white text-xs font-bold <?= $index <= $currentIndex ? 'bg-blue-600' : 'bg-gray-300' ?>">
                                <?= $index + 1 ?>
                            </div>
                            <div class="<?= $index <= $currentIndex ? 'text-blue-600' : 'text-gray-500' ?>">
                                <?= htmlspecialchars($status) ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

                <!-- Order Details Items -->
                <div class="space-y-6">
                    <?php foreach ($orderDetails as $detail): ?>
                        <div class="grid grid-cols-7 w-full border-b border-gray-100 pb-6">
                            <div class="col-span-7 min-[500px]:col-span-2 md:col-span-1">
                                <img src="<?= htmlspecialchars($detail['product_image']) ?>" alt="<?= htmlspecialchars($detail['product_name']) ?>" class="w-24 h-30 rounded-xl object-cover">
                            </div>
                            <div class="col-span-7 min-[500px]:col-span-5 md:col-span-6 max-sm:mt-5 flex flex-col justify-center">
                                <div class="flex flex-col min-[500px]:flex-row min-[500px]:items-center justify-between">
                                    <div>
                                        <h5 class="font-manrope font-semibold text-2xl leading-9 text-black mb-6"><?= htmlspecialchars($detail['product_name']) ?></h5>
                                        <p class="font-normal text-xl leading-8 text-gray-500">Số lượng: <span class="text-black font-semibold"><?= htmlspecialchars($detail['quantity']) ?></span></p>
                                    </div>
                                    <h5 class="font-semibold text-xl leading-8 text-gray-900 sm:text-right mt-3">
                                        <?= number_format($detail['total'], 0, ',', '.') ?> VND
                                    </h5>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

                <!-- Order Summary -->
                <div class="flex items-center justify-center sm:justify-end w-full my-6">
                    <div class="w-full max-w-xl">
                        <div class="flex items-center justify-between mb-6">
                            <p class="font-normal text-xl leading-8 text-gray-500">Tổng tiền hàng</p>
                            <p class="font-semibold text-xl leading-8 text-gray-900"><?= number_format($order['total_price'] - $order['shipping_fee'], 0, ',', '.') ?> VND</p>
                        </div>
                        <div class="flex items-center justify-between mb-6">
                            <p class="font-normal text-xl leading-8 text-gray-500">Phí vận chuyển</p>
                            <p class="font-semibold text-xl leading-8 text-gray-900"><?= number_format($order['shipping_fee'], 0, ',', '.') ?> VND</p>
                        </div>
                        <div class="flex items-center justify-between py-6 border-y border-gray-100">
                            <p class="font-manrope font-semibold text-2xl leading-9 text-gray-900">Tổng cộng</p>
                            <p class="font-manrope font-bold text-2xl leading-9 text-indigo-600"><?= number_format($order['total_price'], 0, ',', '.') ?> VND</p>
                        </div>
                    </div>
                </div>

            </section>
        </div>
    </div>

    <?php include VIEW_PATH . 'admin/layout/footer.php'; ?>
</body>

</html>