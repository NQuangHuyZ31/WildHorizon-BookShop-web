<?php

namespace App\Controllers\User;

use App\Controllers\Controller;
use App\Requests\RegisterValidate;
use App\Requests\LoginValidate;
use Core\CSRF;
use Core\Session;
use App\Models\User;

class AuthController extends Controller
{

  protected $user;
  public function __construct()
  {
    parent::__construct();
    $this->user = new User();
  }

  // Đăng nhập
  public function index()
  {

    require VIEW_PATH . 'user/login.php';
  }

  public function handelLogin()
  {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

      if (CSRF::verifyToken($_POST['csrf_token'])) {

        CSRF::destroyToken();
        $data = $_POST;
        $error = LoginValidate::validate($data);

        if (!empty($error)) {

          Session::set('success', ['status' => 0, 'msg' => $error]);
          header('location:' . BASE_URL . '/dang-nhap');
        } else {

          if ($this->auth->login($data['email'], $data['password'])) {

            if (Session::get('user')['role'] == 'customer') {

              header('location: ' . Session::get('current_url') . '');
            } else {

              Session::delete('user');
              Session::set('success', ['status' => 0, 'msg' => "Email hoặc password không đúng"]);
              header('location:' . BASE_URL . '/dang-nhap');
            }
          } else {

            Session::set('success', ['status' => 0, 'msg' => "Email hoặc password không đúng"]);
            header('location:' . BASE_URL . '/dang-nhap');
          }
        }
      }
    }
  }

  // Đăng ký tài khoản
  public function register()
  {

    require VIEW_PATH . 'user/register.php';
  }

  public function handleRegister()
  {

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

      if (CSRF::verifyToken($_POST['csrf_token'])) {

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

          Session::set('success', ['status' => 0, 'msg' => $error]);

          header('location:' . BASE_URL . '/dang-ky');
          exit;
        } else {

          Session::delete('data');
          $resgisterData = [
            'username' => $data['username'],
            'email' => $data['email'],
            'password' =>  password_hash($data['password'], PASSWORD_DEFAULT)
          ];

          $this->user->insert($resgisterData);
          Session::set('success', ['status' => 1, 'msg' => 'Đăng kí thành công']);
          header('location:' . BASE_URL . '/dang-nhap');
        }
      }
    } else {

      Session::set('success', ['status' => 0, 'msg' => 'Phương thức không hỗ trợ']);
    }
  }

  public function logout()
  {

    if (CSRF::verifyToken($_POST['csrf_token'])) {

      $this->auth->logout();

      header('location: ' . BASE_URL . '/');
    }
  }
}
