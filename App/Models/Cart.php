<?php

namespace App\Models;

use App\Models\Model;
use PDO;

class Cart extends Model
{

  protected $table = 'carts';
  protected $primary_key = 'id';

  public function getAll($userID)
  {
    $query = "SELECT p.id, product_name, price, product_image, p.discount_price as discount_price, COALESCE(f.discount_price, 0) AS f_discount_price, f.quantity as f_quantity, c.quantity as cart_quantity, p.stock
              from carts c LEFT JOIN products p on c.product_id = p.id LEFT JOIN flashsales f on p.id = f.product_id where c.user_id = ?";

    $stmt = $this->db->prepare($query);

    $stmt->bindValue(1, $userID, PDO::PARAM_INT);

    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }

  // Tìm theo sản phẩm cả flashsale
  public function find($userID, $productID)
  {

    $query = "SELECT c.product_id, p.product_name, price,p.discount_price, p.product_image, c.quantity, f.discount_price as f_discount_price from $this->table c join products p on c.product_id = p.id 
                                    LEFT JOIN flashsales f on p.id = f.product_id where user_id = ? and c.product_id = ?";

    $stmt = $this->db->prepare($query);

    $stmt->bindValue(1, $userID);
    $stmt->bindValue(2, $productID);

    $stmt->execute();

    return $stmt->fetch(PDO::FETCH_ASSOC);
  }

  // update quantity
  public function updateQuantity($userID, $productID, $quantity)
  {

    $query = "UPDATE $this->table set quantity = ?, updated_at = ? where user_id = ? and product_id = ?";

    $stmt = $this->db->prepare($query);
    $updatedAt = date('Y-m-d H:i:s');
    $stmt->bindParam(1, $quantity);
    $stmt->bindParam(2, $updatedAt);
    $stmt->bindParam(3, $userID);
    $stmt->bindParam(4, $productID);

    $stmt->execute();
  }

  // Delete product
  public function delete($userID, $productID)
  {
    $query = "DELETE FROM $this->table where user_id = ? and product_id = ?";

    $stmt = $this->db->prepare($query);

    $stmt->bindValue(1, $userID);
    $stmt->bindValue(2, $productID);

    $stmt->execute();
  }

  // Thêm vào giỏ hàng 
  public function add($userID, $productID, $quantity)
  {

    $query = "INSERT INTO $this->table(user_id,product_id,quantity,created_at) values(?,?,?,?)";

    $stmt = $this->db->prepare($query);

    $stmt->bindValue(1, $userID);

    $stmt->bindValue(2, $productID);

    $stmt->bindValue(3, $quantity);

    $stmt->bindValue(4, date('Y-m-d H:i:s'));

    $stmt->execute();
  }

  // Tìm kiếm sản phẩm theo userID và ProductID
  public function checkProductCart($userID, $productID) {}

  // Check product cart
  public function checkCart($userID, $productID)
  {
    $query = "SELECT *FROM $this->table where user_id = ? and product_id = ?";

    $stmt = $this->db->prepare($query);

    $stmt->bindValue(1, $userID);

    $stmt->bindValue(2, $productID);

    $stmt->execute();

    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!empty($result)) {

      return 1;
    } else {

      return 0;
    }
  }
}
