<?php

namespace App\Models;

class Color extends Model
{
  public function getAll()
  {
    $query = "SELECT *FROM colors";
    
    $stmt = $this->db->prepare($query);

    $stmt->execute();

    return $stmt->fetchAll(\PDO::FETCH_ASSOC);
  }
}
