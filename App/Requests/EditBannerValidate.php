<?php

namespace App\Requests;

class EditBannerValidate
{
  public static function validate($data)
  {
    $error = [];

    if (empty($data['banner_name'])) {
      $error['banner_name'] = 'Mục tiêu không được trống';
    }

    if (empty($data['status'])) {
      $error['status'] = "Trạng thái không được để trống";
    }

    if (empty($data['banner_position'])) {
      $error['banner_position'] = "Vị trí banner không được để trống";
    }

    return $error;
  }
}
