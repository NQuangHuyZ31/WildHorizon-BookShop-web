<?php

namespace App\Controllers\User;

use App\Controllers\Controller;
use App\Models\Brand;
use App\Models\Products;
use App\Models\Categories;
use App\Models\Color;
use App\Models\ProductDetail;
use App\Models\Supplier;

class CategoryController extends Controller
{

  protected $page = 'Sản phẩm';
  protected $product;
  protected $categories;
  protected $brands;
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

  public function index($slug, $id)
  {
    $pageName = $this->page;

    $slug = $slug;

    $id = $id;

    $categories = $this->categories->getAll();

    $brands = $this->brands->getAll();

    $colors = $this->productDetail->getColunm('color');

    $suppliers = $this->suppliers->getAll();

    $products = $this->product->getProductCategory($id);

    require VIEW_PATH . 'user/products/danhmucsanpham.php';
  }
}
