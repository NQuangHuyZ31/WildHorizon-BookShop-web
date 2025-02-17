<!-- index.php -->
<?php include VIEW_PATH . 'admin/layout/layout.php'; ?>

<title>Admin Dashboard</title>

<body class="font-sans bg-gray-100">

    <div class="flex min-h-screen">
        <!-- Sidebar -->
        <?php include('layout/sidebar.php'); ?>

        <!-- Main Content -->
        <div class="flex-1 p-8 overflow-auto">
            <!-- Top Header -->
            <?php include('layout/header.php'); ?>            

            <!-- Statistics Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
                <!-- Card 1 -->
                <div class="bg-white rounded-lg shadow-lg p-6">
                    <div class="flex items-center space-x-4">
                        <div class="bg-indigo-500 text-white p-3 rounded-full flex items-center justify-center w-12 h-12">
                            <i class="fa-solid fa-users text-2xl"></i>
                        </div>
                        <div>
                            <h3 class="text-xl font-semibold">Tổng số người dùng</h3>
                            <p class="text-gray-700 text-3xl"><?= $totalCustomers ?></p>
                        </div>
                    </div>
                </div>

                <!-- Card 2 -->
                <div class="bg-white rounded-lg shadow-lg p-6">
                    <div class="flex items-center space-x-4">
                        <div class="bg-green-500 text-white p-3 rounded-full flex items-center justify-center w-12 h-12">
                            <i class="fa-solid fa-box-open text-2xl"></i>
                        </div>
                        <div>
                            <h3 class="text-xl font-semibold">Sản phẩm đang bán</h3>
                            <p class="text-gray-700 text-3xl"><?= $totalProducts ?></p>
                        </div>
                    </div>
                </div>

                <!-- Card 3 -->
                <div class="bg-white rounded-lg shadow-lg p-6">
                    <div class="flex items-center space-x-4">
                        <div class="bg-blue-500 text-white p-3 rounded-full flex items-center justify-center w-12 h-12">
                            <i class="fa-solid fa-box text-2xl"></i>
                        </div>
                        <div>
                            <h3 class="text-xl font-semibold">Đơn hàng chưa xử lý</h3>
                            <p class="text-gray-700 text-3xl"><?= $pendingOrders ?></p>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Recent Activity Table -->
            <div class="bg-white rounded-lg shadow-lg p-6">
                <h3 class="text-2xl font-semibold mb-4">Hoạt động gần đây</h3>
                <div class="flex flex-col">
                    <div class="-m-1.5 overflow-x-auto">
                        <div class="p-1.5 min-w-full inline-block align-middle">
                            <div class="overflow-hidden">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead>
                                        <tr>
                                            <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase">Ngày</th>
                                            <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase">Mô tả</th>
                                            <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase">Trạng thái</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-200">
                                        <tr class="hover:bg-gray-100">
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800">01/01/2025</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">Thêm sản phẩm mới</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-green-500">Hoàn thành</td>
                                        </tr>
                                        <tr class="hover:bg-gray-100">
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800">02/01/2025</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">Đơn hàng đã được xử lý</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-blue-500">Đang xử lý</td>
                                        </tr>
                                        <tr class="hover:bg-gray-100">
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800">03/01/2025</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">Cập nhật cài đặt hệ thống</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-yellow-500">Chờ xử lý</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <?php include('layout/footer.php'); ?>
</body>
</html>
