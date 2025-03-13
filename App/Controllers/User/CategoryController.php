<?php

namespace App\Controllers\User;

use App\Controllers\Controller;
use App\Models\Brand;
use App\Models\Products;
use App\Models\Categories;
use App\Models\Color;
use App\Models\Supplier;

class CategoryController extends Controller
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

  public function index($slug, $id)
  {

    $slug = $slug;

    $id = $id;

    $categories = $this->categories->getAll();

    $brands = $this->brands->getAll();

    $colors = $this->colors->getAll();

    $suppliers = $this->suppliers->getAll();

    $products = $this->product->getProductCategory($id);

    require VIEW_PATH . 'user/products/danhmucsanpham.php';
  }
}
