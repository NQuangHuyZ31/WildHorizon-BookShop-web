<?php

namespace App\Models;

class User extends Model
{

  protected $table = 'users';
  protected $primary_key = 'id';

  public function find($userID)
  {

    $query = "SELECT id,firstname, lastname, email, phone FROM $this->table WHERE id = ?  and role = 'customer'";

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
