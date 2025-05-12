<?php

namespace App\Controllers\User;

use App\Controllers\Controller;
use App\Models\Brand;
use App\Models\Products;
use App\Models\Categories;
use App\Models\ProductDetail;
use App\Models\Supplier;
use Core\Response;

class DanhSachSanPhamController extends Controller
{

  protected $page = 'Sản phẩm';
  protected $product;
  protected $categories;
  protected $brands;
  protected $colors;
  protected $suppliers;
  protected $productDetail;

  public function __construct()
  {
    parent::__construct();

    $this->product = new Products();
    $this->categories = new Categories();
    $this->brands = new Brand();
    $this->suppliers = new Supplier();
    $this->productDetail = new ProductDetail();
  }

  public function index()
  {

    $pageName = $this->page;

    $primaryProduct = true;

    $categories = $this->categories->getAll();

    $brands = $this->brands->getAll();

    $suppliers = $this->suppliers->getAll();

    $colors = $this->productDetail->getColunm('color');

    if (isset($_GET['search']) && $_GET['search'] != '') {

      $keyword = $_GET['search'];

      $products = $this->product->search($keyword);
    } else {

      $products = $this->product->getAll();
    }

    require VIEW_PATH . 'user/products/danhsachsanpham.php';
  }

  // Tìm sản phẩm theo filter
  public function searchFilter()
  {
    $success = true;

    $data = $_GET;

    $products = $this->product->getProductFilter($data);


    Response::json([
      'status' => http_response_code(),
      'success' => empty($products) ? 0 : 1,
      'products' => $products,
      'params' => $data,
      'product_count' => count($products),
      'url' => BASE_URL
    ], 200);
  }

  // Load thêm sản phẩm trang sản phẩm
  public function loadmoreProduct()
  {
    $limit = 30;
    $offset = isset($_GET['offset']) ? $_GET['offset'] : 0;

    $products = $this->product->loadMoreProduct($limit, $offset, 1);

    Response::json([
      'success' => [
        'count' => count($products),
        'data' => $products
      ],
      'url' => BASE_URL,
      'offset' => 30
    ], 200);
  }
}
