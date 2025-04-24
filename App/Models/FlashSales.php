<?php

namespace App\Models;

use App\Models\Model;
use PDO;

class FlashSales extends Model
{

  protected $table = 'flashsales';
  protected $primary_key = 'id';

  public function getAll()
  {

    $query = "SELECT product_id, product_name, price, product_image f.discount_price as discount_price, f.quantity FROM $this->table f JOIN products p ON f.product_id = p.id";

    $stmt = $this->db->prepare($query);

    $stmt->execute();

    return $stmt;
  }

  public function find($id)
  {

    $query = "SELECT *FROM flashsales WHERE product_id = ?";

    $stmt = $this->db->prepare($query);

    $stmt->bindValue(1, $id);

    $stmt->execute();

    return $stmt->fetch(PDO::FETCH_ASSOC);
  }

  public function getLimit($limit, $offset)
  {

    $query = "SELECT product_id, product_name, product_image, price,f.discount_price, f.quantity 
              FROM $this->table f JOIN products p ON f.product_id = p.id LIMIT $limit OFFSET $offset";

    $stmt = $this->db->prepare($query);

    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }

  public function searchKeyword($keyword)
  {

    $query = "SELECT p.product_id,name,price,image,discount_price,quantity FROM $this->table f 
              JOIN products p ON f.product_id = p.product_id WHERE name LIKE :keyword";

    $stmt = $this->db->prepare($query);

    $stmt->bindValue(':keyword', '%' . $keyword . '%');

    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }

  // Update số lượng sản phẩm flashsales
  public function updateQuantityFS($productID, $quantity)
  {
    $query = "UPDATE $this->table set quantity = quantity - ? where product_id = ? ";
    $stmt = $this->db->prepare($query);
    $stmt->bindValue(1, $quantity, PDO::PARAM_INT);
    $stmt->bindValue(2, $productID, PDO::PARAM_INT);
    $stmt->execute();
  }
}
