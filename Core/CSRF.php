<?php

namespace Core;

use Core\Session;

class CSRF
{
  // Hàm tạo CSRF token và lưu vào session
  public static function generateToken()
  {
    if (empty(Session::get('csrf_token'))) {
      Session::set('csrf_token', bin2hex(random_bytes(32))); // Tạo token ngẫu nhiên 64 ký tự
    }
    return Session::get('csrf_token');
  }
  // Hàm kiểm tra CSRF token
  public static function verifyToken($token)
  {
    if (Session::get('csrf_token') && Session::get('csrf_token') === $token) {
      return true; // Token hợp lệ
    }
    return false; // Token không hợp lệ
  }
  // Hàm xóa CSRF token khỏi session
  public static function destroyToken()
  {
    Session::delete('csrf_token');
  }

  public static function e($string)
  {
    echo htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
  }
}
