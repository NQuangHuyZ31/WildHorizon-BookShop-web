<?php

namespace App\Controllers\User;

use App\Controllers\Controller;
use App\Requests\RegisterValidate;
use Core\Auth;
use Core\CSRF;
use Core\Session;

class LoginController extends Controller
{
  public function index()
  {

    include_once VIEW_PATH . 'user/login.php';
  }

  public function register()
  {

    include_once VIEW_PATH . 'user/register.php';
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
          header('location:' . BASE_URL . '/dang-nhap');
        }
      }
    }
  }

  public function handelLogin()
  {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $email = $_POST['email'];
      $password = $_POST['password'];
      if (CSRF::verifyToken($_POST['csrf_token'])) {
        CSRF::destroyToken();
        if ($email == 'huynguyenharu31@gmail.com' && $password == '123') {
          Session::set('user', [
            'username' => 'nguyenquanghuy',
            'role' => 'user'
          ]);
          Session::set('success', 'Đăng nhập thành công');
          header('location:' . BASE_URL . '/');
        } else {
          header('location:' . BASE_URL . '/dang-nhap');
        }
      }
    }
  }

  public function logout()
  {
    $auth = new Auth($this->db);

    if (CSRF::verifyToken($_POST['csrf_token'])) {
      $auth->logout();

      header('location: ' . BASE_URL . '/');
    }
  }
}
