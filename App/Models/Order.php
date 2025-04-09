<?php

namespace App\Models;

class Order extends Model
{
  protected $table = 'orders';
  protected $primary_key = 'id';

  public function insert($data)
  {
    $query = "INSERT INTO $this->table (user_id, total_price, shipping_fee, payment_method, status, order_date) 
                  VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $this->db->prepare($query);
    $stmt->bindValue(1, $data['user_id'], \PDO::PARAM_INT);
    $stmt->bindValue(2, $data['total_price'], \PDO::PARAM_STR);
    $stmt->bindValue(3, $data['shipping_fee'], \PDO::PARAM_STR);
    $stmt->bindValue(4, $data['payment_method'], \PDO::PARAM_STR);
    $stmt->bindValue(5, $data['status'], \PDO::PARAM_STR);
    $stmt->bindValue(6, $data['order_date'], \PDO::PARAM_STR);

    if ($stmt->execute()) {
      return $this->db->lastInsertId(); // Trả về ID của đơn hàng vừa tạo
    } else {
      return false; // Trả về false nếu có lỗi
    }
  }

  public function getCountOrder($userID)
  {

    $query = "SELECT count(id) as countorder FROM orders WHERE user_id = ? and year(order_date) = year(CURRENT_DATE)";

    $stmt = $this->db->prepare($query);
    $stmt->bindValue(1, $userID, \PDO::PARAM_INT);
    $stmt->execute();

    return $stmt->fetch(\PDO::FETCH_ASSOC);
  }

  public function getSumTotalOrder($userID)
  {

    $query = "SELECT sum(total_price) as totalprice FROM orders WHERE user_id = ? and year(order_date) = year(CURRENT_DATE) and status = 'Đã giao hàng'";

    $stmt = $this->db->prepare($query);
    $stmt->bindValue(1, $userID, \PDO::PARAM_INT);
    $stmt->execute();

    return $stmt->fetch(\PDO::FETCH_ASSOC);
  }
}
