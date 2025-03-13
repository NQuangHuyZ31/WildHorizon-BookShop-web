<?php

use Core\Session;

$messge = Session::get('message') ?? [];
// Session::delete('message');
?>
<?php include VIEW_PATH . 'admin/layout/layout.php'; ?>
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
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
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-2xl font-semibold text-gray-800">Đánh giá của sản phẩm #<?= htmlspecialchars($product['product_name']) ?></h2>
                    <img src="<?php echo BASE_URL_NAME ?>/Public/upload/products/<?php echo $product['product_image'] ?>" alt="<?= htmlspecialchars($product['product_name']) ?>" class="w-24 h-30 object-cover">
                </div>

                <table class="min-w-full bg-white">
                    <thead>
                        <tr>
                            <th class="py-2 px-4 border-b text-center text-gray-600">STT</th>
                            <th class="py-2 px-4 border-b text-left text-gray-600">Tên</th>
                            <th class="py-2 px-4 border-b text-center text-gray-600">Ngày</th>
                            <th class="py-2 px-4 border-b text-left text-gray-600">Nội dung</th>
                            <th class="py-2 px-4 border-b text-center text-gray-600">Điểm</th>
                            <th class="py-2 px-4 border-b text-center text-gray-600">Ẩn/Hiện</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($reviews as $key => $review) : ?>
                            <tr>
                                <td class="py-2 px-4 border-b text-center"><?= $key + 1 ?></td>
                                <td class="py-2 px-4 border-b"><?= htmlspecialchars($review['firstname'] . ' ' . $review['lastname']) ?></td>
                                <td class="py-2 px-4 border-b text-center"><?= htmlspecialchars($review['created_at']) ?></td>
                                <td class="py-2 px-4 border-b"><?= htmlspecialchars($review['comment']) ?></td>
                                <td class="py-2 px-4 border-b text-center"><?= htmlspecialchars($review['score']) ?></td>
                                <td class="py-2 px-4 border-b text-center">
                                    <form action="<?= BASE_URL_NAME ?>/admin/reviews/change-status" method="POST">
                                        <input type="hidden" name="review_id" value="<?= $review['review_id'] ?>">
                                        <input type="hidden" name="status" value="<?= $review['status'] == 1 ? 0 : 1 ?>">
                                        <button type="submit" class="text-xl text-gray-600 hover:text-blue-500">
                                            <i class="fas <?= $review['status'] == 1 ? 'fa-eye' : 'fa-eye-slash' ?>"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>

            </div>
        </div>
    </div>

    <?php include VIEW_PATH . 'admin/layout/footer.php'; ?>
</body>

<script>
    var messge = <?php echo json_encode($messge); ?>;

    if (messge.success) {
        toastr.success(messge.success);
    }
</script>

<?php
Session::delete('message');
?>

</html>