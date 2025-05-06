<?php

namespace App\Models;

use PDO;

class UserVoucher extends Model
{
  protected $table = 'user_vouchers';
  protected $primary_key = 'id';


  public function getAllByUser($userID)
  {
    $query = "SELECT *FROM $this->table uv join vouchers v on uv.voucher_id = v.id WHERE user_id = ? and end_date > now() ";
    $stmt = $this->db->prepare($query);
    $stmt->bindValue(1, $userID, PDO::PARAM_INT);
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }

  public function getByType($userID, $type)
  {
    $query = "SELECT *FROM $this->table uv join vouchers v on uv.voucher_id = v.id WHERE user_id = ? and type = ? and end_date > now()";
    $stmt = $this->db->prepare($query);
    $stmt->bindValue(1, $userID, PDO::PARAM_INT);
    $stmt->bindValue(2, $type, PDO::PARAM_STR);

    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }
}
