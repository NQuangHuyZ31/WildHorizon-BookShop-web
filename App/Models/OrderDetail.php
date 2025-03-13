<?php

namespace App\Models;

class OrderDetail extends Model
{

  protected $table = 'order_details';
  protected $primary_key = 'id';
  public function insert($data)
  {
    $query = "INSERT INTO $this->table(order_id, product_id, quantity, price, total) values(?,?,?,?,?)";
    $stmt = $this->db->prepare($query);
    $stmt->bindValue(1, $data['order_id'], \PDO::PARAM_INT);
    $stmt->bindValue(2, $data['product_id'], \PDO::PARAM_INT);
    $stmt->bindValue(3, $data['quantity'], \PDO::PARAM_INT);
    $stmt->bindValue(4, $data['price'], \PDO::PARAM_INT);
    $stmt->bindValue(5, $data['total'], \PDO::PARAM_INT);
    $stmt->execute();
  }
}
