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

  public function getOrderDetailByOrderID($orderID)
  {
    $query = "SELECT od.order_id, od.quantity, od.price as order_detail_price, p.product_name, p.price as product_price, p.product_image
     FROM $this->table od JOIN products p on od.product_id = p.id WHERE od.order_id = ?";
    $stmt = $this->db->prepare($query);
    $stmt->bindValue(1, $orderID, \PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll(\PDO::FETCH_ASSOC);
  }
}
