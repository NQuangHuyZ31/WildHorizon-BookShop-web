<?php

namespace Helpers;

use Core\Session;

class Redirect
{
  public static function redirectWithError($code, $msg, $url)
  {
    http_response_code($code);
    Session::set('success', [
      'status' => 0,
      'msg' => $msg
    ]);
    header('location: ' . BASE_URL . '' . $url . '');
    exit;
  }
}
