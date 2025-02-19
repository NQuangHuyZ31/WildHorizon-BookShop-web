<?php

namespace App\Models;

use App\Models\Model;

class Products extends Model
{
  protected $table = 'products';
  protected $primary_key = 'product_id';

  //  lấy tất cả sản phẩm
  public function getAll()
  {
    $query = "SELECT p.product_id, name, price, image,  COALESCE(f.discount_price, 0) AS discount_price,  COALESCE(f.quantity, 0) AS quantity 
              from products p LEFT JOIN flashsales f on p.product_id = f.product_id order by discount_price desc limit 30";

    $stmt = $this->db->prepare($query);

    $stmt->execute();

    return $stmt->fetchAll(\PDO::FETCH_ASSOC);
  }

  // Tìm sản phẩm theo id
  public function find($productID)
  {
    $query = "SELECT  p.product_id, catalog_id, name,description, price, image, stock, COALESCE(f.discount_price, 0) AS discount_price,  COALESCE(f.quantity, 0) AS fs_quantity 
              from $this->table p LEFT JOIN flashsales f on p.product_id = f.product_id where p.product_id = ?";

    $stmt = $this->db->prepare($query);

    $stmt->bindValue(1, $productID);

    $stmt->execute();

    return $stmt->fetch(\PDO::FETCH_ASSOC);
  }

  // Tìm sản phẩm theo keywword
  public function search($keyword)
  {
    $query = "SELECT p.product_id, name, price, image,  COALESCE(f.discount_price, 0) AS discount_price,  COALESCE(f.quantity, 0) AS quantity 
              from products p LEFT JOIN flashsales f on p.product_id = f.product_id where p.name like ? order by discount_price ";

    $stmt = $this->db->prepare($query);

    $stmt->bindValue(1, '%' . $keyword . '%');

    $stmt->execute();

    return $stmt->fetchAll(\PDO::FETCH_ASSOC);
  }

  // sản phẩm tượng tự theo danh mục
  public function getMoreProducts($catalogId, $productId)
  {
    $query = "SELECT p.product_id, name, price, image,  COALESCE(fs.discount_price, 0) AS discount_price,  COALESCE(fs.quantity, 0) AS quantity FROM $this->table p left join flashsales fs on p.product_id = fs.product_id 
              WHERE catalog_id = ? AND p.product_id <> ? order by rand() limit 6 ";

    $stmt = $this->db->prepare($query);

    $stmt->bindValue(1, $catalogId);

    $stmt->bindValue(2, $productId);

    $stmt->execute();

    return $stmt->fetchAll(\PDO::FETCH_ASSOC);
  }

  // sản phẩm gợi ý
  public function getSuggestproduct($limit)
  {
    $query = "SELECT p.product_id, name, price, image,  COALESCE(fs.discount_price, 0) AS discount_price,  COALESCE(fs.quantity, 0) AS quantity FROM $this->table p left join flashsales fs on p.product_id = fs.product_id 
              order by rand() LIMIT :limit";

    $stmt = $this->db->prepare($query);

    $stmt->bindParam(':limit', $limit, \PDO::PARAM_INT);

    $stmt->execute();

    return $stmt->fetchAll(\PDO::FETCH_ASSOC);
  }

  // lấy thêm sản phẩm 
  public function loadMoreProduct($limit, $offset, $dataLoad)
  {
    if ($dataLoad == 0) {

      $query = "SELECT product_id, name, price, image FROM $this->table WHERE product_id NOT IN (SELECT product_id FROM flashsales) LIMIT :limit OFFSET :offset";
    } else {

      $query = "SELECT p.product_id, name, price, image,  COALESCE(f.discount_price, 0) AS discount_price,  COALESCE(f.quantity, 0) AS quantity 
              from products p LEFT JOIN flashsales f on p.product_id = f.product_id order by discount_price desc LIMIT :limit OFFSET :offset";
    }

    $stmt = $this->db->prepare($query);

    $stmt->bindParam(':limit', $limit, \PDO::PARAM_INT);

    $stmt->bindParam(':offset', $offset, \PDO::PARAM_INT);

    $stmt->execute();

    return $stmt->fetchAll(\PDO::FETCH_ASSOC);
  }

  // Lấy sản phẩm theo category
  public function getProductCategory($categoryID)
  {
    $query = "SELECT p.product_id, name, price, image,  COALESCE(f.discount_price, 0) AS discount_price,  COALESCE(f.quantity, 0) AS quantity 
              from products p LEFT JOIN flashsales f on p.product_id = f.product_id where catalog_id = ? limit 10";

    $stmt = $this->db->prepare($query);

    $stmt->bindValue(1, $categoryID);

    $stmt->execute();

    return $stmt->fetchAll(\PDO::FETCH_ASSOC);
  }

  // lấy thêm sản phẩm
  public function getMoreProductCategory($limit, $offset, $categoryID) {}
}
