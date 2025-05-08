<?php

namespace App\Middleware;

// use Core\JWTHandler;
// use Core\Response;

// class AuthMiddleware
// {
//   public static function verify()
//   {
//     $headers = getallheaders(); // Lấy tất cả headers của request

//     if (!isset($headers['Authorization'])) {
//       Response::json(["message" => "Authorization token is missing"], 401);
//       exit();
//     }

//     $token = str_replace("Bearer ", "", $headers['Authorization']);
//     $decoded = JWTHandler::verifyToken($token);

//     if (!$decoded) {

//       Response::json(["message" => "Invalid or expired token"], 401);
//       exit();
//     }

//     return $decoded; // Trả về thông tin user từ token
//   }
// }

use Core\Middleware;
use Core\Session;

class AuthMiddleware implements Middleware
{
  public function handle($request, $next)
  {
    // Nếu chưa đăng nhập
    if (!Session::has('user')) {
      // Nếu là request từ trình duyệt -> chuyển hướng
      if (!self::isApiRequest($request)) {
        header('Location:' . BASE_URL . '/dang-nhap');
      } else {
        // Nếu là request API -> trả JSON lỗi
        http_response_code(401);
        echo json_encode(['error' => 'Chưa đăng nhập', 'login_url' => BASE_URL . '/dang-nhap']);
      }
      exit; // Quan trọng!
    }

    // Nếu không phải customer → hủy session
    if (Session::get('user')['role'] != 'customer') {
      Session::delete('user');
      header('Location:' . BASE_URL . '/');
      exit;
    }

    return $next($request);
  }

  // Hàm phụ để kiểm tra xem có phải gọi API không (dựa vào header)
  private static function isApiRequest($request)
  {
    $accept = $_SERVER['HTTP_ACCEPT'] ?? '';
    return stripos($accept, 'application/json') !== false;
  }
}
