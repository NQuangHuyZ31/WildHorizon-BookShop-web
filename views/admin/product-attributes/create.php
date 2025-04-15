<?php include VIEW_PATH . 'admin/layout/layout.php'; ?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thêm Thuộc Tính Sản Phẩm</title>
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
                <form action="<?= BASE_URL ?>/admin/product-attributes/create" method="POST">
                    <div class="grid grid-cols-1 gap-6">

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

                        <!-- Dynamic Attributes -->
                        <div>
                            <label class="block text-gray-700 font-semibold mb-2">Thuộc Tính</label>
                            <?php if (isset($errors['general'])): ?>
                                <p class="text-red-500 text-sm mb-4"><?= $errors['general'] ?></p>
                            <?php endif; ?>

                            <div id="attributes-container">
                                <!-- Nếu có dữ liệu đã nhập trước đó, hiển thị lại -->
                                <?php if (!empty($_POST['attr_name'])): ?>
                                    <?php foreach ($_POST['attr_name'] as $index => $name): ?>
                                        <div class="flex flex-col space-y-2 mb-2">
                                            <div class="flex space-x-2">
                                                <input type="text" name="attr_name[]" value="<?= htmlspecialchars($name) ?>" class="w-1/3 px-4 py-2 border <?= isset($errors['attr_name'][$index]) ? 'border-red-500' : 'border-gray-300' ?> rounded-lg focus:ring-2 focus:ring-blue-500" placeholder="Tên thuộc tính">
                                                <input type="text" name="attr_value[]" value="<?= htmlspecialchars($_POST['attr_value'][$index]) ?>" class="w-1/3 px-4 py-2 border <?= isset($errors['attr_value'][$index]) ? 'border-red-500' : 'border-gray-300' ?> rounded-lg focus:ring-2 focus:ring-blue-500" placeholder="Giá trị">
                                                <button type="button" class="bg-red-500 text-white px-3 py-2 rounded-lg remove-attr hover:bg-red-600">X</button>
                                            </div>
                                            <?php if (isset($errors['attr_name'][$index])): ?>
                                                <p class="text-red-500 text-sm"><?= $errors['attr_name'][$index] ?></p>
                                            <?php endif; ?>
                                            <?php if (isset($errors['attr_value'][$index])): ?>
                                                <p class="text-red-500 text-sm"><?= $errors['attr_value'][$index] ?></p>
                                            <?php endif; ?>
                                        </div>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </div>
                            <button type="button" id="add-attribute" class="bg-green-500 text-white px-4 py-2 rounded-lg mt-2 hover:bg-green-600">
                                + Thêm thuộc tính
                            </button>
                        </div>


                        <!-- Submit Button -->
                        <div class="flex justify-end">
                            <button type="submit" class="bg-blue-500 text-white px-6 py-2 rounded-lg hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-400">
                                Thêm Thuộc Tính
                            </button>
                        </div>

                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const attributesContainer = document.getElementById("attributes-container");
            const addAttributeBtn = document.getElementById("add-attribute");

            addAttributeBtn.addEventListener("click", function() {
                const attributeRow = document.createElement("div");
                attributeRow.classList.add("flex", "flex-col", "space-y-2", "mb-2");
                attributeRow.innerHTML = `
                    <div class="flex space-x-2">
                        <input type="text" name="attr_name[]" class="w-1/3 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500" placeholder="Tên thuộc tính">
                        <input type="text" name="attr_value[]" class="w-1/3 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500" placeholder="Giá trị">
                        <button type="button" class="bg-red-500 text-white px-3 py-2 rounded-lg remove-attr hover:bg-red-600">X</button>
                    </div>
                `;
                attributesContainer.appendChild(attributeRow);
            });

            attributesContainer.addEventListener("click", function(e) {
                if (e.target.classList.contains("remove-attr")) {
                    e.target.parentElement.parentElement.remove();
                }
            });
        });
    </script>

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