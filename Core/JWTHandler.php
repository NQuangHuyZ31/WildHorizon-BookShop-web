<?php

namespace Core;

require 'vendor/autoload.php';

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class JWTHandler
{
  private static $secret_key = "whr-key"; // Thay bằng secret key mạnh hơn
  private static $algorithm = "HS256"; // Thuật toán mã hóa

  // Hàm tạo JWT
  public static function generateToken($payload, $expiry = 60)
  {
    $issuedAt = time();
    $expireAt = $issuedAt + $expiry; // Token có hiệu lực trong $expiry giây

    $payload['iat'] = $issuedAt;  // Thời điểm tạo token
    $payload['exp'] = $expireAt;  // Thời điểm hết hạn token

    return JWT::encode($payload, self::$secret_key, self::$algorithm);
  }

  // Hàm xác thực và giải mã JWT
  public static function verifyToken($token)
  {
    try {
      $decoded = JWT::decode($token, new Key(self::$secret_key, self::$algorithm));

      // Kiểm tra token đã hết hạn chưa
      if (isset($decoded->exp) && $decoded->exp < time()) {
        throw new \Exception("Token has expired");
      }

      return (array) $decoded;
    } catch (\Exception $e) {
      return null; // Trả về null nếu token không hợp lệ hoặc hết hạn
    }
  }
}
