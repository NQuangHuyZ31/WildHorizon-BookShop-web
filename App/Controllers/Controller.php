<?php

namespace App\Controllers;

use Core\Database;
use Core\Auth;
use Core\CSRF;
use Core\Response;

class Controller
{

  protected $db;
  protected $auth;

  public function __construct()
  {
    $this->db = Database::getInstance()->getConnection();

    if ($this->db === null) {
      die("Lỗi: Không thể kết nối database!");
    }

    // Bắt đầu phiên làm việc nếu chưa có
    if (session_status() === PHP_SESSION_NONE) {
      session_start();
    }

    $this->auth = new Auth();
  }

  public function checkMethod($csrf_token)
  {
    // if ($_SERVER['HTTP_X_REQUESTED_WITH'] !== 'XMLHttpRequest') {
    //   http_response_code(403);
    //   exit('Forbidden');
    // }

    // if (!isset($_SERVER['HTTP_REFERER']) || stripos($_SERVER['HTTP_REFERER'], 'https://wildhorizonbs.shoplands.store/') === false) {
    //   Response::json([
    //     'error' => [
    //       'msg' => 'Có lỗi xảy ra. Vui lòng thử lại'
    //     ],
    //     'token' => $csrf_token
    //   ], 405);
    // }

    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
      Response::json([
        'error' => [
          'msg' => 'Có lỗi xảy ra. Vui lòng thử lại'
        ],
        'token' => $csrf_token
      ], 405);
    }

    if (!CSRF::verifyToken($csrf_token)) {
      Response::json([
        'error' => [
          'msg' => 'Có lỗi xảy ra. Vui lòng thử lại'
        ],
        'token' => $csrf_token
      ], 400);
    }
  }
}
