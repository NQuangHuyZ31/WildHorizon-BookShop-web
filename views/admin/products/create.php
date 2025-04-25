<?php include VIEW_PATH . 'admin/layout/layout.php'; ?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thêm Sản phẩm</title>
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
                <form action="<?= BASE_URL ?>/admin/products/create" method="POST" enctype="multipart/form-data">
                    <div class="grid grid-cols-1 gap-6">
                        <!-- Name Field -->
                        <div>
                            <label for="product_name" class="block text-gray-700 font-semibold mb-2">Tên Sản Phẩm</label>
                            <input type="text" id="product_name" name="product_name" value="<?= isset($_POST['product_name']) ? htmlspecialchars($_POST['product_name']) : '' ?>" class="w-full px-4 py-2 border <?= isset($errors['product_name']) ? 'border-red-500' : 'border-gray-300' ?> rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Nhập tên sản phẩm">
                            <?php if (isset($errors['product_name'])): ?>
                                <p class="text-red-500 text-sm mt-2"><?= $errors['product_name'] ?></p>
                            <?php endif; ?>
                        </div>

                        <!-- Description Field -->
                        <div>
                            <label for="description" class="block text-gray-700 font-semibold mb-2">Mô Tả</label>
                            <textarea id="description" name="description" rows="4" class="w-full px-4 py-2 border <?= isset($errors['description']) ? 'border-red-500' : 'border-gray-300' ?> rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Nhập mô tả về sản phẩm"><?= isset($_POST['description']) ? htmlspecialchars($_POST['description']) : '' ?></textarea>
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
                                    <option value="<?= $catalog['id'] ?>" <?= isset($_POST['catalog_id']) && $_POST['catalog_id'] == $catalog['id'] ? 'selected' : '' ?>><?= htmlspecialchars($catalog['catalog_name']) ?></option>
                                <?php endforeach; ?>
                            </select>
                            <?php if (isset($errors['catalog_id'])): ?>
                                <p class="text-red-500 text-sm mt-2"><?= $errors['catalog_id'] ?></p>
                            <?php endif; ?>
                        </div>

                        <!-- Price Field -->
                        <div>
                            <label for="price" class="block text-gray-700 font-semibold mb-2">Giá</label>
                            <input type="number" id="price" name="price" step="0.01" value="<?= isset($_POST['price']) ? htmlspecialchars($_POST['price']) : '' ?>" class="w-full px-4 py-2 border <?= isset($errors['price']) ? 'border-red-500' : 'border-gray-300' ?> rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Nhập giá sản phẩm">
                            <?php if (isset($errors['price'])): ?>
                                <p class="text-red-500 text-sm mt-2"><?= $errors['price'] ?></p>
                            <?php endif; ?>
                        </div>

                        <!-- Discount Field -->
                        <div>
                            <label for="discount_price" class="block text-gray-700 font-semibold mb-2">Giảm Giá (%)</label>
                            <input type="number" id="discount_price" name="discount_price" step="0.01" value="<?= isset($_POST['discount_price']) ? htmlspecialchars($_POST['discount_price']) : '' ?>" class="w-full px-4 py-2 border <?= isset($errors['discount_price']) ? 'border-red-500' : 'border-gray-300' ?> rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Nhập % giảm giá">
                            <?php if (isset($errors['discount_price'])): ?>
                                <p class="text-red-500 text-sm mt-2"><?= $errors['discount_price'] ?></p>
                            <?php endif; ?>
                        </div>

                        <!-- Stock Field -->
                        <div>
                            <label for="stock" class="block text-gray-700 font-semibold mb-2">Số Lượng</label>
                            <input type="number" id="stock" name="stock" value="<?= isset($_POST['stock']) ? htmlspecialchars($_POST['stock']) : '' ?>" class="w-full px-4 py-2 border <?= isset($errors['stock']) ? 'border-red-500' : 'border-gray-300' ?> rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Nhập số lượng">
                            <?php if (isset($errors['stock'])): ?>
                                <p class="text-red-500 text-sm mt-2"><?= $errors['stock'] ?></p>
                            <?php endif; ?>
                        </div>

                        <!-- Image Field -->
                        <div>
                            <label for="product_image" class="block text-gray-700 font-semibold mb-2">Ảnh Sản Phẩm</label>

                            <div class="flex items-center justify-center w-full">
                                <label for="product_image" class="flex flex-col items-center justify-center w-full h-64 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-white hover:bg-gray-100 relative">
                                    <div class="flex flex-col items-center justify-center pt-5 pb-6" id="upload-placeholder">
                                        <svg class="w-10 h-10 mb-4 text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 16">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2" />
                                        </svg>
                                        <p class="mb-2 text-sm text-gray-500"><span class="font-semibold">Click để tải lên</span></p>
                                        <p class="text-xs text-gray-500">Định dạng: SVG, PNG, JPG, GIF (Tối đa 800x400px)</p>
                                    </div>
                                    <img id="preview-image" src="" alt="Xem trước ảnh" class="hidden max-h-60 max-w-full object-contain mx-auto my-auto">
                                    <input id="product_image" name="product_image" type="file" class="hidden" accept="image/*" onchange="previewImage(event)">
                                </label>
                            </div>

                            <!-- Hiển thị lỗi -->
                            <?php if (isset($errors['product_image'])): ?>
                                <p class="text-red-500 text-sm mt-2"><?= $errors['product_image'] ?></p>
                            <?php endif; ?>
                        </div>

                        <!-- Author Field -->
                        <div>
                            <label for="author" class="block text-gray-700 font-semibold mb-2">Tác Giả</label>
                            <input type="text" id="author" name="author" value="<?= isset($_POST['author']) ? htmlspecialchars($_POST['author']) : '' ?>" class="w-full px-4 py-2 border <?= isset($errors['author']) ? 'border-red-500' : 'border-gray-300' ?> rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Nhập tên tác giả">
                            <?php if (isset($errors['author'])): ?>
                                <p class="text-red-500 text-sm mt-2"><?= $errors['author'] ?></p>
                            <?php endif; ?>
                        </div>

                        <!-- Publish Year Field -->
                        <div>
                            <label for="publication_year" class="block text-gray-700 font-semibold mb-2">Năm Sản Xuất Hoặc Năm Xuất Bản</label>
                            <select id="publication_year" name="publication_year"
                                class="w-full px-4 py-2 border <?= isset($errors['publication_year']) ? 'border-red-500' : 'border-gray-300' ?> rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <option value="">Chọn năm xuất bản hoặc năm sản xuất</option>
                                <?php
                                $currentYear = date('Y');
                                for ($year = $currentYear; $year >= 2010; $year--): ?>
                                    <option value="<?= $year ?>" <?= (isset($_POST['publication_year']) && $_POST['publication_year'] == $year) ? 'selected' : '' ?>><?= $year ?></option>
                                <?php endfor; ?>
                            </select>
                            <?php if (isset($errors['publication_year'])): ?>
                                <p class="text-red-500 text-sm mt-2"><?= $errors['publication_year'] ?></p>
                            <?php endif; ?>
                        </div>

                        <!-- Supplier Field -->
                        <div>
                            <label for="supplier_id" class="block text-gray-700 font-semibold mb-2">Nhà Cung Cấp</label>
                            <select id="supplier_id" name="supplier_id" class="w-full px-4 py-2 border <?= isset($errors['supplier_id']) ? 'border-red-500' : 'border-gray-300' ?> rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <option value="">Chọn nhà cung cấp</option>
                                <?php foreach ($suppliers as $supplier): ?>
                                    <option value="<?= $supplier['id'] ?>" <?= isset($_POST['supplier_id']) && $_POST['supplier_id'] == $supplier['id'] ? 'selected' : '' ?>><?= htmlspecialchars($supplier['supplier_name']) ?></option>
                                <?php endforeach; ?>
                            </select>
                            <?php if (isset($errors['supplier_id'])): ?>
                                <p class="text-red-500 text-sm mt-2"><?= $errors['supplier_id'] ?></p>
                            <?php endif; ?>
                        </div>


                        <!-- Brand Field -->
                        <div>
                            <label for="brand_id" class="block text-gray-700 font-semibold mb-2">Thương Hiệu</label>
                            <select id="brand_id" name="brand_id" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <option value="">Chọn thương hiệu</option>
                                <?php foreach ($brands as $brand): ?>
                                    <option value="<?= $brand['id'] ?>" <?= isset($_POST['brand_id']) && $_POST['brand_id'] == $brand['id'] ? 'selected' : '' ?>><?= htmlspecialchars($brand['brand_name']) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <!-- Color Field -->
                        <div>
                            <label for="color" class="block text-gray-700 font-semibold mb-2">Màu Sắc</label>
                            <input type="text" id="color" name="color" value="<?= isset($_POST['color']) ? htmlspecialchars($_POST['color']) : '' ?>" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Nhập màu sắc">
                        </div>

                        <!-- Publisher Field -->
                        <div>
                            <label for="publisher" class="block text-gray-700 font-semibold mb-2">Nhà Xuất Bản</label>
                            <input type="text" id="publisher" name="publisher" value="<?= isset($_POST['publisher']) ? htmlspecialchars($_POST['publisher']) : '' ?>" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Nhập tên nhà xuất bản">
                        </div>

                        <!-- Origin Field -->
                        <div>
                            <label for="origin" class="block text-gray-700 font-semibold mb-2">Nơi Sản Xuất</label>
                            <input type="text" id="origin" name="origin" value="<?= isset($_POST['origin']) ? htmlspecialchars($_POST['origin']) : '' ?>" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Nhập xuất xứ">
                        </div>

                        <!-- Language Field -->
                        <div>
                            <label for="language" class="block text-gray-700 font-semibold mb-2">Ngôn Ngữ</label>
                            <input type="text" id="language" name="language" value="<?= isset($_POST['language']) ? htmlspecialchars($_POST['language']) : '' ?>" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Nhập ngôn ngữ">
                        </div>

                        <!-- Submit Button -->
                        <div class="flex justify-end">
                            <button type="submit" class="bg-blue-500 text-white px-6 py-2 rounded-lg hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-400">
                                Thêm sản phẩm
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
    function previewImage(event) {
        const file = event.target.files[0];
        const reader = new FileReader();

        reader.onload = function() {
            const imgElement = document.getElementById("preview-image");
            const placeholder = document.getElementById("upload-placeholder");

            imgElement.src = reader.result;
            imgElement.classList.remove("hidden");
            placeholder.classList.add("hidden");
        };

        if (file) {
            reader.readAsDataURL(file);
        }
    }
</script>

</html>