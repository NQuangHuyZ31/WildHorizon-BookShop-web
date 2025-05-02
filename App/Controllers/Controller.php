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

    $this->auth = new Auth();
  }

  public function checkMethod($csrf_token)
  {
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
