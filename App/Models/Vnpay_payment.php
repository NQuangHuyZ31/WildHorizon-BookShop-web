<?php

namespace App\Models;

use PDO;

class Vnpay_payment extends Model
{
  protected $table = 'vnpay_payments';
  protected $primary_key = 'id';

  public function insert($data)
  {
    $query = "INSERT INTO $this->table(order_id,vn_pay,created_at) values(?,?,?)";
    $stmt = $this->db->prepare($query);
    $stmt->bindValue(1, $data['order_id'], PDO::PARAM_INT);
    $stmt->bindValue(2, $data['vn_pay'], PDO::PARAM_STR);
    $stmt->bindValue(3, $data['created_at']);
    return $stmt->execute();
  }
}
