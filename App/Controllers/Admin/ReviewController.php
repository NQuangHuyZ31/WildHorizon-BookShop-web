<?php

namespace App\Controllers\Admin;

use App\Controllers\Controller;
use Core\Session;
use Core\Encrypt;

class ReviewController extends Controller
{
    public function getAllReviews()
    {
        $currentPage = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
        $perPage = 15;
        $offset = ($currentPage - 1) * $perPage;

        // Lấy từ khóa tìm kiếm (nếu có)
        $search = isset($_GET['search']) ? trim($_GET['search']) : '';

        // Đếm tổng số đánh giá (có áp dụng tìm kiếm nếu có từ khóa)
        $countQuery = "SELECT COUNT(DISTINCT rv.product_id) AS sum 
                   FROM product_reviews rv 
                   JOIN products p ON rv.product_id = p.id 
                   WHERE p.product_name LIKE :search";
        $stmt = $this->db->prepare($countQuery);
        $searchParam = '%' . $search . '%';
        $stmt->bindParam(':search', $searchParam, \PDO::PARAM_STR);
        $stmt->execute();
        $totalReviews = $stmt->fetch(\PDO::FETCH_ASSOC)['sum'];

        $totalPages = ceil($totalReviews / $perPage);

        // Lấy danh sách đánh giá (có áp dụng tìm kiếm nếu có từ khóa)
        $query = "SELECT 
                p.id as product_id, 
                p.product_name, 
                p.product_image, 
                AVG(rt.score) AS average_rating, 
                COUNT(rv.id) AS total_reviews
              FROM product_reviews rv
              JOIN ratings rt ON rv.rating_id = rt.id
              JOIN products p ON rv.product_id = p.id
              WHERE p.product_name LIKE :search
              GROUP BY p.id, p.product_name, p.product_image
              ORDER BY average_rating DESC
              LIMIT :offset, :perPage";

        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':search', $searchParam, \PDO::PARAM_STR);
        $stmt->bindParam(':offset', $offset, \PDO::PARAM_INT);
        $stmt->bindParam(':perPage', $perPage, \PDO::PARAM_INT);
        $stmt->execute();

        $reviews = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        include_once VIEW_PATH . 'admin/reviews/index.php';
    }


    public function getReviewsByProduct()
    {
        $encryptedId = $_GET['id'] ?? null;
        $product_id = Encrypt::decryptId($encryptedId, KEY);

        $query = "SELECT * FROM products WHERE id = :product_id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':product_id', $product_id, \PDO::PARAM_INT);
        $stmt->execute();
        $product = $stmt->fetch(\PDO::FETCH_ASSOC);

        $query = "
            SELECT 
                pr.id AS review_id, 
                pr.created_at,
                pr.comment, 
                pr.status, 
                u.username, 
                r.score, 
                r.label, 
                p.product_name, 
                p.product_image 
            FROM product_reviews pr
            LEFT JOIN users u ON pr.user_id = u.id
            LEFT JOIN ratings r ON pr.rating_id = r.id
            LEFT JOIN products p ON pr.product_id = p.id
            WHERE pr.product_id = :product_id
            ORDER BY pr.created_at DESC
        ";

        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':product_id', $product_id, \PDO::PARAM_INT);
        $stmt->execute();
        $reviews = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        include_once VIEW_PATH . 'admin/reviews/reviews_product.php';
    }

    public function changeReviewStatus()
    {
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $review_id = $_POST['review_id'] ?? null;
            $new_status = $_POST['status'] ?? null;

            $query = "UPDATE product_reviews SET status = :new_status WHERE id = :review_id";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':new_status', $new_status, \PDO::PARAM_INT);
            $stmt->bindParam(':review_id', $review_id, \PDO::PARAM_INT);

            if ($stmt->execute()) {
                $statusText = $new_status == 1 ? 'hiện' : 'ẩn';
                Session::set('message', [
                    'success' => "Đã $statusText trạng thái đánh giá!"
                ]);
            } else {
                echo "Đã xảy ra lỗi khi Cập nhật trạng thái đánh giá.";
            }

            header('Location: ' . $_SERVER['HTTP_REFERER']);
            exit;
        }
    }
}
