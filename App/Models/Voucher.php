<?php

namespace App\Models;

use PDO;

class Voucher extends Model
{
  protected $table = 'vouchers';
  protected $primary_key = 'id';


  public function getAll()
  {
    $query = "SELECT v.id, v.name, v.description, v.code, v.type, v.discount_type, v.discount_value, v.min_order_value,
    v.max_discount_amount, v.start_date, v.end_date, v.quantity, v.status
    FROM $this->table v WHERE v.end_date > now() and v.status = 'active'";
    $stmt = $this->db->prepare($query);
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }

  public function getAllByUser($userID)
  {
    $query = "SELECT *FROM $this->table v join user_vouchers uv on v.id = uv.voucher_id WHERE user_id = ? and end_date > now() ";
    $stmt = $this->db->prepare($query);
    $stmt->bindValue(1, $userID, PDO::PARAM_INT);
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }

  // public function getByType($userID, $type)
  // {
  //   $query = "SELECT *FROM $this->table v join user_vouchers uv on v.id = uv.voucher_id WHERE user_id = ? and type = ? and end_date > now() ";
  //   $stmt = $this->db->prepare($query);
  //   $stmt->bindValue(1, $userID, PDO::PARAM_INT);
  //   $stmt->bindValue(2, $type, PDO::PARAM_STR);
  //   $stmt->execute();

  //   return $stmt->fetchAll(PDO::FETCH_ASSOC);
  // }

  public function findByID($voucherID)
  {
    $query = "SELECT *FROM $this->table WHERE id = ?  and end_date > now() and status = 'active'";
    $stmt = $this->db->prepare($query);
    $stmt->bindValue(1, $voucherID, PDO::PARAM_INT);
    $stmt->execute();

    return $stmt->fetch(PDO::FETCH_ASSOC);
  }
}
