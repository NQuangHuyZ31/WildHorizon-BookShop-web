<?php

namespace App\Models;

use App\Models\Model;
use PDO;

class Reviews extends Model
{

  protected $table = 'product_reviews';
  protected $primary_key = 'id';

  public function getAll()
  {

    $query = "SELECT *FROM $this->table rw join users u on rw.user_id = u.id";

    $stmt = $this->db->prepare($query);

    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }

  // insert
  public function insert($data)
  {
    $query = "INSERT INTO $this->table(user_id, product_id, order_id, rating_id, comment, created_at) values(?,?,?,?,?,?)";
    $stmt = $this->db->prepare($query);
    $stmt->bindValue(1, $data['user_id'], PDO::PARAM_INT);
    $stmt->bindValue(2, $data['product_id'], PDO::PARAM_INT);
    $stmt->bindValue(3, $data['order_id'], PDO::PARAM_INT);
    $stmt->bindValue(4, $data['rating_id'], PDO::PARAM_INT);
    $stmt->bindValue(5, $data['comment'], PDO::PARAM_STR);
    $stmt->bindValue(6, $data['created_at']);

    return $stmt->execute();
  }

  // Tìm kiếm theo id sản phẩm
  public function find($productID)
  {

    $query = "SELECT rw.created_at, u.username, p.product_name, comment, rw.rating_id FROM $this->table rw join 
              products p on rw.product_id = p.id join users u on rw.user_id = u.id 
              where rw.product_id = ? order by rw.rating_id DESC";

    $stmt = $this->db->prepare($query);

    $stmt->bindValue(1, $productID);

    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }

  // lấy rating sản phẩm
  public function getRatingProduct($productID)
  {
    $query = "SELECT r.score, r.id AS rating_id,
                COUNT(prw.rating_id) AS count,
                (COUNT(prw.rating_id) * 100 / NULLIF((SELECT COUNT(*) FROM product_reviews WHERE product_id = ?), 0)) AS per
                FROM ratings r LEFT JOIN product_reviews prw ON prw.rating_id = r.id AND prw.product_id = ?
                WHERE r.id BETWEEN 1 AND 5 GROUP BY r.id ORDER BY r.id DESC";

    $stmt = $this->db->prepare($query);

    $stmt->bindValue(1, $productID, PDO::PARAM_INT);

    $stmt->bindValue(2, $productID, PDO::PARAM_INT);

    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }

  // lấy rating trung bình sản phẩm
  public function getAvgProduct($productID)
  {

    $query = "SELECT avg(rating_id) as avgRating FROM product_reviews WHERE product_id = ?";

    $stmt = $this->db->prepare($query);

    $stmt->bindValue(1, $productID);

    $stmt->execute();

    return $stmt->fetch(PDO::FETCH_ASSOC);
  }

  // Lấy review sản phẩm theo order
  public function getProductReviewByOrder($orderID)
  {
    $query = "SELECT pr.product_id, pr.rating_id, pr.comment, p.product_name, p.product_image FROM $this->table pr JOIN products p on pr.product_id = p. id WHERE order_id = ?";
    $stmt = $this->db->prepare($query);
    $stmt->bindValue(1, $orderID, PDO::PARAM_INT);
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }
}
