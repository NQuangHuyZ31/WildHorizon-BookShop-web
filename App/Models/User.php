<?php

namespace App\Models;

class User extends Model
{

  protected $table = 'users';
  protected $primary_key = 'id';

  public function insert($data)
  {
    $query = "INSERT INTO $this->table(username,email,password,role,created_at) values(?,?,?,'customer',?)";

    $stmt = $this->db->prepare($query);

    $stmt->bindValue(1, $data['username'], \PDO::PARAM_STR);
    $stmt->bindValue(2, $data['email'], \PDO::PARAM_STR);
    $stmt->bindValue(3, $data['password'], \PDO::PARAM_STR);
    $stmt->bindValue(4, date('Y-m-d'));

    $stmt->execute();
  }

  public function find($userID)
  {

    $query = "SELECT id, username, email, phone FROM $this->table WHERE id = ?  and role = 'customer'";

    $stmt = $this->db->prepare($query);

    $stmt->bindValue(1, $userID, \PDO::PARAM_INT);

    $stmt->execute();

    return $stmt->fetch(\PDO::FETCH_ASSOC) ?? null;
  }

  public function checkEmail($email)
  {
    $query = "select email from $this->table where email = ? ";
    $stmt = $this->db->prepare($query);
    $stmt->bindValue(1, $email);
    $stmt->execute();

    return $stmt->fetch() ? 1 : 0;
  }
}
