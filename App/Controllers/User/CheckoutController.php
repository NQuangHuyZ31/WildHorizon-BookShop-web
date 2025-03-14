<?php

namespace App\Controllers\User;

use App\Controllers\Controller;
use App\Models\Cart;
use App\Models\FlashSales;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\OrderShippingAddress;
use App\Models\Products;
use App\Models\User;
use Core\CSRF;
use Core\Session;
use Exception;

class CheckoutController extends Controller
{

  protected $product;
  protected $user;
  protected $cart;
  protected $user_id;
  protected $order;
  protected $orderDetail;
  protected $flashsale;
  protected $ordershippingaddress;

  public function __construct()
  {
    parent::__construct();

    $this->product = new Products();

    $this->user = new User();

    $this->cart = new Cart();

    $this->user_id = Session::get('user')['id'];

    $this->order = new Order();

    $this->orderDetail = new OrderDetail();

    $this->flashsale = new FlashSales();

    $this->ordershippingaddress = new OrderShippingAddress();
  }


  public function index()
  {
    if ($_SERVER['REQUEST_METHOD'] == "POST") {
      if (CSRF::verifyToken($_POST['csrf_token'])) {
        CSRF::destroyToken();
        $productIds = isset($_POST['cart-product-id']) ? (array)$_POST['cart-product-id'] : [];
        $quantities = isset($_POST['cart-quantity']) ? (array)$_POST['cart-quantity'] : [];

        $customer = $this->user->find($this->user_id);
        $cartItems = [];
        $total = 0;

        foreach ($productIds as $index => $productId) {

          $cartItems[] = $this->cart->find($customer['id'], $productId);
        }

        foreach ($cartItems as $item) {
          $total +=  $item['f_discount_price'] > 0 ? ($item['price'] - ($item['price'] * $item['f_discount_price'] / 100)) * $item['quantity'] : ($item['price'] - ($item['price'] * $item['discount_price'] / 100)) * $item['quantity'];
        }
      } else {
        header('location: ' . Session::get('cucurrent_url') . '');
        // Session::set('error', '');
      }
    }

    require VIEW_PATH . 'user/checkouts/checkout.php';
  }

  public function checkout()
  {

    if ($_SERVER['REQUEST_METHOD'] === "POST") {
      if (!isset($_POST['csrf_token']) || !CSRF::verifyToken($_POST['csrf_token'])) {
        Session::set('error', 'Lỗi CSRF, vui lòng thử lại');
        header('location: ' . BASE_URL_NAME . '/gio-hang');
        exit();
      }

      CSRF::destroyToken();

      $user_id = $this->user_id;
      $productIds = isset($_POST['productID']) ? (array)$_POST['productID'] : [];
      $quantities = isset($_POST['quantity']) ? (array)$_POST['quantity'] : [];
      $total_price = isset($_POST['total']) ? floatval($_POST['total']) : 0;
      $shipping_fee = isset($_POST['shipping-fee']) ? floatval($_POST['shipping-fee']) : 0;
      $payment_method = $_POST['payment-method'] ?? '';
      $fullname = $_POST['fullname'] ?? '';
      $phone = $_POST['phone'] ?? '';
      $province = $_POST['province'] ?? '';
      $district = $_POST['district'] ?? '';
      $ward = $_POST['ward'] ?? '';
      $address = $_POST['address'] ?? '';

      if (empty($productIds) || empty($quantities) || $total_price <= 0) {
        Session::set('error', 'Thông tin đơn hàng không hợp lệ');
        header('location: ' . BASE_URL_NAME . '/gio-hang');
        exit();
      }
      $this->db->beginTransaction();
      try {

        $data = [
          'user_id' => $user_id,
          'total_price' => $total_price,
          'shipping_fee' => $shipping_fee,
          'payment_method' => $payment_method,
          'status' => 'Chờ xác nhận',
          'order_date' => date('Y-m-d'),
          'fullname' => $fullname,
          'phone' => $phone,
          'province' => $province,
          'district' => $district,
          'ward' => $ward,
          'address' => $address
        ];

        $orderID = $this->order->insert($data);

        $this->ordershippingaddress->insert($data, $orderID);

        if ($orderID) {

          foreach ($productIds as $index => $product_id) {
            $quantity = isset($quantities[$index]) ? intval($quantities[$index]) : 1;

            $product = $this->product->find($product_id);

            // Tính giá sản phẩm
            $price = $product['f_quantity'] > 0
              ? ($product['price'] - ($product['price'] * $product['f_discount_price'] / 100))
              : ($product['price'] - ($product['price'] * $product['discount_price'] / 100));

            // Dự liệu thêm vào chi tiết hóa đơn
            $orderDetailData = [
              'order_id' => $orderID,
              'product_id' => $product_id,
              'quantity' => $quantity,
              'price' => $price,
              'total' => $price * $quantity,
            ];

            // Thêm chi tiết đơn hàng
            $this->orderDetail->insert($orderDetailData);

            // Xóa sản phẩm trong giỏ hàng khi đã thêm chi tiết
            $this->cart->delete($user_id, $product_id);

            // Cập nhật sl flashsale nếu có fs
            if ($product['f_discount_price'] > 0 && $product['f_quantity'] > 0) {
              $this->flashsale->updateQuantityFS($product, $quantity);
            }

            // Cập nhật lại số lượng sản phẩm tồn kho
            if ($product['stock'] > 0) {
              $this->product->updateStock($product_id, $quantity);
            } else {
              header('location: ' . BASE_URL_NAME . '/gio-hang');
            }
          }

          // Commit transaction
          $this->db->commit();

          Session::set('msg', ['success', 'Đặt hàng thành công']);
          header('location: ' . BASE_URL_NAME . '/');
          exit();
        }
      } catch (Exception $e) {
        // Rollback nếu có lỗi
        $this->db->rollBack();
        Session::set('error', $e->getMessage());
        header('location: ' . BASE_URL_NAME . '/gio-hang');
        exit();
      }
    }
  }
}
