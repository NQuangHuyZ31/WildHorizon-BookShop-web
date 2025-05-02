<?php

namespace App\Controllers\User\Customer_Account;

use App\Models\Feedback;
use App\Models\OrderReview;
use App\Models\Reviews;
use Core\Response;
use Core\Session;

class CustomerReviewController extends CustomerController
{

  protected $page = 'Nhận xét của tôi';
  protected $order_review;
  protected $product_review;
  protected $feedback;

  public function __construct()
  {
    parent::__construct();
    $this->order_review = new OrderReview();
    $this->product_review = new Reviews();
    $this->feedback = new Feedback();
  }

  public function index()
  {

    $pageName = $this->page;

    $customer = $this->customer;

    $order_reviews = $this->order_review->getOrderReviewByUserID($customer['id']);

    $feedbacks = $this->feedback->find($customer['id'], 'Đã phản hồi');
    require_once VIEW_PATH . 'user/accounts/customer-review.php';
  }

  public function getProductReview()
  {
    try {
      //code...
      $order_id = $_GET['orderID'];
      $product_reviews = $this->product_review->getProductReviewByOrder($order_id);
      $data = [];

      foreach ($product_reviews as $review) {
        $data[] = [
          'product_id' => $review['product_id'],
          'product_name' => $review['product_name'],
          'product_image' => $review['product_image'],
          'product_rating' => $review['rating_id'],
          'product_comment' => $review['comment']
        ];
      }

      Response::json([
        'success' => [
          'msg' => 'Thành công',
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
}
