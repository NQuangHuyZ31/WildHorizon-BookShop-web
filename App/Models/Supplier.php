<?php

namespace App\Models;

use PDO;

class Supplier extends Model
{
  public function getAll()
  {

    $query = "SELECT *FROM suppliers";

    $stmt = $this->db->prepare($query);

    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }
}
