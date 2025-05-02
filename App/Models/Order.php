<?php

namespace App\Models;

use PDO;

class Order extends Model
{
  protected $table = 'orders';
  protected $primary_key = 'id';

  public function insert($data)
  {
    $query = "INSERT INTO $this->table (user_id, total_price, shipping_fee, payment_method, status, order_date) 
                  VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $this->db->prepare($query);
    $stmt->bindValue(1, $data['user_id'], PDO::PARAM_INT);
    $stmt->bindValue(2, $data['total_price'], PDO::PARAM_STR);
    $stmt->bindValue(3, $data['shipping_fee'], PDO::PARAM_STR);
    $stmt->bindValue(4, $data['payment_method'], PDO::PARAM_STR);
    $stmt->bindValue(5, $data['status'], PDO::PARAM_STR);
    $stmt->bindValue(6, $data['order_date'], PDO::PARAM_STR);

    $stmt->execute();
    return $this->db->lastInsertId();
  }

  // Lấy order theo order id
  public function getOrderByID($orderID, $userID)
  {
    $query = "SELECT *FROM $this->table WHERE id = ? and user_id = ?";
    $stmt = $this->db->prepare($query);
    $stmt->bindValue(1, $orderID, PDO::PARAM_INT);
    $stmt->bindValue(2, $userID, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
  }

  // Tìm đơn hàng theo user
  public function getOderByUser($userID)
  {
    $query = "SELECT *FROM $this->table WHERE user_id = ? order by status asc";
    $stmt = $this->db->prepare($query);
    $stmt->bindValue(1, $userID, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }

  // Tìm đơn hàng theo trạng thái
  public function getOderByStatus($userID, $status)
  {
    $query = "SELECT *FROM $this->table WHERE user_id = ? and status = ?";
    $stmt = $this->db->prepare($query);
    $stmt->bindValue(1, $userID, PDO::PARAM_INT);
    $stmt->bindValue(2, $status, PDO::PARAM_STR);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }

  public function getCountOrder($userID)
  {

    $query = "SELECT count(id) as countorder FROM orders WHERE user_id = ? and year(order_date) = year(CURRENT_DATE)";

    $stmt = $this->db->prepare($query);
    $stmt->bindValue(1, $userID, PDO::PARAM_INT);
    $stmt->execute();

    return $stmt->fetch(PDO::FETCH_ASSOC);
  }

  public function getSumTotalOrder($userID)
  {

    $query = "SELECT sum(total_price + shipping_fee) as totalprice FROM orders WHERE user_id = ? and year(order_date) = year(CURRENT_DATE) and is_payment = 1";

    $stmt = $this->db->prepare($query);
    $stmt->bindValue(1, $userID, PDO::PARAM_INT);
    $stmt->execute();

    return $stmt->fetch(PDO::FETCH_ASSOC);
  }

  // Cập nhật column
  public function updateColumn($orderID, $column, $value)
  {
    $query = "UPDATE $this->table set $column = ? WHERE id = ?";
    $stmt = $this->db->prepare($query);
    $stmt->bindValue(1, $value);
    $stmt->bindValue(2, $orderID);

    return $stmt->execute();
  }
}
