<?php

namespace App\Models;

use App\Models\Model;
use PDO;

class Products extends Model
{
  protected $table = 'products';
  protected $primary_key = 'id';

  //  lấy tất cả sản phẩm
  public function getAll()
  {
    $query = "SELECT p.id, product_name, price, product_image, p.discount_price, COALESCE(f.discount_price, 0) AS f_discount_price, COALESCE(f.quantity, 0) AS f_quantity  
              from products p LEFT JOIN flashsales f on p.id = f.product_id limit 30";

    $stmt = $this->db->prepare($query);

    $stmt->execute();

    return $stmt->fetchAll(\PDO::FETCH_ASSOC);
  }

  // Tìm sản phẩm theo id chi tiết sản phẩm
  public function find($productID)
  {
    $query = "SELECT p.id, product_name, p.description as p_description, price, product_image, p.discount_price, p.stock, pd.origin, p.catalog_id, 
       COALESCE(f.discount_price, 0) AS f_discount_price, 
       COALESCE(f.quantity, 0) AS f_quantity, 
       pd.publication_year, pd.author, pd.publisher, pd.language, pd.color,
       s.supplier_name, b.brand_name
        FROM products p 
        LEFT JOIN flashsales f on p.id = f.product_id 
        LEFT JOIN product_details pd on p.id = pd.product_id
        LEFT JOIN suppliers s on pd.supplier_id = s.id
        LEFT JOIN brands b on pd.brand_id = p.id
        WHERE p.id = ?";

    $stmt = $this->db->prepare($query);

    $stmt->bindValue(1, $productID);

    $stmt->execute();

    return $stmt->fetch(\PDO::FETCH_ASSOC);
  }

  // Tìm sản phẩm theo keywword
  public function search($keyword)
  {
    $query = "SELECT p.id, product_name, price, product_image, p.discount_price as discount_price, COALESCE(f.discount_price, 0) AS f_discount_price, COALESCE(f.quantity, 0) AS f_quantity 
              from products p LEFT JOIN flashsales f on p.id = f.product_id where p.product_name like ? order by discount_price";

    $stmt = $this->db->prepare($query);

    $stmt->bindValue(1, '%' . $keyword . '%');

    $stmt->execute();

    return $stmt->fetchAll(\PDO::FETCH_ASSOC);
  }

  // Lấy sản phẩm theo filter
  public function getProductFilter($data)
  {
    // Lấy value từng filter
    $searchValue = $data['search'] ?? '';
    $priceFromValue = $data['price']['from'] ?? '';
    $priceToValue = $data['price']['to'] != '' ? $data['price']['to'] : $data['price']['from'];
    $supplierValue = $data['supplier'] ?? '';
    $brandValue = $data['brand'] ?? '';
    $colorValue = $data['color'] ?? '';
    $categoryValue = $data['category'];

    // Nối filter vào query
    $conditions = [];
    $bindParam = [];

    if ($searchValue != '') {

      $conditions[] = "p.product_name like ?";
      $bindParam[] = "%$searchValue%";
    }

    if ($priceFromValue != '' && $priceToValue != '') {
      if ($priceFromValue == $priceToValue) {

        $conditions[] = "p.price >= ?";
        $bindParam[] = $priceFromValue;
      } else {

        $conditions[] = "p.price between  ? and ?";
        $bindParam[] = $priceFromValue;
        $bindParam[] = $priceToValue;
      }
    }

    if ($supplierValue != '') {

      $conditions[] = "pd.supplier_id = ?";
      $bindParam[] = $supplierValue;
    }

    if ($brandValue != '') {

      $conditions[] = "pd.brand_id = ?";
      $bindParam[] = $brandValue;
    }

    if ($colorValue != '') {

      $conditions[] = "pd.color like ?";
      $bindParam[] = "$colorValue";
    }

    if ($categoryValue != 0) {
      $conditions[] = 'catalog_id = ?';
      $bindParam[] = $categoryValue;
    }

    // Nếu không có điều kiện nào, đặt WHERE 1=1 để lấy tất cả sản phẩm
    $whereClause = !empty($conditions) ? "WHERE " . implode(" AND ", $conditions) : "WHERE 1=1";

    $query = "SELECT p.id, product_name, price, product_image, p.discount_price as discount_price, 
    COALESCE(f.discount_price, 0) AS f_discount_price, COALESCE(f.quantity, 0) AS f_quantity 
    from $this->table p 
    LEFT JOIN product_details pd on p.id = pd.product_id 
    LEFT JOIN flashsales f on p.id = f.product_id $whereClause";

    // order by 
    $query .= " order by discount_price";

    $stmt = $this->db->prepare($query);

    foreach ($bindParam as $index => $value) {

      $stmt->bindValue($index + 1, $value, is_numeric($value) ? \PDO::PARAM_INT : \PDO::PARAM_STR);
    }

    $stmt->execute();

    return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    // return $query;
  }

  // Update số lượng product 
  public function updateStock($productID, $quantity)
  {
    $query = "UPDATE $this->table set stock = stock - ? WHERE id = ?";
    $stmt = $this->db->prepare($query);
    $stmt->bindValue(1, $quantity, \PDO::PARAM_INT);
    $stmt->bindValue(2, $productID, \PDO::PARAM_INT);
    $stmt->execute();
  }

  // Lấy sản phẩm tượng tự theo danh mục
  public function getMoreProducts($catalogId, $productId)
  {
    $query = "SELECT p.id, product_name, price, product_image, p.discount_price, COALESCE(f.discount_price, 0) AS f_discount_price,  COALESCE(f.quantity, 0) AS f_quantity
    FROM $this->table p left join flashsales f on p.id = f.product_id 
              WHERE p.catalog_id = ? AND p.id <> ? order by rand() limit 6 ";

    $stmt = $this->db->prepare($query);

    $stmt->bindValue(1, $catalogId);

    $stmt->bindValue(2, $productId);

    $stmt->execute();

    return $stmt->fetchAll(\PDO::FETCH_ASSOC);
  }

  // Lấy sản phẩm gợi ý
  public function getSuggestproduct($limit)
  {
    $query = "SELECT p.id, product_name, price, product_image, p.discount_price,  COALESCE(f.discount_price, 0) AS f_discount_price, COALESCE(f.quantity, 0) AS f_quantity
    FROM $this->table p left join flashsales f on p.id = f.product_id 
              order by rand() LIMIT :limit";

    $stmt = $this->db->prepare($query);

    $stmt->bindParam(':limit', $limit, \PDO::PARAM_INT);

    $stmt->execute();

    return $stmt->fetchAll(\PDO::FETCH_ASSOC);
  }

  // Lấy thêm sản phẩm trang chủ
  public function loadMoreProduct($limit, $offset, $dataLoad)
  {
    if ($dataLoad == 0) {

      $query = "SELECT p.id, product_name, price, product_image, p.discount_price as discount_price 
                FROM $this->table p WHERE p.id NOT IN (SELECT product_id FROM flashsales) LIMIT :limit OFFSET :offset";
    } else {

      $query = "SELECT p.id, product_name, price, product_image, p.discount_price as discount_price , COALESCE(f.discount_price, 0) AS f_discount_price, COALESCE(f.quantity, 0) AS f_quantity 
              FROM $this->table p LEFT JOIN flashsales f on p.id = f.product_id LIMIT :limit OFFSET :offset";
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
    $query = "SELECT p.id, product_name, price, product_image, p.discount_price, COALESCE(f.discount_price, 0) AS f_discount_price,  COALESCE(f.quantity, 0) AS f_quantity 
              from products p LEFT JOIN flashsales f on p.id = f.product_id where catalog_id = ? limit 10";

    $stmt = $this->db->prepare($query);

    $stmt->bindValue(1, $categoryID);

    $stmt->execute();

    return $stmt->fetchAll(\PDO::FETCH_ASSOC);
  }

  // lấy thêm sản phẩm
  public function getMoreProductCategory($limit, $offset, $categoryID) {}
}
