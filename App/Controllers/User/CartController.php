<?php

namespace App\Controllers\User;

use App\Controllers\Controller;
use App\Models\Cart;
use App\Models\Products;
use Core\Format;
use Core\Session;
use Exception;

class CartController extends Controller
{

  protected $cart;

  protected $product;

  public function __construct()
  {
    parent::__construct();

    $this->cart = new Cart();

    $this->product = new Products();
  }

  public function index()
  {

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

    $this->cart->delete($userID, $productID);

    echo json_encode(['success' => 1, 'message' => 'Thành công']);
  }

  // Thêm sản phẩm vào giỏ hàng
  public function addToCart()
  {
    $event = isset($_POST['event']) ? $_POST['event'] : '';

    $productID = isset($_POST['productID']) ? $_POST['productID'] : '';

    $quantity = isset($_POST['quantity']) ? $_POST['quantity'] : '';

    $userID = Session::get('user')['id'];

    if ($this->cart->checkCart($userID, $productID) == 1) {

      echo json_encode(['success' => 0, 'event' => $event, 'message' => 'sản phẩm đã có trong giỏ hàng']);
    } else {
      $this->cart->add($userID, $productID, $quantity);

      echo json_encode(['success' => 1, 'event' => $event, 'message' => 'Thêm sản phẩm vào giỏ hàng thành công']);
    }
  }

  // Update giá qua ajax
  public function updatePriceCart()
  {
    $totalPrice = 0;

    $saveprice = 0;

    if (!isset($_POST['data'])) {

      echo json_encode([

        'success' => 0,

        'totalprice' => Format::forMatPrice($totalPrice),

        'saveprice' => Format::forMatPrice($saveprice),

        'total' => Format::forMatPrice($totalPrice - $saveprice)

      ]);
    } else {

      $data = $_POST['data'];

      $userID = Session::get('user')['id'];

      foreach ($data as $item) {

        $product = $this->cart->find($userID, $item['productID']);

        $totalPrice += $product['price'] * $item['quantity'];

        $saveprice += ($product['f_discount_price'] != null ? $product['f_discount_price'] / 100 * $product['price'] : $product['discount_price'] / 100 * $product['price']) * $item['quantity'];
      }

      echo json_encode([

        'success' => 1,

        'totalprice' => Format::forMatPrice($totalPrice),

        'saveprice' => Format::forMatPrice($saveprice),

        'total' => Format::forMatPrice($totalPrice - $saveprice + 23000)

      ]);
    }
  }

  // Kiểm tra số lượng khi click
  public function checkQuantityCart()
  {
    $userID = Session::get('user')['id'];

    if (!isset($_POST['quantity'], $_POST['productID'])) {
      echo json_encode(['success' => 0, 'message' => 'Dữ liệu không hợp lệ']);
      exit();
    }

    $quantity = intval($_POST['quantity']);
    $productID = intval($_POST['productID']);

    try {
      $this->db->beginTransaction(); // Bắt đầu transaction

      $product = $this->product->find($productID);

      if (!$product) {
        echo json_encode(['success' => 0, 'message' => 'Sản phẩm không tồn tại']);
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

      echo json_encode([
        'success' => isset($message) ? 1 : 0,
        'message' => isset($message) ? $message : 'thành công',
        'quantity' => $quantity
      ]);
    } catch (Exception $e) {
      $this->db->rollBack(); // Hoàn tác nếu có lỗi
      echo json_encode(['success' => 0, 'message' => 'Lỗi hệ thống: ' . $e->getMessage()]);
    }
    exit();
  }
}
