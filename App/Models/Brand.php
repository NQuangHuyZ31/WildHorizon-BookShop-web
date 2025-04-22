<?php

namespace App\Models;

use PDO;

class Brand extends Model
{

  protected $table = 'brands';
  protected $primary_key = 'id';

  public function getAll()
  {
    $query = "SELECT *FROM $this->table";

    $stmt = $this->db->prepare($query);

    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }
}
