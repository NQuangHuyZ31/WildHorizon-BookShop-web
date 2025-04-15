<?php

namespace App\Controllers\User\Customer_Account;

use App\Controllers\User\Customer_Account\CustomerController;
use App\Models\Order;
use App\Requests\UpdateCustomerInfoValidate;
use Core\CSRF;
use Core\Session;

class AccountController extends CustomerController
{
  protected $order;

  public function __construct()
  {
    parent::__construct();
    $this->order = new Order();
  }

  public function index()
  {

    $customer = $this->customer;

    list($year, $month, $day) = !empty($customer['birthday']) ? explode("-", $customer['birthday']) : '';

    $countOrder = $this->order->getCountOrder(Session::get('user')['id']);
    $sumTotalOrder = $this->order->getSumTotalOrder(Session::get('user')['id']);

    require_once VIEW_PATH . 'user/accounts/account.php';
  }

  // Cập nhật thông tin
  public function updateInfo()
  {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      if (CSRF::verifyToken($_POST['csrf_token'])) {

        CSRF::destroyToken();
        $csrf_token = CSRF::generateToken();

        $data = $_POST;
        // Validate form cập nhật thông tin khách hàng
        $error = UpdateCustomerInfoValidate::validate($data);

        if (!empty($error)) {
          echo json_encode([
            'success' => [
              'status' => 0,
              'msg' => $error
            ],
            'token' => $csrf_token
          ]);
        }

        // update thông tin khách hàng
        else {
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
            echo json_encode([
              'success' => [
                'status' => 1,
                'msg' => 'Cập nhật thành công'
              ],
              'token' => $csrf_token
            ]);
          }
        }
      } else {
        echo json_encode([
          'success' => [
            'status' => 0,
            'msg' => 'Lỗi xác thực csrf_token'
          ],
          'token' => $_POST['csrf_token']
        ]);
      }
    } else {
      echo json_encode([
        'success' => [
          'status' => 0,
          'msg' => 'Phương thức không được hỗ trợ'
        ],
        'token' => $_POST['csrf_token']
      ]);
    }
  }
}
