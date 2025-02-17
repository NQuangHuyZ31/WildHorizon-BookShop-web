<?php

namespace App\Models;

use App\Models\Model;

class Reviews extends Model
{

  protected $primary_key = 'review_id';
  protected $table = 'reviews';

  public function getAll()
  {

    $query = "SELECT *FROM $this->table rw join users u on rw.user_id = u.user_id";

    $stmt = $this->db->prepare($query);

    $stmt->execute();

    return $stmt->fetchAll(\PDO::FETCH_ASSOC);
  }

  // Tìm kiếm theo id sản phẩm
  public function find($productID)
  {

    $query = "SELECT rw.created_at, u.name as username, p.name as productname, comment, rating FROM $this->table rw join 
              products p on rw.product_id = p.product_id join users u on rw.user_id = u.user_id 
              where rw.product_id = ? and rw.rating >= 5 order by rw.rating DESC";

    $stmt = $this->db->prepare($query);

    $stmt->bindValue(1, $productID);

    $stmt->execute();

    return $stmt->fetchAll(\PDO::FETCH_ASSOC);
  }

  // lấy rating sản phẩm
  public function getRatingProduct($productID)
  {
    $query = "SELECT rating,  (COUNT(*) * 100 / (SELECT COUNT(*) FROM reviews WHERE product_id = ? and rating = 5)) AS per
                                          FROM reviews
                                          WHERE product_id = ? and rating = 5
                                          GROUP BY rating
                                          ORDER BY rating DESC";
    $stmt = $this->db->prepare($query);

    $stmt->bindValue(1, $productID, \PDO::PARAM_INT);

    $stmt->bindValue(2, $productID, \PDO::PARAM_INT);

    $stmt->execute();

    return $stmt->fetch(\PDO::FETCH_ASSOC);
  }

  // lấy rating trung bình sản phẩm
  public function getAvgProduct($productID) {}
}
