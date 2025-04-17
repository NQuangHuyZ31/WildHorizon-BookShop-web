<?php

namespace App\Requests;

class VerifyOtpValidate
{
  public static function validate($data)
  {
    $errors = '';

    // Kiểm tra xem 'code_verify' có tồn tại và là mảng
    foreach ($data['code_verify'] as $key => $value) {
      if ($value == '' || !ctype_digit($value) || strlen($value) != 1) {
        $errors = "Mã OTP không hợp lệ";
      }
    }
    // Kiểm tra độ dài tổng thể OTP (ví dụ: 6 ký tự)
    if (count($data['code_verify']) !== 4) {
      $errors = 'Mã OTP phải có đủ 4 chữ số.';
    }
    return $errors;
  }
}
