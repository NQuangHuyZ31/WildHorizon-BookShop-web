<?php

namespace App\Controllers\User;

use App\Controllers\Controller;
use App\Models\FlashSales;

class FlashSaleController extends Controller
{
  protected $fs;

  public function __construct()
  {
    parent::__construct();

    $this->fs = new FlashSales();
  }

  public function index()
  {
    $nosearch = true;

    if (isset($_GET['search']) && $_GET['search'] != '') {

      $keyword = $_GET['search'];

      $fs_products = $this->fs->searchKeyword($keyword);
    } else {

      $fs_products = $this->fs->getLimit(10, 0);
    }
    require VIEW_PATH . 'user/products/flash-sale.php';
  }

  public function loadMoreFlashSale()
  {

    $limit = 10;

    $offset = isset($_GET['offset']) ? $_GET['offset'] : 0;

    $products = $this->fs->getLimit($limit, $offset);

    echo json_encode(['status' => 200, 'data' => $products, 'url' => BASE_URL]);
  }
}
