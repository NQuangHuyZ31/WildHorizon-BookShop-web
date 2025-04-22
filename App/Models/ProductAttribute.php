<?php

namespace App\Models;

use PDO;

class ProductAttribute extends Model
{

  protected $table = 'product_attributes';
  protected $primary_key = 'id';

  public function getProductAttr($productID)
  {

    $query = "SELECT attr_name, attr_value FROM $this->table WHERE product_id = ?";

    $stmt = $this->db->prepare($query);

    $stmt->bindValue(1, $productID, PDO::PARAM_INT);

    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }
}
