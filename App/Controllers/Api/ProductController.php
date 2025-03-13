<?php

namespace App\Controllers\Api;

use App\Controllers\Controller;
use App\Middleware\AuthMiddleware;
use App\Models\Products;
use Core\Response;

class ProductController extends Controller
{
  protected $product;

  public function __construct()
  {
    $this->product = new Products();
  }

  public function getAll()
  {
    AuthMiddleware::verify();
    $product = $this->product->getAll();

    Response::json([$product], 200);
  }
}
