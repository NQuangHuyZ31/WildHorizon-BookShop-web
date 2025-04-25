<?php

namespace App\Controllers\User;

use App\Controllers\Controller;
use App\Models\OTPVerify;
use App\Requests\RegisterValidate;
use App\Requests\LoginValidate;
use Core\CSRF;
use Core\Session;
use App\Models\User;
use App\Requests\VerifyOtpValidate;
use Core\Response;
use Core\SendMail;
use Helpers\Hash;
use Helpers\Redirect;

class AuthController extends Controller
{

  protected $user;
  protected $optVerify;

  public function __construct()
  {
    parent::__construct();
    $this->user = new User();
    $this->optVerify = new OTPVerify();
  }

  // Đăng nhập
  public function index()
  {

    require VIEW_PATH . 'user/login.php';
  }

  public function handelLogin()
  {

    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
      Redirect::redirectWithError(405, 'Có lỗi trong quá trình đăng nhập. Vui lòng thử lại.', '/dang-nhap');
    }

    // Xác thực CSRF
    if (!CSRF::verifyToken($_POST['csrf_token'])) {
      Redirect::redirectWithError(405, 'Có lỗi trong quá trình đăng nhập', '/dang-nhap');
    }

    CSRF::destroyToken();

    $data = $_POST;
    $error = LoginValidate::validate($data);

    if (!empty($error)) {

      Redirect::redirectWithError(404, $error, '/dang-nhap');
    }

    if ($this->auth->login($data['email'], $data['password'])) {

      if (Session::get('user')['role'] == 'customer') {

        header('location: ' . Session::get('current_url') . '');
      } else {

        Session::delete('user');
        Redirect::redirectWithError(404, 'Email hoặc passowrd không đúng', '/dang-nhap');
      }
    } else {

      Redirect::redirectWithError(404, 'Email hoặc password không đúng', '/dang-nhap');
    }
  }

  // Đăng ký tài khoản
  public function register()
  {

    require VIEW_PATH . 'user/register.php';
  }

  public function handleRegister()
  {

    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
      Redirect::redirectWithError(405, 'Có lỗi xảy ra. Vui lòng đăng ký lại.', '/dang-ky');
    }

    // Xác thực CSRF
    if (!CSRF::verifyToken($_POST['csrf_token'])) {
      Redirect::redirectWithError(405, 'Có lỗi xảy ra. Vui lòng đăng ký lại.', '/dang-ky');
    }

    CSRF::destroyToken();

    // Lưu dữ liệu form
    $data = $_POST;
    Session::set('data', [
      'username' => $data['username'],
      'email' => $data['email'],
    ]);

    // Validate Form
    $error = RegisterValidate::registerValidate($data);

    // Kiểm tra lỗi
    if (!empty($error)) {
      Redirect::redirectWithError(404, $error, '/dang-ky');
    }

    // Xóa data đã lưu
    Session::delete('data');

    // Check email, nếu tồn tại thì gửi lại code
    $exitUser = $this->user->checkEmail($data['email'], 'is_active');
    if ($exitUser) {
      Session::set('pending_email', $exitUser['email']);
      Session::set('pending_username', $exitUser['username']);
      Session::set('pending_user_id', $exitUser['id']);
      $this->sendOTP($exitUser['email'], $exitUser['username'], $exitUser['id']);
      header('location: ' . BASE_URL . '/dang-ky/verify-account');
      exit;
    }

    // Lưu tài khoản với trạng thái chưa active
    $resgisterData = [
      'username' => $data['username'],
      'email' => $data['email'],
      'password' =>  password_hash($data['password'], PASSWORD_DEFAULT),
      'fb_id' => null,
      'status' => 'is_active'
    ];

    $userID = $this->user->insert($resgisterData);
    if ($userID) {
      $user = $this->user->find($userID);

      Session::set('pending_email', $user['email']);
      Session::set('pending_username', $user['username']);
      Session::set('pending_user_id', $user['id']);
      $this->sendOTP($user['email'], $user['username'], $user['id']);
      header('location: ' . BASE_URL . '/dang-ky/verify-account');
    }
  }

  // Hiển thị trang verify
  public function showVerifyAccount()
  {
    require_once VIEW_PATH . 'user/verify-account.php';
  }

  // Gửi otp
  public function sendOTP($email, $customer, $userID)
  {
    $otp = rand(1000, 9999);
    $otp_hash = Hash::encrypt($otp, OTP_HASH_KEY);

    $otpVerifyData = [
      'user_id' => $userID,
      'otp_code' => $otp_hash,
      'expired' => time() + 300,
      'type' => 'verify account',
      'created_at' => date('Y-m-d H:i:s'),
    ];

    // $this->optVerify->insert($otpVerifyData);
    if ($this->optVerify->insert($otpVerifyData)) {
      SendMail::sendOTP($email, $customer, $otp, 'Xác thực tài khoản');
    }
  }

  // Verify account
  public function verifyAccount()
  {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
      Redirect::redirectWithError(405, 'Có lỗi trong quá trình xác thực. Vui lòng thử lại', '/dang-ky/verify-account');
    }

    // Xác thực CSRF 
    if (!CSRF::verifyToken($_POST['csrf_token'])) {
      Redirect::redirectWithError(400, 'Có lỗi trong quá trình xác thực. Vui lòng thử lại.', '/dang-ky/verify-account');
    }

    CSRF::destroyToken();

    // kiểm tra lỗi dữ liệu
    $error = VerifyOtpValidate::validate($_POST);

    if (!empty($error)) {
      Redirect::redirectWithError(400, $error, '/dang-ky/verify-account');
    }

    // Ghép chuỗi OTP từ mảng input
    $otp_value = implode('', $_POST['code_verify'] ?? []);

    // Lấy thông tin OTP của người dùng
    $otp_user = $this->optVerify->getOTP(Session::get('pending_user_id'), false);

    // Kiểm tra OTP hợp lệ
    if (!Hash::verify($otp_value, $otp_user['otp_code'], OTP_HASH_KEY)) {
      Redirect::redirectWithError(400, 'Mã OTP không đúng', '/dang-ky/verify-account');
    }

    // Kiểm tra OTP còn hạn
    if (!$otp_user || $otp_user['expired'] <= time()) {
      Redirect::redirectWithError(400, 'Mã OTP đã hết hạn', '/dang-ky/verify-account');
    }

    try {
      //code...
      $this->db->beginTransaction();

      $this->optVerify->update(Session::get('pending_user_id'), $otp_user['id'], 1, 'is_verify');
      $this->user->updateColumn('status', 'active', Session::get('pending_user_id'));

      $this->db->commit();

      Session::delete('pending_user_id');
      Session::delete('pending_username');
      Session::delete('pending_email');
      Redirect::redirectWithSuccess(200, 'Xác thực thành công. Có thể đăng nhập', '/dang-nhap');
    } catch (\Throwable $th) {
      //throw $th;
      $this->db->rollBack();
      Redirect::redirectWithError(400, 'Có lỗi trong quá trình xác thực. Vui lòng thử lại.', '/dang-ky/verify-account');
    }
  }

  // Resend otp verify 
  public function resendOTP()
  {

    // Check Method
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
      Response::json([
        'error' => [
          'msg' => 'Có lỗi xảy ra. Vui lòng thử lại.'
        ],
        'token' => $_POST['csrf_token']
      ], 500);
    }

    // check CSRF
    if (!CSRF::verifyToken($_POST['csrf_token'])) {
      Response::json([
        'error' => [
          'msg' => 'Có lỗi xảy ra. Vui lòng thử lại.'
        ],
        'token' => $_POST['csrf_token']
      ], 400);
    }

    CSRF::destroyToken();
    $token = CSRF::generateToken();

    $this->sendOTP(Session::get('pending_email'), Session::get('pending_username'), Session::get('pending_user_id'));

    Response::json([
      'success' => [
        'msg' => 'OTP đã được gửi qua email'
      ],
      'token' => $token
    ], 200);
  }

  // Đăng xuất
  public function logout()
  {

    if (CSRF::verifyToken($_POST['csrf_token'])) {

      $this->auth->logout();

      header('location: ' . BASE_URL . '/');
    }
  }
}
