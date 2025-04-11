<?php

namespace App\Requests;

class AddressValidate
{
  public static function validate($data)
  {
    $error = '';

    if (empty($data['username']) || empty($data['phone']) || empty($data['province']) || empty($data['district']) || empty($data['ward']) || empty($data['address'])) {
      $error = 'Thông tin không được trống';
    }

    // Kiểm tra hợp lệ username
    else if (!preg_match('/^[a-zA-ZÀ-Ỵà-ỵ\s]+$/u', $data['username'])) {
      $error = 'Tên người dùng không đúng định dạng';
    }

    // kiểm tra hợp lệ số điện thoại
    else if (!preg_match('/^0[1-9][0-9]{8}$/', $data['phone'])) {
      $error = 'Số điện thoại không hợp lệ';
    }

    // Kiểm tra hợp lệ địa chỉ
    // else if (!preg_match('/^[a-zA-Z0-9\s,]*[^!@#$%^&*()_+-=]$/', $data['address'])) {
    //   $error = 'Địa chỉ không nên có kí tự đặc biệt';
    // }
    return $error;
  }
}
