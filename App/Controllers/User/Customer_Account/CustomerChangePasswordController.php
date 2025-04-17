<?php

namespace App\Controllers\User\Customer_Account;

use App\Models\OTPVerify;
use App\Models\User;
use App\Requests\ChangePasswordValidate;
use App\Requests\VerifyOtpValidate;
use Core\CSRF;
use Core\Response;
use Core\SendMail;
use Core\Session;
use Helpers\Hash;
use Helpers\Redirect;

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

    $this->checkMethod($_POST['csrf_token']);

    CSRF::destroyToken();
    $token = CSRF::generateToken();

    // Validate dữ liệu đầu vào
    $error = ChangePasswordValidate::validate($_POST);
    if (!empty($error)) {
      Response::json([
        'error' => [
          'msg' => $error,
        ],
        'token' => $token
      ], 404);
    }

    // Kiểm tra mật khẩu hiện tại
    $userPassword = $this->user->getColumn('password', Session::get('user')['id']);

    if (!password_verify($_POST['old_password'], $userPassword['password'])) {
      Response::json([
        'error' => [
          'msg' => 'Mật khẩu hiện tại không đúng',
        ],
        'token' => $token
      ], 404);
    }

    // Sen code verify change passoword
    try {
      //code...
      $this->sendOTP();

      // Lưu lại dữ liệu
      Session::set(
        'data',
        [
          'old_password' => $_POST['old_password'],
          'new_password' => $_POST['new_password'],
          'cf_new_passowrd' => $_POST['confirm_new_password']
        ]
      );

      Response::json([
        'success' => [
          'msg' => 'Mã OTP để thay đổi password đã được gửi vào mail.',
        ],
        'url' => BASE_URL,
        'token' => $token,
      ], 200);
    } catch (\Throwable $th) {
      //throw $th;
      Response::json([
        'error' => [
          'msg' => $th->getMessage()
        ],
        'token' => $_POST['csrf_token']
      ], 500);
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

  // Verify otp
  public function verifyChangePassword()
  {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
      Redirect::redirectWithError(405, 'Phương thức không hỗ trợ', '/customer/changepassword/verify');
    }

    if (empty($_POST['csrf_token']) || !CSRF::verifyToken($_POST['csrf_token'])) {
      Redirect::redirectWithError(405, 'Lỗi xác thực CSRF', '/customer/changepassword/verify');
    }

    CSRF::destroyToken();

    // Validate OTP
    $error = VerifyOtpValidate::validate($_POST);
    if (!empty($error)) {
      Redirect::redirectWithError(404, $error, '/customer/changepassword/verify');
    }

    // Ghép chuỗi OTP từ mảng input
    $otp_value = implode('', $_POST['code_verify'] ?? []);

    // Lấy thông tin OTP của người dùng
    $otp_user = $this->optVerify->getOTP(Session::get('user')['id'], false);

    // Kiểm tra OTP hợp lệ
    if (!Hash::verify($otp_value, $otp_user['otp_code'], OTP_HASH_KEY)) {
      Redirect::redirectWithError(404, 'Mã OTP không đúng', '/customer/changepassword/verify');
    }

    // Kiểm tra OTP còn hạn
    if (!$otp_user || $otp_user['expired'] <= time()) {
      Redirect::redirectWithError(404, 'Mã OTP đã hết hạn', '/customer/changepassword/verify');
    }

    try {
      $this->db->beginTransaction();

      // TODO: Thực hiện thay đổi mật khẩu tại đây
      $newPassword = password_hash($_POST['new_password'], PASSWORD_DEFAULT);
      $this->user->updatePassword(Session::get('user')['id'], $newPassword);
      $this->optVerify->update(Session::get('user')['id'], $otp_user['id'], 1, 'is_verify');
      $this->db->commit();
      Session::delete('data');
      Session::set('success', [
        'status' => 1,
        'msg' => 'Xác thực thành công. Mật khẩu đã được cập nhật.'
      ]);
      header('location: ' . BASE_URL . '/customer/account');
    } catch (\Throwable $th) {
      $this->db->rollBack();
      Redirect::redirectWithError(500, 'Đã xảy ra lỗi: ' . $th->getMessage() . '', '/customer/changepassword/verify');
    }
  }

  // Gửi lại OTP
  public function reSendOTP()
  {

    $this->checkMethod($_POST['csrf_token']);

    // Xóa csrf_token cũ
    CSRF::destroyToken();
    $token = CSRF::generateToken();
    $customer = $this->customer;

    // reSend code verify change passoword
    try {
      //code...
      $this->sendOTP();
      Response::json([
        'success' => [
          'msg' => 'OTP đã được gửi qua mail',
        ],
        'token' => $token
      ], 200);
    } catch (\Throwable $th) {
      //throw $th;
      Response::json([
        'error' => [
          'msg' => $th->getMessage(),
        ],
        'token' => $_POST['csrf_token']
      ], 500);
    }
  }

  // Gửi OTP
  public function sendOTP()
  {
    $otp = rand(1000, 9999);
    $otp_hash = Hash::encrypt($otp, OTP_HASH_KEY);
    $customer = $this->customer;

    $otpVerifyData = [
      'user_id' => $customer['id'],
      'otp_code' => $otp_hash,
      'expired' => time() + 300,
      'type' => 'change password',
      'created_at' => date('Y-m-d H:i:s'),
    ];

    // $this->optVerify->insert($otpVerifyData);
    if ($this->optVerify->insert($otpVerifyData)) {
      SendMail::sendOTP($customer['email'], $customer['username'], $otp, 'Thay đổi mật khẩu');
    }
  }
}
