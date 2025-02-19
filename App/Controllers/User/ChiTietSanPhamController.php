<?php

namespace App\Controllers\User;

use Core\Session;

use App\Controllers\Controller;
use App\Models\Products;
use App\Models\FlashSales;
use App\Models\Categories;
use App\Models\Reviews;

class ChiTietSanPhamController extends Controller
{

  protected $product;

  protected $fs;

  protected $catogory;

  protected $reviews;

  public function __construct()
  {
    parent::__construct();

    $this->product = new Products();

    $this->fs = new FlashSales();

    $this->catogory = new Categories();

    $this->reviews = new Reviews();
  }

  public function index($slug, $id)
  {

    $product = $this->product->find($id);

    $fs_product = $this->fs->find($id);

    $reviews = $this->reviews->find($id);

    $rating_reviews = $this->reviews->getRatingProduct($id);

    $moreProducts = $this->product->getMoreProducts($product['catalog_id'], $id);

    $suggest_products = $this->product->getSuggestproduct(15);

    require VIEW_PATH . 'user/products/chitietsanpham.php';
  }

  public function savetempAddress()
  {

    $province = $_POST['province'];

    $district = $_POST['district'];

    $ward = $_POST['ward'];

    Session::set('tempaddress', [

      'province' => $province,

      'district' => $district,

      'ward' => $ward

    ]);
  }

  public function checkQuantity()
  {
    // Kiểm tra dữ liệu đầu vào
    if (!isset($_POST['quantity'], $_POST['productID'])) {
      echo json_encode(['success' => 0, 'message' => 'Dữ liệu không hợp lệ']);
      exit();
    }

    $quantity = intval($_POST['quantity']);
    $productID = intval($_POST['productID']);

    // Kiểm tra productID hợp lệ
    $product = $this->product->find($productID);

    if (!$product) {
      echo json_encode(['success' => 0, 'message' => 'Sản phẩm không tồn tại']);
      exit();
    }

    // Kiểm tra số lượng flash sale
    if ($product['fs_quantity'] > 0) {
      if ($quantity >= $product['fs_quantity']) {
        echo json_encode(['success' => 1, 'message' => 'Số lượng flash sale đạt giới hạn']);
        exit();
      }
    }

    // Kiểm tra số lượng kho
    if ($quantity >= $product['stock']) {
      echo json_encode(['success' => 1, 'message' => 'Số lượng sản phẩm đạt giới hạn']);
      exit();
    }

    // Nếu không có lỗi, trả về thành công
    echo json_encode(['success' => 0]);
    exit();
  }
}
