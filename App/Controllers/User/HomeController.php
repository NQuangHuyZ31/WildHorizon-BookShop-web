<?php

namespace App\Controllers\User;

use App\Controllers\Controller;
use App\Models\BannerAdvertising;
use App\Models\Categories;
use App\Models\FlashSales;
use App\Models\Products;
use Core\FetchAPI;
use Core\Log;
use Core\Response;

class HomeController extends Controller
{
    protected $fs;
    protected $categories;
    protected $product;
    protected $banner_ads;

    public function __construct()
    {
        parent::__construct();

        $this->fs = new FlashSales();
        $this->product = new Products();
        $this->categories = new Categories();
        $this->banner_ads = new BannerAdvertising();
    }

    public function index()
    {
        $homePage = true;

        $pageName = 'WildHorizonBS - Nhà sách trực tuyến';

        $flassale_products = $this->fs->getLimit(10, 0);

        $categories = $this->categories->getAll();

        $products = $this->product->loadMoreProduct(10, 0, 0);

        $product_best_sellers = $this->product->getLimitRand(10);

        $banner_headers = $this->banner_ads->getActive('homepage', $limit = false);
        $banner_top_headers = $this->banner_ads->getActive('top_homepage', $limit = true);
        $banner_footers = $this->banner_ads->getActive('footer', $limit = false);
        // $url = "http://localhost/WildHorizon-BookShop/v1/api/login";
        // $data = ['username' => 'admin', 'password' => '12345'];
        // $user = FetchAPI::fetchAPI($url, 'POST', $data);

        // if ($user && isset($user['username'])) {
        // print_r($user); // Truy xuất dữ liệu từ mảng thay vì object
        // // }
        // Log::json($user);
        require VIEW_PATH . 'user/index.php';
    }

    // load thêm sản phẩm ở homepage
    public function loadMore()
    {
        $offset = isset($_GET['offset']) ? $_GET['offset'] : 0;

        $limit =  10;

        $products = $this->product->loadMoreProduct($limit, $offset, 0);

        Response::json([
            'data' => $products,
            'offset' => 10,
            'url' => BASE_URL,
        ], 200);
    }
}
