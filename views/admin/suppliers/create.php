<?php include VIEW_PATH . 'admin/layout/layout.php'; ?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thêm Nhà Cung Cấp</title>
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
                <form action="<?= BASE_URL_NAME ?>/admin/suppliers/create" method="POST" enctype="multipart/form-data">
                    <div class="grid grid-cols-1 gap-6">
                        <!-- Supplier Name -->
                        <div>
                            <label for="supplier_name" class="block text-gray-700 font-semibold mb-2">Tên Nhà Cung Cấp</label>
                            <input type="text" id="supplier_name" name="supplier_name" value="<?= isset($_POST['supplier_name']) ? htmlspecialchars($_POST['supplier_name']) : '' ?>" class="w-full px-4 py-2 border <?= isset($errors['supplier_name']) ? 'border-red-500' : 'border-gray-300' ?> rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Nhập tên nhà cung cấp">

                            <?php if (isset($errors['supplier_name'])): ?>
                                <p class="text-red-500 text-sm mt-2"><?= $errors['supplier_name'] ?></p>
                            <?php endif; ?>
                        </div>

                        <!-- Phone -->
                        <div>
                            <label for="phone" class="block text-gray-700 font-semibold mb-2">Số Điện Thoại</label>
                            <input type="text" id="phone" name="phone" value="<?= isset($_POST['phone']) ? htmlspecialchars($_POST['phone']) : '' ?>" class="w-full px-4 py-2 border <?= isset($errors['phone']) ? 'border-red-500' : 'border-gray-300' ?> rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Nhập số điện thoại">

                            <?php if (isset($errors['phone'])): ?>
                                <p class="text-red-500 text-sm mt-2"><?= $errors['phone'] ?></p>
                            <?php endif; ?>
                        </div>

                        <!-- Email -->
                        <div>
                            <label for="email" class="block text-gray-700 font-semibold mb-2">Email</label>
                            <input type="email" id="email" name="email" value="<?= isset($_POST['email']) ? htmlspecialchars($_POST['email']) : '' ?>" class="w-full px-4 py-2 border <?= isset($errors['email']) ? 'border-red-500' : 'border-gray-300' ?> rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Nhập email">

                            <?php if (isset($errors['email'])): ?>
                                <p class="text-red-500 text-sm mt-2"><?= $errors['email'] ?></p>
                            <?php endif; ?>
                        </div>

                        <!-- Address -->
                        <div>
                            <label for="address" class="block text-gray-700 font-semibold mb-2">Địa Chỉ</label>
                            <textarea id="address" name="address" rows="3" class="w-full px-4 py-2 border <?= isset($errors['address']) ? 'border-red-500' : 'border-gray-300' ?> rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Nhập địa chỉ nhà cung cấp"><?= isset($_POST['address']) ? htmlspecialchars($_POST['address']) : '' ?></textarea>

                            <?php if (isset($errors['address'])): ?>
                                <p class="text-red-500 text-sm mt-2"><?= $errors['address'] ?></p>
                            <?php endif; ?>
                        </div>

                        <!-- Submit Button -->
                        <div class="flex justify-end">
                            <button type="submit" class="bg-blue-500 text-white px-6 py-2 rounded-lg hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-400">
                                Thêm Nhà Cung Cấp
                            </button>
                        </div>
                    </div>
                </form>
            </div>

        </div>
    </div>

    <?php include VIEW_PATH . 'admin/layout/footer.php'; ?>
</body>

</html>
