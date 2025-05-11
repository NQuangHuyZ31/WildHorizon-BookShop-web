<?php

namespace App\Requests;

class LoginValidate
{

  public static function validate($data)
  {

    $error = '';

    if (empty($data['email']) || empty($data['password'])) {
      $error = 'Không được để trống';
    }

    // Kiểm tra hợp lệ email
    else if (!preg_match('/^[\w\.-]+@[\w\.-]+\.com$/', $data['email'])) {
      $error = 'Email không hợp lệ';
    }

    // Kiểm tra hợp lệ password có 6 kí tự
    else if (strlen($data['password']) < 6) {
      $error = 'Mật khẩu phải có ít nhất 6 kí tự';
    }

    // Kiểm tra hợp lệ password
    // else if (!preg_match('/^(?=.*[A-Z])(?=.*[\W_]).{6,}$/', $data['password'])) {
    //   $error = 'Email hoặc mật khẩu không ';
    // }

    return $error;
  }
}
