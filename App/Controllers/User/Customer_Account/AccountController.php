<?php

namespace App\Controllers\User\Customer_Account;

use App\Controllers\User\Customer_Account\CustomerController;
use App\Models\Order;
use App\Models\UserVoucher;
use App\Models\Voucher;
use App\Requests\UpdateCustomerInfoValidate;
use Core\CSRF;
use Core\Response;
use Core\Session;

class AccountController extends CustomerController
{

  protected $page = 'Tài khoản';
  protected $order;
  protected $voucher;
  protected $user_voucher;

  public function __construct()
  {
    parent::__construct();
    $this->order = new Order();
    $this->voucher = new Voucher();
    $this->user_voucher = new UserVoucher();
  }

  public function index()
  {

    $pageName = $this->page;

    $customer = $this->customer;

    $countVoucher = count($this->voucher->getAllByUser($customer['id']));

    $countVoucherFreeShip = count($this->user_voucher->getByType($customer['id'], 'freeship'));

    list($year, $month, $day) = !empty($customer['birthday']) ? explode("-", $customer['birthday']) : '';

    $countOrder = $this->order->getCountOrder(Session::get('user')['id']);
    $sumTotalOrder = $this->order->getSumTotalOrder(Session::get('user')['id']);

    require_once VIEW_PATH . 'user/accounts/account.php';
  }

  // Cập nhật thông tin
  public function updateInfo()
  {
    // kiểm tra trước khi xử lí 
    $this->checkMethod($_POST['csrf_token']);

    CSRF::destroyToken();
    $token = CSRF::generateToken();
    $data = $_POST;

    // Validate form cập nhật thông tin khách hàng
    $error = UpdateCustomerInfoValidate::validate($data);

    if (!empty($error)) {
      Response::json([
        'error' => [
          'msg' => $error
        ],
        'token' => $token
      ], 404);
    }

    // update thông tin khách hàng
    $customerData = [
      'username' => $data['username'],
      'phone' => $data['phone'],
      'gender' => $data['gender'],
      'birthday' => $data['year'] . '-' . $data['mounth'] . '-' . $data['day']
    ];

    if ($this->user->updateInfoUser($customerData, Session::get('user')['id'])) {
      $userSession = Session::get('user');
      $userSession['username'] = $data['username']; // tên mới
      Session::set('user', $userSession);
      Response::json([
        'success' => [
          'msg' => 'Cập nhật thành công'
        ],
        'token' => $token
      ], 200);
    }
  }
}
