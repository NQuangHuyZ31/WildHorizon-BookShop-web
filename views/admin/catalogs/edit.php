<?php include VIEW_PATH . 'admin/layout/layout.php'; ?>


<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chỉnh Sửa Danh Mục</title>
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
                <?php $encryptedId = \Core\Encrypt::encryptId($catalog['catalog_id'], KEY); ?>
                <form action="<?= BASE_URL_NAME ?>/admin/catalogs/edit?id=<?= $encryptedId ?>" method="POST">
                    <div class="grid grid-cols-1 gap-6">
                        <!-- Name Field -->
                        <div>
                            <label for="name" class="block text-gray-700 font-semibold mb-2">Tên Danh Mục</label>
                            <input type="text" id="name" name="name" value="<?= isset($catalog['name']) ? htmlspecialchars($catalog['name']) : '' ?>" class="w-full px-4 py-2 border <?= isset($errors['name']) ? 'border-red-500' : 'border-gray-300' ?> rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Nhập tên danh mục">
                            
                            <?php if (isset($errors['name'])): ?>
                                <p class="text-red-500 text-sm mt-2"><?= $errors['name'] ?></p>
                            <?php endif; ?>
                        </div>

                        <!-- Description Field -->
                        <div>
                            <label for="description" class="block text-gray-700 font-semibold mb-2">Mô Tả</label>
                            <textarea id="description" name="description" rows="4" class="w-full px-4 py-2 border <?= isset($errors['description']) ? 'border-red-500' : 'border-gray-300' ?> rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Nhập mô tả về danh mục"><?= isset($catalog['description']) ? htmlspecialchars($catalog['description']) : '' ?></textarea>
                            
                            <?php if (isset($errors['description'])): ?>
                                <p class="text-red-500 text-sm mt-2"><?= $errors['description'] ?></p>
                            <?php endif; ?>
                        </div>

                        <!-- Submit Button -->
                        <div class="flex justify-end">
                            <button type="submit" class="bg-blue-500 text-white px-6 py-2 rounded-lg hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-400">
                                Cập Nhật Danh Mục
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
