<?php

namespace App\Models;

class OTPVerify extends Model
{
  protected $table = 'otp_verifies';
  protected $primary_key = 'id';

  public function insert($data)
  {
    $query = "INSERT INTO $this->table(user_id, otp_code, expired, type, created_at) values(?,?,?,?,?)";
    $stmt = $this->db->prepare($query);
    $stmt->bindValue(1, $data['user_id'], \PDO::PARAM_INT);
    $stmt->bindValue(2, $data['otp_code'], \PDO::PARAM_STR);
    $stmt->bindValue(3, $data['expired'], \PDO::PARAM_INT);
    $stmt->bindValue(4, $data['type'], \PDO::PARAM_STR);
    $stmt->bindValue(5, $data['created_at'], \PDO::PARAM_STR);

    return $stmt->execute();
  }
}
