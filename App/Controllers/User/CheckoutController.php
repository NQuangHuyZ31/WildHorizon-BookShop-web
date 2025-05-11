<?php

namespace App\Controllers\User;

use App\Controllers\Controller;
use App\Models\Cart;
use App\Models\CustomerAddress;
use App\Models\FlashSales;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\OrderShippingAddress;
use App\Models\Products;
use App\Models\User;
use App\Models\Vnpay_payment;
use App\Requests\CheckoutValidate;
use Core\CSRF;
use Core\Response;
use Core\Session;
use Exception;
use Helpers\Hash;
use Helpers\Redirect;

class CheckoutController extends Controller
{

  protected $page = 'Thanh toán đơn hàng';
  protected $product;
  protected $user;
  protected $cart;
  protected $user_id;
  protected $customerAddress;
  protected $order;
  protected $orderDetail;
  protected $flashsale;
  protected $ordershippingaddress;
  protected $vnpay_payment;

  public function __construct()
  {
    parent::__construct();

    $this->product = new Products();

    $this->user = new User();

    $this->cart = new Cart();

    $this->user_id = Session::get('user')['id'];

    $this->customerAddress = new CustomerAddress();

    $this->order = new Order();

    $this->orderDetail = new OrderDetail();

    $this->flashsale = new FlashSales();

    $this->ordershippingaddress = new OrderShippingAddress();

    $this->vnpay_payment = new Vnpay_payment();
  }

  // Lưu dữ liệu giỏ hàng khi gửi qua
  public function chekoutProcess()
  {
    // Check method
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
      Redirect::redirectWithError(500, 'Có lỗi trong quá trình đặt hàng. Vui lòng thử lại', '/gio-hang');
    }

    $productIds = isset($_POST['cart-product-id']) ? $_POST['cart-product-id'] : [];
    $quantities = isset($_POST['cart-quantity']) ? $_POST['cart-quantity'] : [];

    Session::set('data-cart', [
      'product_id' => $productIds,
      'product_quantity' => $quantities
    ]);

    header('location:' . BASE_URL . '/checkout');
  }

  public function index()
  {

    $pageName = $this->page;
    $customerAddress = $this->customerAddress->getAddress($this->user_id);

    if (!Session::has('data-cart')) {
      header('location: ' . BASE_URL . '/gio-hang');
      exit;
    }

    $productIds = Session::get('data-cart') != null ? Session::get('data-cart')['product_id'] : [];
    $quantities = Session::get('data-cart') != null ? Session::get('data-cart')['product_quantity'] : [];

    $customer = $this->user->find($this->user_id);
    $cartItems = [];
    $total = 0;

    foreach ($productIds as $index => $productId) {

      $cartItems[] = $this->cart->find($customer['id'], $productId);
    }

    foreach ($cartItems as $item) {
      $total +=  $item['f_discount_price'] > 0 ? ($item['price'] - ($item['price'] * $item['f_discount_price'] / 100)) * $item['quantity'] : ($item['price'] - ($item['price'] * $item['discount_price'] / 100)) * $item['quantity'];
    }
    require VIEW_PATH . 'user/checkouts/checkout.php';
  }

  // Thêm địa chỉ checkout mới
  public function addNewAddressCheckout()
  {
    $this->checkMethod($_POST['csrf_token']);

    CSRF::destroyToken();

    $token = CSRF::generateToken();

    // Kiểm tra lỗi
    $error = CheckoutValidate::validate($_POST);
    if (!empty($error)) {
      Response::json([
        'error' => [
          'msg' => $error
        ],
        'token' => $token
      ], 400);
    }

    // Thêm địa chỉ
    $dataNewAddress = [
      'username' => $_POST['username'],
      'phone' => $_POST['phone'],
      'province' => $_POST['province'],
      'district' => $_POST['district'],
      'ward' => $_POST['ward'],
      'address' => $_POST['address'],
      'default_address' => 0,
      'created_at' => date('Y-m-d H:i:s')
    ];

    $this->customerAddress->insertAddress($dataNewAddress, $this->user_id);
    Response::json([
      'success' => [
        'msg' => 'Thành công'
      ],
      'token' => $token
    ], 200);
  }

  // lấy địa chỉ 
  public function getAddressCheckout()
  {
    $this->checkMethod($_POST['csrf_token']);

    CSRF::destroyToken();
    $token = CSRF::generateToken();

    $addresses = $this->customerAddress->getAddress($this->user_id);
    Response::json([
      'success' => [
        'data' => $addresses
      ],
      'token' => $token
    ], 200);
  }

  // Xóa đại chỉ
  public function deleteAddressCheckout()
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
      ], 400);
    }

    CSRF::destroyToken();
    $token = CSRF::generateToken();

    $address = $this->customerAddress->getAddressByID($_POST['addressID'], $this->user_id);

    if (!$address) {
      Response::json([
        'error' => [
          'msg' => 'Địa chỉ không tồn tại'
        ],
        'token' => $token
      ], 400);
    }

    $this->customerAddress->deleteAddress($_POST['addressID'], $this->user_id);
    Response::json([
      'success' => [
        'msg' => 'Xóa thành công'
      ],
      'token' => $token
    ], 200);
  }

  public function checkout()
  {

    if ($_SERVER['REQUEST_METHOD'] !== "POST") {
      Redirect::redirectWithError(500, 'Có lỗi trong quá trình thanh toán', '/checkout');
    }

    if (!CSRF::verifyToken($_POST['csrf_token'])) {
      Redirect::redirectWithError(500, 'Có lỗi trong quá  trình thanh toán', '/checkout');
    }

    CSRF::destroyToken();

    $user_id = $this->user_id;
    $productIds = isset($_POST['productID']) ? (array)$_POST['productID'] : [];
    $quantities = isset($_POST['quantity']) ? (array)$_POST['quantity'] : [];
    $total_price = isset($_POST['total']) ? floatval($_POST['total']) : 0;
    $shipping_fee = isset($_POST['shipping-fee']) ? floatval($_POST['shipping-fee']) : 0;
    $payment_method = $_POST['payment-method'] ?? '';
    $fullname = $_POST['username'] ?? '';
    $phone = $_POST['phone'] ?? '';
    $province = $_POST['province'] ?? '';
    $district = $_POST['district'] ?? '';
    $ward = $_POST['ward'] ?? '';
    $address = $_POST['address'] ?? '';
    $checkout_address = $_POST['checkout-address'] ?? '';

    // Kiểm tra lỗi 
    if (!isset($checkout_address) || empty($checkout_address)) {
      $error = CheckoutValidate::validate($_POST);
      if (!empty($error)) {
        Redirect::redirectWithError(400, $error, '/checkout');
      }
    } else {
      $customer_checkout_address = $this->customerAddress->getAddressByID($checkout_address, $this->user_id);
      // Gán lại dữ liệu
      $fullname = $customer_checkout_address['username'];
      $phone = $customer_checkout_address['phone'];
      $province = $customer_checkout_address['province'];
      $district = $customer_checkout_address['district'];
      $ward = $customer_checkout_address['ward'];
      $address = $customer_checkout_address['address'];
    }

    // Kiểm tra xem có số lượng và sản phẩm không
    if (empty($productIds) || empty($quantities) || $total_price <= 0) {
      Redirect::redirectWithError(404, 'Thông tin không đúng', '/checkout');
    }

    try {
      $this->db->beginTransaction();

      $data = [
        'user_id' => $user_id,
        'total_price' => $total_price,
        'shipping_fee' => $shipping_fee,
        'payment_method' => $payment_method,
        'status' => 'Chờ xác nhận',
        'order_date' => date('Y-m-d'),
        'username' => $fullname,
        'phone' => $phone,
        'province' => $province,
        'district' => $district,
        'ward' => $ward,
        'address' => $address,
        'default_address' => 0
      ];

      // Thêm đơn hàng
      $orderID = $this->order->insert($data);

      // thêm địa chỉ nhận hàng
      $this->ordershippingaddress->insert($data, $orderID);

      if (!isset($checkout_address) || empty($checkout_address)) {
        $this->customerAddress->insertAddress($data, $user_id);
      }

      foreach ($productIds as $index => $product_id) {
        $quantity = $quantities[$index];
        $product = $this->product->find($product_id);

        if (!$product || $quantity <= 0) continue;

        //     // Kiểm tra tồn kho
        if ($product['stock'] < $quantity) {
          $this->db->rollBack();
          Redirect::redirectWithError(404, 'Sản phẩm đã hết hàng', '/gio-hang');
        }

        //     // Tính giá
        $discount = ($product['f_quantity'] > 0)
          ? $product['f_discount_price']
          : $product['discount_price'];

        $price = $product['price'] - ($product['price'] * $discount / 100);
        $total = $price * $quantity;

        //     // Lưu chi tiết đơn hàng
        $orderDetailData = [
          'order_id' => $orderID,
          'product_id' => $product_id,
          'quantity' => $quantity,
          'price' => $price,
          'total' => $total,
          'created_at' => date('Y-m-d H:i:s')
        ];

        //     // Thêm chi tiết đơn hàng
        $this->orderDetail->insert($orderDetailData);

        //     // Cập nhật kho
        $this->product->updateStock($product_id, $quantity);

        //     // Cập nhật số lượng FlashSale nếu có
        if ($product['f_quantity'] > 0) {
          $this->flashsale->updateQuantityFS($product_id, $quantity);
        }

        //     // Xoá khỏi giỏ hàng
        $this->cart->delete($user_id, $product_id);
      }

      $this->db->commit();
      Session::delete('data-cart');
      //     // Xử lí thanh toán vnpay
      if ($payment_method == 'VNPAY') {
        $this->vnPayCheckout($orderID, $total_price + $shipping_fee);
      } else {
        Redirect::redirectWithSuccess(200, 'Đặt hàng thành công', '/customer/order/detail/' . $orderID . '');
      }
    } catch (Exception $e) {
      // Rollback nếu có lỗi
      $this->db->rollBack();
      Redirect::redirectWithError(500, 'Có lỗi trong quá trình đặt hàng', '/checkout');
    }
  }

  // Thanh toán lại
  public function vnPayCheckoutAgain($orderID)
  {

    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
      Redirect::redirectNoMSG();
    }

    if (!CSRF::verifyToken($_POST['csrf_token'])) {
      Redirect::redirectNoMSG();
    }

    CSRF::destroyToken();

    $order = $this->order->getOrderByID($orderID, Session::get('user')['id']);

    if ($order == null) {
      Redirect::redirectCurrentURL('Đơn hàng này không phải của bạn');
    }

    // Kiểm tra đon hàng đã thanh toán chưa
    if ($order['payment_method'] != 'VNPAY' || ($order['payment_method'] == 'VNPAY' && $order['is_payment'] != 0)) {
      Redirect::redirectCurrentURL('Đơn hàng này không phải thanh toán vnpay hoặc đã được thanh toán');
    }

    $this->vnPayCheckout($order['id'], $order['total_price'] + $order['shipping_fee']);
  }


  // VNPAY
  public function vnPayCheckout($orderID, $amount)
  {
    error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED);
    date_default_timezone_set('Asia/Ho_Chi_Minh');

    $vnp_Url = "https://sandbox.vnpayment.vn/paymentv2/vpcpay.html";
    $vnp_Returnurl = BASE_URL . '/checkout/vnpay/return';
    $vnp_TmnCode = SERECT_APP_VNPAY; //Mã website tại VNPAY 
    $vnp_HashSecret = SERECT_KEY_VNPAY; //Chuỗi bí mật

    $vnp_TxnRef = $orderID . '-' . random_int(1000, 9999); //Mã đơn hàng. Trong thực tế Merchant cần insert đơn hàng vào DB và gửi mã này sang VNPAY
    $vnp_OrderInfo = 'Thanh toan cho don hang ' . $orderID . '. So tien ' . $amount . '';
    $vnp_Amount = $amount * 100;
    $vnp_Locale = 'vn';
    $vnp_BankCode = 'VNBANK';
    $vnp_IpAddr = $_SERVER['REMOTE_ADDR'];
    $vnp_OrderType = '250000';
    $vnp_ExpireDate = date('YmdHis', strtotime('+30 minutes'));
    //Add Params of 2.0.1 Version
    // $vnp_ExpireDate = $_POST['txtexpire'];
    $inputData = array(
      "vnp_Version" => "2.1.0",
      "vnp_TmnCode" => $vnp_TmnCode,
      "vnp_Amount" => $vnp_Amount,
      "vnp_Command" => "pay",
      "vnp_CreateDate" => date('YmdHis'),
      "vnp_CurrCode" => "VND",
      "vnp_IpAddr" => $vnp_IpAddr,
      "vnp_Locale" => $vnp_Locale,
      "vnp_OrderInfo" => $vnp_OrderInfo,
      "vnp_OrderType" => $vnp_OrderType,
      "vnp_ReturnUrl" => $vnp_Returnurl,
      "vnp_TxnRef" => $vnp_TxnRef,
      "vnp_ExpireDate" => $vnp_ExpireDate,
    );

    if (isset($vnp_BankCode) && $vnp_BankCode != "") {
      $inputData['vnp_BankCode'] = $vnp_BankCode;
    }
    //var_dump($inputData);
    ksort($inputData);
    $query = "";
    $i = 0;
    $hashdata = "";
    foreach ($inputData as $key => $value) {
      if ($i == 1) {
        $hashdata .= '&' . urlencode($key) . "=" . urlencode($value);
      } else {
        $hashdata .= urlencode($key) . "=" . urlencode($value);
        $i = 1;
      }
      $query .= urlencode($key) . "=" . urlencode($value) . '&';
    }

    $vnp_Url = $vnp_Url . "?" . $query;
    if (isset($vnp_HashSecret)) {
      $vnpSecureHash =   hash_hmac('sha512', $hashdata, $vnp_HashSecret); //  
      $vnp_Url .= 'vnp_SecureHash=' . $vnpSecureHash;
    }
    // $returnData = array(
    //   'code' => '00',
    //   'message' => 'success',
    //   'data' => $vnp_Url
    // );
    header('Location: ' . $vnp_Url);
    die();
  }

  // ===================================
  public function vnPayReturn()
  {
    try {
      //code...
      $vnp_SecureHash = $_GET['vnp_SecureHash'];

      if ($vnp_SecureHash == '') {
        Redirect::redirectWithError(500, 'Bạn không có quyền truy cập', '/');
      }

      // 
      if ($_GET['vnp_ResponseCode'] !== '00') {
        Redirect::redirectWithError(500, 'Thanh toán thất bại', '/customer/order/detail/' . strtok($_GET['vnp_TxnRef'], '-') . '');
      }

      $inputData = array();

      foreach ($_GET as $key => $value) {
        if ($key != "vnp_SecureHash" && $key != "vnp_SecureHashType") {
          $inputData[$key] = $value;
        }
      }
      ksort($inputData);
      $hashData = '';
      $i = 0;
      foreach ($inputData as $key => $value) {
        $hashData .= ($i++ ? '&' : '') . urlencode($key) . "=" . urlencode($value);
      }
      $secureHashCheck = hash_hmac('sha512', $hashData, SERECT_KEY_VNPAY);
      if ($secureHashCheck === $vnp_SecureHash) {
        if ($_GET['vnp_ResponseCode'] == '00') {
          try {
            //code...
            $this->db->beginTransaction();
            $dataVNPAY = [
              'order_id' => strtok($_GET['vnp_TxnRef'], '-'),
              'vnp_Amount' => $_GET['vnp_Amount'] / 100,
              'vnp_BankCode' => $_GET['vnp_BankCode'],
              'vnp_BankTranNo' => $_GET['vnp_BankTranNo'],
              'vnp_CardType' => $_GET['vnp_CardType'],
              'pay_date' => date('Y-m-d H:i:s', strtotime($_GET['vnp_PayDate'])),
              'vnp_TransactionNo' => $_GET['vnp_TransactionNo'],
            ];

            $jsonData = json_encode($dataVNPAY);
            $dataHash = Hash::encrypt($jsonData, PAYMENT_KEY);

            $data = [
              'order_id' => strtok($_GET['vnp_TxnRef'], '-'),
              'vn_pay' => $dataHash,
              'created_at' => date('Y-m-d H:i:s')
            ];

            $this->vnpay_payment->insert($data);
            $this->order->updateColumn($dataVNPAY['order_id'], 'is_payment', 1);
            $this->db->commit();

            Redirect::redirectWithSuccess(200, 'Thanh toán thành công', '/customer/order/detail/' . $data['order_id'] . '');
          } catch (\Throwable $th) {
            //throw $th;
            $this->db->rollBack();
            Redirect::redirectWithError(500, "Có lỗi trong quá trình thanh toán", '/customer/order/detail/' . $dataVNPAY['order_id'] . '');
          }
        }
      }
    } catch (\Throwable $th) {
      //throw $th;
      Redirect::redirectWithError(500, 'Lỗi trong quá trình thanh toán', '/customer/order');
    }
  }
}
