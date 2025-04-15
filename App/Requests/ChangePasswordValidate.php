<?php

namespace App\Requests;

use App\Models\User;
use Core\Session;

class ChangePasswordValidate
{
  public static function validate($data)
  {
    $error = '';

    if (empty($data['old_password']) || empty($data['new_password']) || empty($data['confirm_new_password'])) {
      $error = 'Thông tin không được trống';
    }

    // Kiểm tra độ dài mật khẩu
    else if (strlen($data['new_password']) < 6) {
      $error = 'Mật khẩu mới phải có ít nhất 6 kí tự';
    }

    // Kiểm tra password đúng định dạng
    else if (!preg_match('/^(?=.*[A-Za-z])(?=.*[\W_]).{6,}$/', $data['new_password'])) {
      $error = 'Mật khẩu mới không đúng định dạng';
    }

    // Kiểm tra password và confirm password có trùng khớp không
    else if (!empty($data['new_password']) && !empty($data['confirm_new_password']) && $data['new_password'] !== $data['confirm_new_password']) {
      $error = 'Password không trùng khớp';
    }

    return $error;
  }
}
