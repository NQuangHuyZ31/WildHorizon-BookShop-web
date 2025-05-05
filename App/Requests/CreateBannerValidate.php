<?php

namespace App\Requests;

class CreateBannerValidate
{
  public static function validate($data, $file)
  {
    $error = [];

    if (empty($data['banner_name'])) {
      $error['banner_name'] = 'Mục tiêu không được trống';
    }

    if (empty($file)) {
      $error['banner_image'] = "Hình ảnh không được để trống";
    }

    if (!in_array(pathinfo($file['name'], PATHINFO_EXTENSION), ['png', 'jpg', 'jpeg', 'webp', 'gif'])) {
      $error['banner_image'] = "Hình ảnh không phù hợp";
    }
    // 
    else if ($file['size'] > 1024 * 1024) {

      $error['banner_image'] = "Hình ảnh";
    }
    // 
    else if (empty($data['status'])) {
      $error['status'] = "Trạng thái không được để trống";
    }

    if (empty($data['banner_position'])) {
      $error['banner_position'] = "Vị trí banner không được để trống";
    }

    return $error;
  }
}
