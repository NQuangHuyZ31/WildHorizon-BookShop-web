<?php

namespace App\Models;

use PDO;

class OrderReview extends Model
{
  protected $table = 'order_reviews';
  protected $primary_key = 'id';

  public function insert($data)
  {
    $query = "INSERT INTO $this->table(user_id,order_id,rating_id,comment,created_at) values(?,?,?,?,?)";

    $stmt = $this->db->prepare($query);
    $stmt->bindValue(1, $data['user_id'], PDO::PARAM_INT);
    $stmt->bindValue(2, $data['order_id'], PDO::PARAM_INT);
    $stmt->bindValue(3, $data['rating_id'], PDO::PARAM_INT);
    $stmt->bindValue(4, $data['comment'], PDO::PARAM_STR);
    $stmt->bindValue(5, $data['created_at']);

    return $stmt->execute();
  }

  public function find($orderID)
  {
    $query = "SELECT *FROM $this->table WHERE order_id = ?";
    $stmt = $this->db->prepare($query);
    $stmt->bindValue(1, $orderID, PDO::PARAM_INT);
    $stmt->execute();

    return $stmt->fetch(PDO::FETCH_ASSOC);
  }

  // Lấy theo userId 
  public function getOrderReviewByUserID($userID)
  {
    $query = "SELECT *FROM $this->table WHERE user_id = ? order by created_at desc";
    $stmt = $this->db->prepare($query);
    $stmt->bindValue(1, $userID, PDO::PARAM_INT);
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }
}
