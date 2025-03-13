<?php

namespace App\Controllers\Api;

use App\Controllers\Controller;
use App\Requests\LoginValidate;
use Core\JWTHandler;
use Core\Response;

class LoginController extends Controller
{
  public function handleLogin()
  {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
      Response::json(['msg' => 'Method not allowed'], 405);
      exit();
    }

    // Lấy dữ liệu JSON từ request
    $data = Response::get();

    // Kiểm tra JSON hợp lệ
    if (!$data) {
      Response::json(['msg' => 'Invalid JSON'], 400);
      exit();
    }

    // Kiểm tra trường dữ liệu bắt buộc
    if (!isset($data['email']) || !isset($data['password'])) {
      Response::json(['msg' => 'Invalid input'], 401);
      exit();
    }

    // Kiểm tra lỗi validate
    $errors = LoginValidate::validate($data);
    if (!empty($errors)) {
      Response::json(['error' => $errors], 401);
      exit();
    }

    // Xử lý đăng nhập
    $email = $data['email'];
    $password = $data['password'];
    $user = $this->auth->login($email, $password);

    if (!$user || !isset($user['role']) || $user['role'] !== 'customer') {
      Response::json(['msg' => 'Username hoặc password không đúng'], 401);
      exit();
    }
    $payload = [
      'id' => $user['id'],
      'username' => $user['firstname'] . ' ' . $user['lastname'],
      'email' => $user['email'],
      'phone' => $user['phone']
    ];
    // Tạo token JWT
    $token = JWTHandler::generateToken($payload);
    Response::json(['user' => $payload, 'access_token' => $token], 200);
  }
}
