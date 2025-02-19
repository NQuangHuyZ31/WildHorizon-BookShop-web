<?php

namespace App\Controllers;

use Core\Database;
use Core\Auth;

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
}
