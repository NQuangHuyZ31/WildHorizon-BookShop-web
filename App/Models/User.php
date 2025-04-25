<?php

namespace App\Models;

use PDO;

class User extends Model
{

  protected $table = 'users';
  protected $primary_key = 'id';

  public function insert($data)
  {
    $query = "INSERT INTO $this->table(username,email,password,fb_id,status,created_at) values(?,?,?,?,?,?)";

    $stmt = $this->db->prepare($query);

    $stmt->bindValue(1, $data['username'], PDO::PARAM_STR);
    $stmt->bindValue(2, $data['email'], PDO::PARAM_STR);
    $stmt->bindValue(3, $data['password'], PDO::PARAM_STR);
    $stmt->bindValue(4, $data['fb_id']);
    $stmt->bindValue(5, $data['status']);
    $stmt->bindValue(6, date('Y-m-d H:i:s'));
    $stmt->execute();
    return $this->db->lastInsertId();
  }

  public function find($userID)
  {

    $query = "SELECT id, username, gender, birthday, email, phone, fb_id FROM $this->table WHERE id = ?  and role = 'customer'";

    $stmt = $this->db->prepare($query);

    $stmt->bindValue(1, $userID, PDO::PARAM_INT);

    $stmt->execute();

    return $stmt->fetch(PDO::FETCH_ASSOC) ?? null;
  }

  public function checkEmail($email, $status)
  {
    $query = "SELECT *FROM $this->table where email = ? and status = ? and role = 'customer'";
    $stmt = $this->db->prepare($query);
    $stmt->bindValue(1, $email);
    $stmt->bindValue(2, $status);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
  }

  public function updateInfoUser($data, $userID)
  {
    $query = "UPDATE $this->table SET username = ?, gender = ?, birthday = ?, phone = ?, updated_at = ? WHERE id = ?";

    $stmt = $this->db->prepare($query);
    $stmt->bindValue(1, $data['username'], PDO::PARAM_STR);
    $stmt->bindValue(2, $data['gender'], PDO::PARAM_INT);
    $stmt->bindValue(3, $data['birthday'], PDO::PARAM_STR);
    $stmt->bindValue(4, $data['phone'], PDO::PARAM_STR);
    $stmt->bindValue(5, date('Y-m-d'));
    $stmt->bindValue(6, $userID, PDO::PARAM_INT);
    return $stmt->execute();
  }

  // Lấy passord người dùng
  public function getColumn($column, $userID)
  {
    $query = "SELECT $column FROM $this->table WHERE id = ?";
    $stmt = $this->db->prepare($query);
    $stmt->bindValue(1, $userID, PDO::PARAM_INT);
    $stmt->execute();

    return $stmt->fetch(PDO::FETCH_ASSOC);
  }

  // Update column
  public function updateColumn($column, $value, $userID)
  {

    $query = "UPDATE $this->table set $column = ? WHERE id = ?";
    $stmt = $this->db->prepare($query);
    $stmt->bindValue(1, $value);
    $stmt->bindValue(2, $userID);

    return $stmt->execute();
  }

  // Change Password
  public function updatePassword($userID, $userPassword)
  {
    $query = "UPDATE $this->table set password = ?, updated_at = ? WHERE id = ?";
    $stmt = $this->db->prepare($query);
    $stmt->bindValue(1, $userPassword, PDO::PARAM_STR);
    $stmt->bindValue(2, date('Y-m-d H:i:s'));
    $stmt->bindValue(3, $userID, PDO::PARAM_INT);

    return $stmt->execute();
  }
}
