<?php

namespace App\Models;

use PDO;

class OTPVerify extends Model
{
  protected $table = 'otp_verifies';
  protected $primary_key = 'id';

  public function insert($data)
  {
    $query = "INSERT INTO $this->table(user_id, otp_code, expired, type, created_at) values(?,?,?,?,?)";
    $stmt = $this->db->prepare($query);
    $stmt->bindValue(1, $data['user_id'], PDO::PARAM_INT);
    $stmt->bindValue(2, $data['otp_code'], PDO::PARAM_STR);
    $stmt->bindValue(3, $data['expired'], PDO::PARAM_INT);
    $stmt->bindValue(4, $data['type'], PDO::PARAM_STR);
    $stmt->bindValue(5, $data['created_at'], PDO::PARAM_STR);

    return $stmt->execute();
  }

  public function getOTP($userID, $expired)
  {
    if ($expired == false) {
      $query = "SELECT id, otp_code, expired, created_at FROM $this->table WHERE user_id = ? and is_verify = 0 order by created_at desc limit 1";
    } else {
      $time = time();
      $query = "SELECT id, otp_code, expired, created_at FROM $this->table WHERE user_id = ? and expired > $time order by created_at desc limit 1";
    }
    $stmt = $this->db->prepare($query);
    $stmt->bindValue(1, $userID, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
  }

  public function update($userID, $otpID, $value, $column)
  {
    $query = "UPDATE $this->table set $column = ?, updated_at = ? WHERE id = ? and user_id = ?";
    $stmt = $this->db->prepare($query);
    $stmt->bindValue(1, $value, PDO::PARAM_INT);
    $stmt->bindValue(2, date('Y-m-d H:i:s'));
    $stmt->bindValue(3, $otpID, PDO::PARAM_INT);
    $stmt->bindValue(4, $userID, PDO::PARAM_INT);

    return $stmt->execute();
  }
}
