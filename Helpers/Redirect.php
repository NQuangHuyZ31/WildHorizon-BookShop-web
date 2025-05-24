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

  public static function redirectWithSuccess($code, $msg, $url)
  {
    http_response_code($code);
    Session::set('success', [
      'status' => 1,
      'msg' => $msg
    ]);
    header('location: ' . BASE_URL . '' . $url . '');
    exit;
  }

  public static function redirectCurrentURL($msg, $status)
  {
    Session::set('success', [
      'status' => $status,
      'msg' => $msg
    ]);
    header('location: ' . Session::get('current_url') . '');
    exit;
  }

  public static function redirectNoMSG()
  {
    header('location: ' . Session::get('current_url') . '');
    exit;
  }
}
