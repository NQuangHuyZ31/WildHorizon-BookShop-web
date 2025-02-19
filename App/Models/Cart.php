<?php

namespace App\Models;

use App\Models\Model;

class Cart extends Model
{

  protected $table = 'carts';
  protected $primary_key = 'cart_id';

  public function getAll($userID)
  {
    $query = "SELECT p.product_id as product_id, name, stock, image, price, c.quantity as cart_quantity, fs.discount_price, fs.quantity as fs_quantity from $this->table c join products p on c.product_id = p.product_id 
                                    LEFT JOIN flashsales fs on p.product_id = fs.product_id where user_id = ?";

    $stmt = $this->db->prepare($query);

    $stmt->bindValue(1, $userID, \PDO::PARAM_INT);

    $stmt->execute();

    return $stmt->fetchAll(\PDO::FETCH_ASSOC);
  }

  // Tìm theo sản phẩm cả flashsale
  public function find($userID, $productID)
  {

    $query = "SELECT c.product_id, price, c.quantity, fs.discount_price as fs_dicount_price from $this->table c join products p on c.product_id = p.product_id 
                                    LEFT JOIN flashsales fs on p.product_id = fs.product_id where user_id = ? and c.product_id = ?";

    $stmt = $this->db->prepare($query);

    $stmt->bindValue(1, $userID);
    $stmt->bindValue(2, $productID);

    $stmt->execute();

    return $stmt->fetch(\PDO::FETCH_ASSOC);
  }

  // update quantity
  public function updateQuantity($userID, $productID, $quantity)
  {

    $query = "UPDATE $this->table set quantity = ? where user_id = ? and product_id = ?";

    $stmt = $this->db->prepare($query);

    $stmt->bindParam(1, $quantity);
    $stmt->bindParam(2, $userID);
    $stmt->bindParam(3, $productID);

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

    $query = "INSERT INTO $this->table(user_id,product_id,quantity) values(?,?,?)";

    $stmt = $this->db->prepare($query);

    $stmt->bindValue(1, $userID);

    $stmt->bindValue(2, $productID);

    $stmt->bindValue(3, $quantity);

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

    $result = $stmt->fetch(\PDO::FETCH_ASSOC);

    if (!empty($result)) {
      return 1;
    } else {
      return 0;
    }
  }
}
