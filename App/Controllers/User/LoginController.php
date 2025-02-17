<?php

namespace App\Controllers\User;

use App\Controllers\Controller;
use App\Requests\RegisterValidate;
use App\Requests\LoginValidate;
use Core\CSRF;
use Core\Session;

class LoginController extends Controller
{

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

              if (Session::get('user')['is_first_login'] == 0) {

                Session::set('success', 'Đăng nhập thành công');
                $stmt = $this->db->prepare("update users set firstlogin = 1 where user_id=?");
                $stmt->bindParam(1, Session::get('user')['id']);
                $stmt->execute();
              }

              header('location: ' . Session::get('current_url') . '');
            } else {
              Session::delete('user');

              Session::set('failLogin', 'email hoặc password không đúng');

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
          $hashedPassword = password_hash($data['password'], PASSWORD_DEFAULT);
          $currentDate = date('Y-m-d');

          $stmt = $this->db->prepare('INSERT INTO users(name, email, password, role, created_at) 
                            VALUES(:name, :email, :password, "customer", :created_at)');
          $stmt->bindParam(':name', $data['username']);
          $stmt->bindParam(':email', $data['email']);
          $stmt->bindParam(':password', $hashedPassword);
          $stmt->bindParam(':created_at', $currentDate);
          $stmt->execute();
          header('location:' . BASE_URL . '/dang-nhap');
        }
      }
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
