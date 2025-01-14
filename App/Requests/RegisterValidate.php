<?php

namespace App\Requests;

class RegisterValidate
{

  public static function registerValidate($data)
  {
    $errors = [];

    // Kiểm tra username
    if (empty($data['username'])) {
      $errors['username'] = 'Không được để trống';
    }

    // Kiểm tra email
    if (empty($data['email'])) {
      $errors['email'] = 'Không được để trống';
    }

    // Kiểm tra password
    if (empty($data['password'])) {
      $errors['password'] = 'Không được để trống';
    }

    // Kiểm tra confirm password
    if (empty($data['cfpassword'])) {
      $errors['cfpassword'] = 'Không được để trống';
    }

    // Kiểm tra password và confirm password có trùng khớp không
    if (!empty($data['password']) && !empty($data['cfpassword']) && $data['password'] !== $data['cfpassword']) {
      $errors['cfpassword'] = 'Password không trùng khớp';
    }

    return $errors;
  }
}
