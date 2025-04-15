<?php

namespace App\Requests;

class UpdateCustomerInfoValidate
{

  public static function validate($data)
  {
    $error = '';

    if (
      empty($data['username']) ||
      empty($data['phone']) ||
      !in_array($data['gender'], ['0', '1']) ||
      empty($data['day']) ||
      empty($data['mounth']) ||
      empty($data['year'])
    ) {
      $error = 'Thông tin không được để trống';
    }

    // Kiểm tra hợp lệ username
    if (!preg_match('/^[a-zA-ZÀ-Ỵà-ỵ\s]+$/u', $data['username'])) {
      $error = 'Họ tên không đúng định dạng';
    }

    // kiểm tra hợp lệ số điện thoại
    else if (!preg_match('/^0[1-9][0-9]{8}$/', $data['phone'])) {
      $error = 'Số điện thoại không hợp lệ';
    }

    // Kiểm tra các tháng có ngày 31
    else if (in_array($data['mounth'], [1, 3, 5, 7, 8, 10, 12])) {
      if ($data['day'] < 1 || $data['day'] > 31) {
        $error = 'Ngày sinh không hợp lệ';
      }
    }
    // Kiểm tra các tháng có ngày 30
    else if (in_array($data['mounth'], [4, 6, 9, 11])) {
      if ($data['day'] < 1 || $data['day'] > 30) {
        $error = 'Ngày sinh không hợp lệ';
      }
    }

    // Kiểm tra tháng 2
    else if ($data['mounth'] == 2) {
      if ($data['day'] < 1 || $data['day'] > 29) {
        $error = 'Ngày sinh không hợp lệ';
      }
    }

    // Kiểm tra tháng
    else if ($data['mounth'] < 1 || $data['mounth'] > 12) {
      $error = 'Tháng sinh không hợp lệ';
    }

    // Kiểm tra năm sinh
    else if ($data['year'] < 1) {
      $error = 'Năm sinh không hợp lệ';
    }

    return $error;
  }
}
