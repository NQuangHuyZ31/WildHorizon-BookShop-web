<?php

namespace App\Requests;

use App\Models\User;

class RegisterValidate
{

  public static function validate($data)
  {

    $user = new User();

    $error = '';

    // Kiểm tra username
    if (empty($data['username']) || empty($data['email']) || empty($data['password']) || empty($data['cfpassword'])) {

      $error = 'Không được để trống';
    }

    // Kiểm tra hợp lệ username
    else if (!preg_match('/^[a-zA-ZÀ-Ỵà-ỵ\s]+$/u', $data['username'])) {
      $error = 'Tên người dùng không đúng định dạng';
    }

    // Kiểm tra email đúng dạng
    else if (!preg_match('/^[\w\.-]+@[\w\.-]+\.com$/', $data['email'])) {
      $error = 'Email không hợp lệ';
    }

    // Kiểm tra tồn tại email
    else if ($user->checkEmail($data['email'], 'active')) {
      $error = "email đã tồn tại";
    }

    // Kiểm tra độ dài mật khẩu
    else if (strlen($data['password']) < 6) {
      $error = 'Mật khẩu phải có ít nhất 6 kí tự';
    }

    // Kiểm tra password đúng định dạng
    else if (!preg_match('/^(?=.*[A-Z])(?=.*[\W_]).{6,}$/', $data['password'])) {
      $error = 'Mật khẩu không đúng định dạng';
    }

    // Kiểm tra password và confirm password có trùng khớp không
    else if (!empty($data['password']) && !empty($data['cfpassword']) && $data['password'] !== $data['cfpassword']) {
      $error = 'Password không trùng khớp';
    }

    return $error;
  }
}
