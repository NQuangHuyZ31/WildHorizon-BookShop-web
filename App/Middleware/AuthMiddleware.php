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

    if (!Session::has('user')) {
      header('Location:' . BASE_URL . '/dang-nhap');
    } else if (Session::get('user')['role'] != 'customer') {
      Session::delete('user');
      header('location:' . BASE_URL . '/');
    }
    return $next($request);
  }
}
