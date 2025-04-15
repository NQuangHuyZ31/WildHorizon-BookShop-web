<?php

namespace App\Controllers\User\Customer_Account;

use App\Models\OTPVerify;
use App\Models\User;
use App\Requests\ChangePasswordValidate;
use Core\CSRF;
use Core\SendMail;
use Core\Session;
use Helpers\Hash;

class CustomerChangePasswordController extends CustomerController
{
  protected $user;
  protected $optVerify;
  public function __construct()
  {
    parent::__construct();
    $this->user = new User();
    $this->optVerify = new OTPVerify();
  }

  public function index()
  {

    $customer = $this->customer;
    Session::delete('data');
    require_once VIEW_PATH . 'user/accounts/changepassword/customer-changepw.php';
  }

  // Gửi code verify
  public function sendCodeVerifyChangePW()
  {

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      if (CSRF::verifyToken($_POST['csrf_token'])) {
        CSRF::destroyToken();
        $token = CSRF::generateToken();

        // Validate dữ liệu đầu vào
        // $error = ChangePasswordValidate::validate($_POST);

        // if (!empty($error)) {
        //   http_response_code(400);
        //   echo json_encode(['msg' => $error, 'token' => $token]);
        //   exit;
        // }

        // // // Kiểm tra mật khẩu hiện tại
        $userPassword = $this->user->getColumn('password', Session::get('user')['id']);

        if (!password_verify($_POST['old_password'], $userPassword['password'])) {
          http_response_code(400);
          echo json_encode(['msg' => 'Mật khẩu hiện tại không đúng', 'token' => $token]);
          exit;
        }

        // Sen code verify change passoword
        try {
          //code...
          $otp = rand(1000, 9999);
          $otp_hash = Hash::encrypt($otp, OTP_HASH_KEY);
          $customer = $this->customer;

          $otpVerifyData = [
            'user_id' => $customer['id'],
            'otp_code' => $otp_hash,
            'expired' => time() + 300,
            'type' => 'change password',
            'created_at' => date('Y-m-d')
          ];

          // $this->optVerify->insert($otpVerifyData);
          // if ($this->optVerify->insert($otpVerifyData)) {
          //   SendMail::sendOTP($customer['email'], $customer['username'], $otp, 'Thay đổi mật khẩu');
          // }
          // Lưu lại dữ liệu
          // Session::set(
          //   'data',
          //   [
          //     'old_password' => $_POST['old_password'],
          //     'new_password' => $_POST['new_password'],
          //     'cf_new_passowrd' => $_POST['confirm_new_password']
          //   ]
          // );
          http_response_code(200);
          echo json_encode([
            'msg' => 'Mail đã được gửi',
            'url' => BASE_URL,
            'token' => $token,
            'code' => $otp,
            'status' => 200,
            'verify' => Hash::verify($otp, $otp_hash, OTP_HASH_KEY) ? 1 : 0,
          ]);
          exit;
        } catch (\Throwable $th) {
          //throw $th;
          http_response_code(400);
          echo json_encode(['msg' => $th->getMessage()]);
          exit;
        }
        // echo json_encode(['data' => $_POST, 'url' => BASE_URL]);
      } else {
        http_response_code(405);
        echo json_encode(['msg' => 'Lỗi xác thực csrf', 'token' => $_POST['csrf_token']]);
        exit;
      }
    } else {
      http_response_code(405);
      echo json_encode(['msg' => 'Phương thức không được hỗ trợ', 'token' => $_POST['csrf_token']]);
      exit;
    }
  }

  // Hiển thị trang verify
  public function showChangePWVerifyPage()
  {

    $customer = $this->customer;
    if (!Session::has('data')) {
      header('location: ' . BASE_URL . '/customer/changepassword');
    }
    require_once VIEW_PATH . 'user/accounts/changepassword/customer-changepw-verify.php';
  }

  public function verifyChangePassword()
  {
    $otp = Hash::encrypt('1234', 'iuh');
    $opt_decrype = Hash::decrypt($otp, 'iuh');

    echo $otp . ',' . $opt_decrype;
  }
}
