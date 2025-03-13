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
                <?php $encryptedId = \Core\Encrypt::encryptId($catalog['id'], KEY); ?>
                <form action="<?= BASE_URL_NAME ?>/admin/catalogs/edit?id=<?= $encryptedId ?>" method="POST" enctype="multipart/form-data">
                    <div class="grid grid-cols-1 gap-6">
                        <!-- Name Field -->
                        <div>
                            <label for="catalog_name" class="block text-gray-700 font-semibold mb-2">Tên Danh Mục</label>
                            <input type="text" id="catalog_name" name="catalog_name" value="<?= isset($catalog['catalog_name']) ? htmlspecialchars($catalog['catalog_name']) : '' ?>" class="w-full px-4 py-2 border <?= isset($errors['catalog_name']) ? 'border-red-500' : 'border-gray-300' ?> rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Nhập tên danh mục">
                            
                            <?php if (isset($errors['catalog_name'])): ?>
                                <p class="text-red-500 text-sm mt-2"><?= $errors['catalog_name'] ?></p>
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
                        
                        <!-- Image Field -->
                        <div>
                            <label for="catalog_image" class="block text-gray-700 font-semibold mb-2">Hình Ảnh</label>
                            <input type="file" id="catalog_image" name="catalog_image" class="w-full px-4 py-2 border <?= isset($errors['catalog_image']) ? 'border-red-500' : 'border-gray-300' ?> rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">

                            <?php if (isset($errors['catalog_image'])): ?>
                                <p class="text-red-500 text-sm mt-2"><?= $errors['catalog_image'] ?></p>
                            <?php endif; ?>

                            <!-- Hiển thị ảnh hiện tại -->
                            <?php if (!empty($catalog['catalog_image'])): ?>
                                <img src="<?= BASE_URL_NAME . '/Public/upload/catalogs/' . htmlspecialchars($catalog['catalog_image']) ?>" alt="Hình danh mục" class="mt-4 w-32 h-32 object-cover rounded-lg">
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
