<?php include VIEW_PATH . 'admin/layout/layout.php'; ?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thêm Flash Sale</title>
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
                <h1 class="text-2xl font-bold mb-6 text-gray-800">Thêm Flash Sale</h1>

                <form action="<?= BASE_URL ?>/admin/flash-sales/create" method="POST" enctype="multipart/form-data">
                    <div class="grid grid-cols-1 gap-6">

                        <!-- Product Field -->
                        <div>
                            <label for="product_name" class="block text-gray-700 font-semibold mb-2">Sản Phẩm</label>
                            <input list="product-list" id="product_name" name="product_name"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                                placeholder="Nhập tên sản phẩm..."
                                value="<?= isset($_POST['product_name']) ? htmlspecialchars($_POST['product_name']) : '' ?>">

                            <?php if (isset($errors['product_id'])): ?>
                                <p class="text-red-500 text-sm mt-2"><?= $errors['product_id'] ?></p>
                            <?php endif; ?>

                            <datalist id="product-list">
                                <?php foreach ($products as $product): ?>
                                    <option value="<?= htmlspecialchars($product['product_name']) ?>" data-id="<?= $product['id'] ?>"></option>
                                <?php endforeach; ?>
                            </datalist>

                            <input type="hidden" id="product_id" name="product_id" value="<?= isset($_POST['product_id']) ? htmlspecialchars($_POST['product_id']) : '' ?>">
                        </div>

                        <!-- Discount Price -->
                        <div>
                            <label for="discount_price" class="block text-gray-700 font-semibold mb-2">Phần Trăm Giảm (%)</label>
                            <input type="number" id="discount_price" name="discount_price" value="<?= $_POST['discount_price'] ?? '' ?>" class="w-full px-4 py-2 border <?= isset($errors['discount_price']) ? 'border-red-500' : 'border-gray-300' ?> rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Nhập phần trăm giảm">
                            <?php if (isset($errors['discount_price'])): ?>
                                <p class="text-red-500 text-sm mt-2"><?= $errors['discount_price'] ?></p>
                            <?php endif; ?>
                        </div>

                        <!-- Quantity -->
                        <div>
                            <label for="quantity" class="block text-gray-700 font-semibold mb-2">Số Lượng</label>
                            <input type="number" id="quantity" name="quantity" value="<?= $_POST['quantity'] ?? '' ?>" class="w-full px-4 py-2 border <?= isset($errors['quantity']) ? 'border-red-500' : 'border-gray-300' ?> rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Nhập số lượng sản phẩm">
                            <?php if (isset($errors['quantity'])): ?>
                                <p class="text-red-500 text-sm mt-2"><?= $errors['quantity'] ?></p>
                            <?php endif; ?>
                        </div>

                        <!-- Start Date -->
                        <div>
                            <label for="start_date" class="block text-gray-700 font-semibold mb-2">Ngày Bắt Đầu</label>
                            <input type="date" id="start_date" name="start_date" value="<?= $_POST['start_date'] ?? '' ?>" class="w-full px-4 py-2 border <?= isset($errors['date']) ? 'border-red-500' : 'border-gray-300' ?> rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>

                        <!-- End Date -->
                        <div>
                            <label for="end_date" class="block text-gray-700 font-semibold mb-2">Ngày Kết Thúc</label>
                            <input type="date" id="end_date" name="end_date" value="<?= $_POST['end_date'] ?? '' ?>" class="w-full px-4 py-2 border <?= isset($errors['date']) ? 'border-red-500' : 'border-gray-300' ?> rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <?php if (isset($errors['date'])): ?>
                                <p class="text-red-500 text-sm mt-2"><?= $errors['date'] ?></p>
                            <?php endif; ?>
                        </div>

                        <!-- Submit Button -->
                        <div class="flex justify-end">
                            <button type="submit" class="bg-blue-500 text-white px-6 py-2 rounded-lg hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-400">
                                Thêm Flash Sale
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <?php include VIEW_PATH . 'admin/layout/footer.php'; ?>
</body>

<script>
    document.getElementById("product_name").addEventListener("change", function() {
        let options = document.querySelectorAll("#product-list option");
        let input = this.value;
        let productIdInput = document.getElementById("product_id");

        options.forEach(option => {
            if (option.value === input) {
                productIdInput.value = option.getAttribute("data-id");
            }
        });
    });
</script>
</html>