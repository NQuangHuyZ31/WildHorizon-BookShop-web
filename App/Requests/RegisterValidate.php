<?php

namespace App\Requests;

use App\Models\User;

class RegisterValidate
{

  public static function registerValidate($data)
  {

    $user = new User();

    $errors = [];

    // Kiểm tra username
    if (empty($data['username'])) {
      $errors['username'] = 'Không được để trống';
    }

    // Kiểm tra email
    if (empty($data['email'])) {
      $errors['email'] = 'Không được để trống';
    }

    if ($user->checkEmail($data['email'])) {
      $errors['email'] = "email đã tồn tại";
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
