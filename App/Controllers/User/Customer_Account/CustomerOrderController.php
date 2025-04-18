<?php

namespace App\Controllers\User\Customer_Account;

use App\Models\Order;
use App\Models\OrderDetail;

class CustomerOrderController extends CustomerController
{
  protected $user;
  protected $order;
  protected $order_detail;

  public function __construct()
  {
    parent::__construct();
    $this->order = new Order();
    $this->order_detail = new OrderDetail();
  }

  public function index()
  {

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
      // Tạo group order
      if (!isset($grouped_orders[$order_id])) {

        $grouped_orders[$order_id] = [
          'order_id' => $order_id,
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
    require_once VIEW_PATH . 'user/accounts/customer-order.php';
  }

  // Hiển thị order detail
  public function showOrderDetailPage($orderID)
  {
    $customer = $this->customer;
    $order = $this->order->getOrderByID($orderID, $customer['id']);
    $order_details = $this->order_detail->getOrderDetailByOrderID($orderID);

    require_once VIEW_PATH . 'user/accounts/customer-order-detail.php';
  }
}
