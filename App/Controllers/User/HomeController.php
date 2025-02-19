<?php

namespace App\Controllers\User;

use App\Controllers\Controller;
use App\Models\Categories;
use App\Models\FlashSales;
use App\Models\Products;

class HomeController extends Controller
{

    public $fs;
    public $categories;
    public $product;

    public function __construct()
    {
        parent::__construct();

        $this->fs = new FlashSales();
        
        $this->product = new Products();
        $this->categories = new Categories();
    }

    public function index()
    {
        $homePage = true;
        $flassale_products = $this->fs->getLimit(6,0);

        $categories = $this->categories->getAll();

        $products = $this->product->loadMoreProduct(10, 0,0);

        require VIEW_PATH . 'user/index.php';
    }

}
