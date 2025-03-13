<?php

namespace Core;

class Response
{
  public static function json($data, $status_code)
  {

    header("Content-Type: application/json");
    http_response_code($status_code);
    echo json_encode($data);
    exit(); // Đảm bảo không có nội dung nào khác được gửi đi
  }

  public static function get()
  {
    $data = [];

    // Kiểm tra nếu Content-Type tồn tại và là application/json
    if (!empty($_SERVER["CONTENT_TYPE"]) && strpos($_SERVER["CONTENT_TYPE"], "application/json") !== false) {
      $json = file_get_contents('php://input');

      if ($json !== false) {
        $decoded = json_decode($json, true);
        if (json_last_error() === JSON_ERROR_NONE) {
          $data = $decoded;
        }
      }
    }

    return $data;
  }
}
