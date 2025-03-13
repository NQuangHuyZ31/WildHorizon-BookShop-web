<?php

namespace App\Controllers\User;

use App\Controllers\Controller;
use App\Models\Brand;
use App\Models\Products;
use App\Models\Categories;
use App\Models\Color;
use App\Models\Supplier;

class DanhSachSanPhamController extends Controller
{

  protected $product;
  protected $categories;
  protected $brands;
  protected $colors;
  protected $suppliers;

  public function __construct()
  {
    parent::__construct();

    $this->product = new Products();
    $this->categories = new Categories();
    $this->brands = new Brand();
    $this->colors = new Color();
    $this->suppliers = new Supplier();
  }

  public function index()
  {
    $primaryProduct = true;

    $categories = $this->categories->getAll();

    $brands = $this->brands->getAll();

    $colors = $this->colors->getAll();

    $suppliers = $this->suppliers->getAll();

    if (isset($_GET['search']) && $_GET['search'] != '') {

      $keyword = $_GET['search'];

      $products = $this->product->search($keyword);
    } else {

      $products = $this->product->getAll();
    }

    require VIEW_PATH . 'user/products/danhsachsanpham.php';
  }


  // Categories
  public function categoryProduct($slug, $id)
  {

    $slug = $slug;
    $categoryID = $id;

    if (isset($_GET['search']) && $_GET['search'] != '') {

      $keyword = $_GET['search'];

      $query = "select p.product_id, name, price, image,  COALESCE(f.discount_price, 0) AS discount_price,  COALESCE(f.quantity, 0) AS quantity 
              from products p LEFT JOIN flashsales f on p.product_id = f.product_id where catalog_id = :id and name like :keyword limit 10";
      $stmt = $this->db->prepare($query);

      $stmt->bindValue(':id', $categoryID);

      $stmt->bindValue(':keyword', '%' . $keyword . '%');
    } else {
      $query = "select p.product_id, name, price, image,  COALESCE(f.discount_price, 0) AS discount_price,  COALESCE(f.quantity, 0) AS quantity 
              from products p LEFT JOIN flashsales f on p.product_id = f.product_id where catalog_id = :id limit 10";

      $stmt = $this->db->prepare($query);

      $stmt->bindValue(':id', $categoryID);
    }

    $stmt->execute();

    $products = $stmt->fetchAll(\PDO::FETCH_ASSOC);

    require VIEW_PATH . 'user/products/danhsachsanpham.php';
  }

  public function loadMore()
  {
    $offset = isset($_GET['offset']) ? $_GET['offset'] : 0;

    $dataLoad = $_GET['dataLoad'];

    $limit = $dataLoad == 0 ? 10 : 30;

    $products = $this->product->loadMoreProduct($limit, $offset, $dataLoad);

    echo json_encode(['products' => $products, 'offset' => $dataLoad == 0 ? 10 : 30, 'url' => BASE_URL_NAME, 'join_fs' => $dataLoad == 0 ? 0 : 1]);
  }
}
