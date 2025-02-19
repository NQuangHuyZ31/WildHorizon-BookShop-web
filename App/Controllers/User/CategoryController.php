<?php

namespace App\Controllers\User;

use App\Controllers\Controller;
use App\Models\Categories;
use App\Models\Products;

class CategoryController extends Controller
{

  protected $product;

  protected $category;

  public function __construct()
  {
    parent::__construct();

    $this->product = new Products();
    $this->category = new Categories();
  }

  public function index($slug, $id)
  {

    $slug = $slug;

    $id = $id;

    $categories = $this->category->getAll();

    $products = $this->product->getProductCategory($id);

    require VIEW_PATH . 'user/products/danhmucsanpham.php';
  }
}
