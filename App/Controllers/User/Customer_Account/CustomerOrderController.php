<?php

namespace App\Controllers\User\Customer_Account;

use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\OrderReview;
use App\Models\OrderShippingAddress;
use App\Models\Reviews;
use Core\CSRF;
use Core\Response;
use Core\Session;
use Helpers\Redirect;

class CustomerOrderController extends CustomerController
{

  protected $page = 'Đơn hàng của tôi';
  protected $user;
  protected $order;
  protected $order_detail;
  protected $order_shipping_address;
  protected $order_review;
  protected $review;

  public function __construct()
  {
    parent::__construct();
    $this->order = new Order();
    $this->order_detail = new OrderDetail();
    $this->order_shipping_address = new OrderShippingAddress();
    $this->order_review = new OrderReview();
    $this->review = new Reviews();
  }

  public function index()
  {
    $pageName = $this->page;
    $customer = $this->customer;
    // Lọc theo trạng thái
    if (isset($_GET['type']) && $_GET['type'] != 'all') {
      $orders = $this->order->getOderByStatus($customer['id'], $_GET['type']);
    } else {
      $orders = $this->order->getOderByUser($customer['id']);
    }
    // echo $_GET['type'];
    $order_ids = array_column($orders, 'id');

    // Tạo mảng để gộp các order có cùng id
    $grouped_orders = [];

    // Lặp qua các order
    foreach ($orders as $order) {
      $order_id = $order['id'];

      $order_review = $this->order_review->find($order_id);
      // Tạo group order
      if (!isset($grouped_orders[$order_id])) {

        $grouped_orders[$order_id] = [
          'order_id' => $order_id,
          'order_review' => $order_review != null ? 1 : 0,
          'total_price' => $order['total_price'] + $order['shipping_fee'],
          'order_status' => $order['status'],
          'order_date' => $order['order_date'],
          'items' => []
        ];
      }
      // Lấy các order detail theo order và gắn vào items
      $grouped_orders[$order_id]['items'] = $this->order_detail->getOrderDetailByOrderID($order_id);
    }
    // print_r($grouped_orders);
    require_once VIEW_PATH . 'user/accounts/order/customer-order.php';
  }

  // Hiển thị order detail
  public function showOrderDetailPage($orderID)
  {
    $pageName = $this->page;

    $customer = $this->customer;
    $step_line = '';

    $order = $this->order->getOrderByID($orderID, $customer['id']);

    if (empty($order)) {
      Redirect::redirectCurrentURL('Đơn hàng không phải của bạn', 0);
    }

    if ($order['status'] == "Chuẩn bị hàng") {
      $step_line = '25%';
    }

    if ($order['status'] == "Đang giao hàng") {
      $step_line = '50%';
    }

    if ($order['status'] == "Đã giao hàng") {
      $step_line = '75%';
    }

    $order_details = $this->order_detail->getOrderDetailByOrderID($orderID);
    $order_shipping_address = $this->order_shipping_address->find($order['id']);
    $order_review = $this->order_review->find($orderID);
    require_once VIEW_PATH . 'user/accounts/order/customer-order-detail.php';
  }

  public function getOrderInfo()
  {
    try {
      //code...
      $orderID = $_GET['orderID'];
      $order_details = $this->order_detail->getOrderDetailByOrderID($orderID);

      $data = [];

      foreach ($order_details as $detail) {
        $data[] = [
          'product_id' => $detail['product_id'],
          'product_name' => $detail['product_name'],
          'product_image' => $detail['product_image']
        ];
      }
      Response::json([
        'success' => [
          'order_id' => $orderID,
          'data' => $data
        ],
        'url' => BASE_URL
      ], 200);
    } catch (\Throwable $th) {
      //throw $th;
      Response::json([
        'error' => [
          'msg' => $th->getMessage()
        ]
      ], 500);
    }
  }

  // Lưu đánh giá
  public function saveReview()
  {
    $this->checkMethod($_POST['csrf_token']);

    CSRF::destroyToken();

    $token = CSRF::generateToken();

    try {
      // //code...
      $this->db->beginTransaction();

      // thêm order_review
      $dataOrderReview = [
        'user_id' => Session::get('user')['id'],
        'order_id' => $_POST['orderID'],
        'rating_id' => $_POST['order_rating'],
        'comment' => $_POST['order_comment'],
        'created_at' => date('Y-m-d H:s:i')
      ];

      $this->order_review->insert($dataOrderReview);

      // Thêm product_review
      foreach ($_POST['product_id'] as $key => $value) {
        $dataProductReview = [
          'user_id' => Session::get('user')['id'],
          'product_id' => $value,
          'order_id' => $_POST['orderID'],
          'rating_id' => $_POST['product_rating'][$key],
          'comment' => $_POST['product_comment'][$key],
          'created_at' => date('Y-m-d H:i:s')
        ];

        $this->review->insert($dataProductReview);
      }

      $this->db->commit();
      Response::json([
        'success' => [
          'msg' => 'Cảm ơn bạn đã đánh giá!'
        ],
        'token' => $token
      ], 200);
    } catch (\Throwable $th) {
      //throw $th;
      $this->db->rollBack();
      Response::json([
        'error' => [
          'msg' => $th->getMessage()
        ],
        'token' => $_POST['csrf_token']
      ], 500);
    }
  }
}
