<?php

namespace App\Models;

use App\Models\Model;
use PDO;

class Categories extends Model
{

  protected $table = 'catalogs';
  protected $primary_key = 'id';

  public function getAll()
  {
    $query = 'SELECT * FROM catalogs';

    $stmt = $this->db->prepare($query);

    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }

  // Tìm catalog
  public function findCatalog($id)
  {

    $query = "SELECT *FROM catalogs WHERE id = ?";

    $stmt = $this->db->prepare($query);

    $stmt->bindValue(1, $id);

    $stmt->execute();

    return $stmt->fetch(PDO::FETCH_ASSOC);
  }
  // Tìm sản phẩm theo catalog
  public function find($id)
  {

    $query = "SELECT *FROM catalogs WHERE product_id = ?";

    $stmt = $this->db->prepare($query);

    $stmt->bindValue(1, $id);

    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }
}
