<?php

namespace App\Models;

use PDO;

class ProductDetail extends Model
{
  protected $table = 'product_details';
  protected $primary_key = 'id';
  public function getColunm($colunm)
  {
    $query = "SELECT DISTINCT($colunm) from $this->table";
    $stmt = $this->db->prepare($query);
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }
}
