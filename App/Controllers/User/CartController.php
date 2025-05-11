<?php

namespace App\Controllers\User;

use App\Controllers\Controller;
use App\Models\Cart;
use App\Models\Products;
use Core\CSRF;
use Core\Response;
use Helpers\Format;
use Core\Session;
use Exception;

class CartController extends Controller
{

  protected $cart;
  protected $product;
  protected $page = 'Giỏ hàng';

  public function __construct()
  {
    parent::__construct();

    $this->cart = new Cart();

    $this->product = new Products();
  }

  public function index()
  {
    $pageName = $this->page;
    // Xóa dữ liệu cart khi chuyển về trang giỏ hàng
    if (Session::has('data-cart')) {
      Session::delete('data-cart');
    }

    // Lấy id user
    $userID = Session::has('user') ? Session::get('user')['id'] : '';
    $products = $this->cart->getAll($userID);
    $suggestproduct = $this->product->getSuggestproduct(20);
    $totalPrice = 0;
    $saveprice = 0;
    foreach ($products as $product) {
      $totalPrice += $product['price'] * $product['cart_quantity'];
      $saveprice += ($product['f_discount_price'] > 0 ? $product['f_discount_price'] / 100 * $product['price'] : $product['discount_price'] / 100 * $product['price']) * $product['cart_quantity'];
    }

    require VIEW_PATH . 'user/checkouts/cart.php';
  }

  // Xóa sản phẩm trong giỏ hàng
  public function deleteProduct()
  {

    $productID = $_POST['productID'];
    $userID = Session::get('user')['id'];
    $product = $this->cart->find($userID, $productID);

    if ($product) {
      $this->cart->delete($userID, $productID);
      Response::json(['success' => 1, 'message' => 'Thành công'], 200);
    }

    Response::json([
      'error' => [
        'msg' => 'Không tìm thấy sản phẩm'
      ]
    ], 400);
  }

  // Thêm sản phẩm vào giỏ hàng
  public function addToCart()
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

    // lấy dữ liệu
    $event = isset($_POST['event']) ? $_POST['event'] : '';
    $productID = isset($_POST['productID']) ? $_POST['productID'] : '';
    $quantity = isset($_POST['quantity']) ? $_POST['quantity'] : '';
    $userID = Session::get('user')['id'];

    if ($this->cart->checkCart($userID, $productID)) {
      Response::json([
        'error' => [
          'msg' => 'Sản phẩm đã có trong giỏ hàng'
        ],
        'token' => $token
      ], 400);
    }

    // check số lượng
    // Lấy sản phẩm
    $product = $this->product->find($productID);

    if (!$product) {
      Response::json([
        'error' => [
          'msg' => 'Sản phẩm không tồn tại'
        ],
        'token' => $token,
      ], 400);
    }

    // 
    if ($product['stock'] <= 0) {
      Response::json([
        'error' => [
          'msg' => 'Sản phẩm này hết hàng'
        ],
        'token' => $token,
      ], 400);
    }

    $this->cart->add($userID, $productID, $quantity);

    Response::json([
      'success' => [
        'msg' => 'Thêm vào giỏ hàng thành công'
      ],
      'token' => $token,
      'event' => $event
    ], 200);
  }

  // Kiểm tra số lượng khi click
  public function checkQuantityCart()
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

    $userID = Session::get('user')['id'];

    if (!isset($_POST['quantity'], $_POST['productID'])) {
      Response::json(['error' => ['message' => 'Dữ liệu không hợp lệ'], 'token' => $token], 400);
    }

    $quantity = intval($_POST['quantity']);
    $productID = intval($_POST['productID']);

    try {
      $this->db->beginTransaction(); // Bắt đầu transaction

      $product = $this->product->find($productID);

      if (!$product) {
        Response::json(['error' => ['message' => ''], 'token' => $token], 400);
        $this->db->rollBack();
        exit();
      }

      // Kiểm tra giới hạn flash sale
      if ($product['f_quantity'] > 0 && $quantity > $product['f_quantity']) {
        $quantity = $product['f_quantity'];
        $message = "Số lượng flash sale đạt giới hạn";
      }

      // Kiểm tra giới hạn kho
      if ($quantity > $product['stock']) {
        $quantity = $product['stock'];
        $message = "Số lượng sản phẩm đạt giới hạn";
      }

      // Cập nhật số lượng trong giỏ hàng
      $this->cart->updateQuantity($userID, $productID, $quantity);

      $this->db->commit(); // Xác nhận transaction

      Response::json([
        isset($message) ? 'error' : 'success' => ['message' => isset($message) ? $message : "Đủ số lượng"],
        'quantity' => $quantity,
        'token' => $token
      ], 200);
    } catch (Exception $e) {
      $this->db->rollBack(); // Hoàn tác nếu có lỗi
      Response::json(['error' => 0, 'message' => 'Có lỗi xảy ra', 'toekn' => $token], 400);
    }
    exit();
  }

  // Update giá qua ajax
  public function updatePriceCart()
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

    $totalPrice = 0;
    $savePrice = 0;

    if (!isset($_POST['data'])) {
      Response::json([
        'success' => ['message' => 'Cập nhật thành công'],
        'data' => [
          'totalprice' => Format::forMatPrice($totalPrice),
          'saveprice' => Format::forMatPrice($savePrice),
          'total' => Format::forMatPrice($totalPrice - $savePrice)
        ],
        'token' => $token
      ], 200);
    }

    $data = $_POST['data'];
    $userID = Session::get('user')['id'];

    foreach ($data as $item) {

      $productID = $item['productID'];
      $quantity = $item['quantity'];

      $product = $this->cart->find($userID, $productID);

      $totalPrice += $product['price'] * $quantity;

      $savePrice += ($product['f_discount_price'] != null ? $product['f_discount_price'] / 100 * $product['price']
        : $product['discount_price'] / 100 * $product['price']) * $item['quantity'];
    }

    Response::json([

      'success' => ['message' => 'Cập nhật thành công'],

      'data' => [
        'totalprice' => Format::forMatPrice($totalPrice),

        'saveprice' => Format::forMatPrice($savePrice),

        'total' => Format::forMatPrice($totalPrice - $savePrice + 23000)
      ],

      'product' => [
        'id' => $productID,
        'quantity' => $quantity
      ],
      'token' => $token
    ], 200);
  }
}
