<?php

namespace App\Controllers\User;

use Core\Session;

use App\Controllers\Controller;
use App\Models\Products;
use App\Models\FlashSales;
use App\Models\Categories;
use App\Models\ProductAttribute;
use App\Models\Reviews;
use Core\CSRF;
use Core\Response;
use Helpers\CreateSlug;

class ChiTietSanPhamController extends Controller
{

  protected $page = '';
  protected $product;
  protected $fs;
  protected $catogory;
  protected $reviews;
  protected $product_attrs;

  public function __construct()
  {
    parent::__construct();

    $this->product = new Products();

    $this->fs = new FlashSales();

    $this->catogory = new Categories();

    $this->reviews = new Reviews();

    $this->product_attrs = new ProductAttribute();
  }

  public function index($slug, $id)
  {
    $product = $this->product->find($id);

    if (CreateSlug::createSlug($product['product_name']) !== $slug) {
      header('location:' . Session::get('current_url') . '');
    }

    $product_attrs = $this->product_attrs->getProductAttr($id);

    $reviews = $this->reviews->find($id);

    $rating_reviews = $this->reviews->getRatingProduct($id);

    $avgRating = $this->reviews->getAvgProduct($id);

    $moreProducts = $this->product->getMoreProducts($product['catalog_id'], $id);

    $suggest_products = $this->product->getSuggestproduct(15);

    $pageName = $this->page . $product['product_name'];

    require VIEW_PATH . 'user/products/chitietsanpham.php';

    // echo json_encode(['product' => $product, 'product_attr' => $product_attrs, 'reviews' => $reviews, 'rating_review' => $rating_reviews]);
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
    $csrfToken = $_SERVER['HTTP_X_CSRF_TOKEN'] ?? null;
    if (isset($csrfToken)) {
      $csrfToken = $csrfToken;
      $this->checkMethod($csrfToken);
    } else {
      // Token không tồn tại, xử lý lỗi tại đây
      Response::json([
        'error' => [
          'msg' => 'Có lỗi xảy ra. Vui lòng thử lại'
        ],
        'token' => $csrfToken,
        'quantity' => 1
      ], 400);
    }

    CSRF::destroyToken();
    $token = CSRF::generateToken();

    // Kiểm tra dữ liệu đầu vào
    if (!isset($_POST['quantity'], $_POST['productID'])) {
      Response::json([
        'error' =>  [
          'msg' => 'Dữ liệu không hợp lệ'
        ],
        'token' => $token,
        'quantity' => 1
      ], 400);
    }

    // lấy dữ liệu
    $quantity = intval($_POST['quantity']);
    $productID = intval($_POST['productID']);

    // Kiểm tra productID hợp lệ
    $product = $this->product->find($productID);

    if (!$product) {
      Response::json([
        'error' => [
          'msg' => 'Sản phẩm không tồn tại'
        ],
        'token' => $token,
        'quantity' => 1
      ], 400);
    }

    // kiểm tra số lượng trong kho
    if ($product['stock'] <= 0) {
      Response::json([
        'error' => [
          'status' => 'error',
          'msg' => 'Sản phẩm này đã hết hàng'
        ],
        'token' => $token,
        'quantity' => 1
      ], 400);
    }

    // Kiểm tra số lượng flash sale
    if ($product['f_quantity'] > 0) {
      if ($quantity >= $product['f_quantity']) {
        Response::json([
          'error' => [
            'status' => 'success',
            'msg' => 'Số lượng flash sale đạt giới hạn'
          ],
          'token' => $token,
          'quantity' => $quantity
        ], 400);
      }
    }

    // Kiểm tra số lượng kho
    if ($product['f_quantity'] <= 0 && $quantity >= $product['stock']) {
      Response::json([
        'error' =>  [
          'status' => 'success',
          'msg' => 'Số lượng sản phẩm đạt giới hạn'
        ],
        'token' => $token,
        'quantity' => $quantity
      ], 400);
    }

    // Nếu không có lỗi, trả về thành công
    Response::json([
      'success' => 1,
      'token' => $token,
      'quantity' => $quantity
    ], 200);
    exit();
  }
}
