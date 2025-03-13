<?php

namespace App\Models;

class OrderShippingAddress extends Model
{

  protected $table = 'order_shipping_addresses';
  protected $primary_key = 'id';
  public function insert($data, $orderID)
  {

    $query = "INSERT INTO $this->table(order_id,full_name,phone,province,district,ward,address_line1) values (?,?,?,?,?,?,?)";
    $stmt = $this->db->prepare($query);
    $stmt->bindValue(1, $orderID, \PDO::PARAM_INT);
    $stmt->bindValue(2, $data['fullname']);
    $stmt->bindValue(3, $data['phone']);
    $stmt->bindValue(4, $data['province']);
    $stmt->bindValue(5, $data['district']);
    $stmt->bindValue(6, $data['ward']);
    $stmt->bindValue(7, $data['address']);

    $stmt->execute();
  }
}
