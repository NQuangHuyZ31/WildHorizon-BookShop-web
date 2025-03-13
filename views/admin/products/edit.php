<?php include VIEW_PATH . 'admin/layout/layout.php'; ?>


<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chỉnh Sửa Sản Phẩm</title>
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
                <?php $encryptedId = \Core\Encrypt::encryptId($product['product_id'], KEY); ?>
                <form action="<?= BASE_URL_NAME ?>/admin/products/edit?id=<?= $encryptedId ?>" method="POST" enctype="multipart/form-data">
                    <div class="grid grid-cols-1 gap-6">
                        <!-- Name Field -->
                        <div>
                            <label for="name" class="block text-gray-700 font-semibold mb-2">Tên Sản Phẩm</label>
                            <input type="text" id="name" name="name" value="<?= isset($product['name']) ? htmlspecialchars($product['name']) : '' ?>" class="w-full px-4 py-2 border <?= isset($errors['name']) ? 'border-red-500' : 'border-gray-300' ?> rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Nhập tên sản phẩm">
                            
                            <?php if (isset($errors['name'])): ?>
                                <p class="text-red-500 text-sm mt-2"><?= $errors['name'] ?></p>
                            <?php endif; ?>
                        </div>

                        <!-- Description Field -->
                        <div>
                            <label for="description" class="block text-gray-700 font-semibold mb-2">Mô Tả</label>
                            <textarea id="description" name="description" rows="4" class="w-full px-4 py-2 border <?= isset($errors['description']) ? 'border-red-500' : 'border-gray-300' ?> rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Nhập mô tả về sản phẩm"><?= isset($product['description']) ? htmlspecialchars($product['description']) : '' ?></textarea>
                            
                            <?php if (isset($errors['description'])): ?>
                                <p class="text-red-500 text-sm mt-2"><?= $errors['description'] ?></p>
                            <?php endif; ?>
                        </div>

                        <!-- Catalog Field -->
                        <div>
                            <label for="catalog_id" class="block text-gray-700 font-semibold mb-2">Danh Mục</label>
                            <select id="catalog_id" name="catalog_id" class="w-full px-4 py-2 border <?= isset($errors['catalog_id']) ? 'border-red-500' : 'border-gray-300' ?> rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <option value="">Chọn danh mục</option>
                                <?php foreach ($catalogs as $catalog): ?>
                                    <option value="<?= $catalog['catalog_id'] ?>" <?= isset($product['catalog_id']) && $product['catalog_id'] == $catalog['catalog_id'] ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($catalog['name']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>

                            <?php if (isset($errors['catalog_id'])): ?>
                                <p class="text-red-500 text-sm mt-2"><?= $errors['catalog_id'] ?></p>
                            <?php endif; ?>
                        </div>

                        <!--Author Field -->
                        <div>
                            <label for="author" class="block text-gray-700 font-semibold mb-2">Tác giả</label>
                            <input type="text" id="author" name="author" value="<?= isset($product['author']) ? htmlspecialchars($product['author']) : '' ?>" class="w-full px-4 py-2 border <?= isset($errors['author']) ? 'border-red-500' : 'border-gray-300' ?> rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Nhập tác giả">
                        </div>
                        <!--Publish Year -->
                        <div>
                            <label for="publish_year" class="block text-gray-700 font-semibold mb-2">Năm xuất bản</label>
                            <select id="publish_year" name="publish_year" 
                                    class="w-full px-4 py-2 border <?= isset($errors['publish_year']) ? 'border-red-500' : 'border-gray-300' ?> rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <option value="">Chọn năm xuất bản</option>
                                <?php
                                $currentYear = date('Y');
                                for ($year = $currentYear; $year >= 2010; $year--): ?>
                                    <option value="<?= $year ?>" <?= (isset($product['publish_year']) && $product['publish_year'] == $year) ? 'selected' : '' ?>><?= $year ?></option>
                                <?php endfor; ?>
                            </select>
                            <?php if (isset($errors['publish_year'])): ?>
                                <p class="text-red-500 text-sm mt-2"><?= $errors['publish_year'] ?></p>
                            <?php endif; ?>
                        </div>
                        <!--Color Field -->
                        <div>
                            <label for="color" class="block text-gray-700 font-semibold mb-2">Màu Sắc</label>
                            <input type="text" id="color" name="color" value="<?= isset($product['color']) ? htmlspecialchars($product['color']) : '' ?>" class="w-full px-4 py-2 border <?= isset($errors['color']) ? 'border-red-500' : 'border-gray-300' ?> rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Nhập màu sắc">
                            <?php if (isset($errors['color'])): ?>
                                <p class="text-red-500 text-sm mt-2"><?= $errors['color'] ?></p>
                            <?php endif; ?>
                        </div>
                        <!-- Price Field -->
                        <div>
                            <label for="price" class="block text-gray-700 font-semibold mb-2">Giá</label>
                            <input type="number" id="price" name="price" value="<?= isset($product['price']) ? htmlspecialchars($product['price']) : '' ?>" class="w-full px-4 py-2 border <?= isset($errors['price']) ? 'border-red-500' : 'border-gray-300' ?> rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Nhập giá sản phẩm">

                            <?php if (isset($errors['price'])): ?>
                                <p class="text-red-500 text-sm mt-2"><?= $errors['price'] ?></p>
                            <?php endif; ?>
                        </div>

                        <!-- Stock Field -->
                        <div>
                            <label for="stock" class="block text-gray-700 font-semibold mb-2">Tồn Kho</label>
                            <input type="number" id="stock" name="stock" value="<?= isset($product['stock']) ? htmlspecialchars($product['stock']) : '' ?>" class="w-full px-4 py-2 border <?= isset($errors['stock']) ? 'border-red-500' : 'border-gray-300' ?> rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Nhập số lượng tồn kho">

                            <?php if (isset($errors['stock'])): ?>
                                <p class="text-red-500 text-sm mt-2"><?= $errors['stock'] ?></p>
                            <?php endif; ?>
                        </div>

                        <!-- Image Field -->
                        <div>
                            <label for="image" class="block text-gray-700 font-semibold mb-2">Hình Ảnh</label>
                            <input type="file" id="image" name="image" class="w-full px-4 py-2 border <?= isset($errors['image']) ? 'border-red-500' : 'border-gray-300' ?> rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">

                            <?php if (isset($errors['image'])): ?>
                                <p class="text-red-500 text-sm mt-2"><?= $errors['image'] ?></p>
                            <?php endif; ?>

                            <!-- Hiển thị ảnh hiện tại -->
                            <?php if (!empty($product['image'])): ?>
                                <img src="<?= BASE_URL_NAME . '/Public/upload/products/' . htmlspecialchars($product['image']) ?>" alt="Hình sản phẩm" class="mt-4 w-32 h-32 object-cover rounded-lg">
                            <?php endif; ?>
                        </div>

                        <!-- Submit Button -->
                        <div class="flex justify-end">
                            <button type="submit" class="bg-blue-500 text-white px-6 py-2 rounded-lg hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-400">
                                Cập Nhật Sản Phẩm
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
