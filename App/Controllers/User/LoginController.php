<?php

namespace App\Controllers\User;

use App\Controllers\Controller;
use App\Requests\RegisterValidate;
use App\Requests\LoginValidate;
use Core\CSRF;
use Core\Session;
use App\Models\User;

class LoginController extends Controller
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

      $data = $_POST;

      $errors = LoginValidate::validate($data);

      if (CSRF::verifyToken($_POST['csrf_token'])) {

        CSRF::destroyToken();

        if (!empty($errors)) {

          Session::set('message', ['error' => $errors]);

          header('location:' . BASE_URL . '/dang-nhap');
        } else {

          if ($this->auth->login($data['email'], $data['password'])) {

            if (Session::get('user')['role'] == 'customer') {

              header('location: ' . Session::get('current_url') . '');
            } else {
              Session::delete('user');

              Session::set('error', 'email hoặc password không đúng');

              header('location:' . BASE_URL . '/dang-nhap');
            }
          } else {

            Session::set('failLogin', 'email hoặc password không đúng');

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

        // Lưu dữ liệu form
        $data = $_POST;

        $_SESSION['data'] = [
          'username' => $data['username'],
          'email' => $data['email'],
        ];

        // Validate Form
        $errors = RegisterValidate::registerValidate($data);

        CSRF::destroyToken();

        // Kiểm tra lỗi
        if (!empty($errors)) {

          Session::set('error', $errors);

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
          // echo $resgisterData['username'];
          header('location:' . BASE_URL . '/dang-nhap');
        }
      }
    } else {
      echo "Lỗi CSRF";
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
