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
                <form action="<?= BASE_URL ?>/admin/catalogs/edit?id=<?= $encryptedId ?>" method="POST" enctype="multipart/form-data">
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

                            <div class="flex items-center justify-center w-full">
                                <label for="catalog_image" class="flex flex-col items-center justify-center w-full h-64 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-white hover:bg-gray-100 relative">
                                    <div class="flex flex-col items-center justify-center pt-5 pb-6" id="upload-placeholder">
                                        <svg class="w-10 h-10 mb-4 text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 16">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2" />
                                        </svg>
                                        <p class="mb-2 text-sm text-gray-500"><span class="font-semibold">Click để tải lên</span></p>
                                        <p class="text-xs text-gray-500">Định dạng: SVG, PNG, JPG, GIF (Tối đa 800x400px)</p>
                                    </div>
                                    <img id="preview-image" src="" alt="Xem trước ảnh" class="hidden absolute inset-0 w-24 h-30 object-cover">
                                    <input id="catalog_image" name="catalog_image" type="file" class="hidden" accept="image/*" onchange="previewImage(event)">
                                </label>
                            </div>

                            <!-- Hiển thị lỗi -->
                            <?php if (isset($errors['catalog_image'])): ?>
                                <p class="text-red-500 text-sm mt-2"><?= $errors['catalog_image'] ?></p>
                            <?php endif; ?>

                            <!-- Hiển thị ảnh hiện tại -->
                            <?php if (!empty($catalog['catalog_image'])): ?>
                                <div class="mt-4">
                                    <p class="text-gray-600 text-sm mb-2">Ảnh hiện tại:</p>
                                    <img id="current-image" src="<?= BASE_URL_NAME . '/Public/upload/catalogs/' . htmlspecialchars($catalog['catalog_image']) ?>" alt="Hình danh mục" class="w-24 h-30 object-cover">
                                </div>

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
<script>
    function previewImage(event) {
        const file = event.target.files[0];
        const reader = new FileReader();

        reader.onload = function() {
            const imgElement = document.getElementById("preview-image");
            const placeholder = document.getElementById("upload-placeholder");
            const currentImage = document.getElementById("current-image");

            imgElement.src = reader.result;
            imgElement.classList.remove("hidden");
            placeholder.classList.add("hidden");

            // Ẩn ảnh hiện tại nếu có
            if (currentImage) {
                currentImage.style.display = "none";
            }
        };

        if (file) {
            reader.readAsDataURL(file);
        }
    }
</script>


</html>