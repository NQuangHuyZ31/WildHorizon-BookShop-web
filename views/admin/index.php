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
            <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6 mb-8">
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
            <div class="dashboard-stats">
                <!-- <h2 class="text-xl font-semibold mb-4">Thống kê doanh thu</h2>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div class="p-4 bg-white rounded-lg shadow-md">
                        <h3 class="text-lg font-semibold">Doanh thu hôm nay</h3>
                        <p class="text-2xl"><?= number_format($dailyRevenue, 0, ',', '.') ?> VND</p>
                    </div>
                    <div class="p-4 bg-white rounded-lg shadow-md">
                        <h3 class="text-lg font-semibold">Doanh thu tháng này</h3>
                        <p class="text-2xl"><?= number_format($monthlyRevenue, 0, ',', '.') ?> VND</p>
                    </div>
                    <div class="p-4 bg-white rounded-lg shadow-md">
                        <h3 class="text-lg font-semibold">Doanh thu năm nay</h3>
                        <p class="text-2xl"><?= number_format($yearlyRevenue, 0, ',', '.') ?> VND</p>
                    </div>
                </div> -->

                <!-- Biểu đồ doanh thu -->
                <div class="p-6 mt-6 bg-white rounded-lg shadow-md">
                    <h3 class="text-lg font-semibold mb-4">Biểu đồ doanh thu</h3>
                    <canvas id="revenueChart"></canvas>
                </div>
            </div>



        </div>
    </div>

    <?php include('layout/footer.php'); ?>
</body>
<script>
    var ctx = document.getElementById('revenueChart').getContext('2d');
    var revenueChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: ['Hôm nay', 'Tháng này', 'Năm nay'],
            datasets: [{
                label: 'Doanh thu',
                data: [<?= $dailyRevenue ?>, <?= $monthlyRevenue ?>, <?= $yearlyRevenue ?>],
                borderColor: 'rgb(75, 192, 192)',
                fill: false,
            }]
        },
        options: {
            responsive: true,
            scales: {
                x: {
                    beginAtZero: true
                },
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script>

</html>