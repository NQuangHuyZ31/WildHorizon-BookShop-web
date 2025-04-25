<?php

namespace Helpers;

use Cloudinary\Api\Upload\UploadApi;
use Cloudinary\Configuration\Configuration;

require 'vendor/autoload.php';
class UploadClound
{
  public static function upload($file, $folder, $path)
  {

    Configuration::instance([
      'cloud' => [
        'cloud_name' => 'whr-clound',
        'api_key' => '346669594552425',
        'api_secret' => 'EYnarkbzTDp7gdmzJPXRBp_dbBg'
      ],
      'url' => [
        'secure' => true
      ]
    ]);

    $data = (new UploadApi())->upload($file, [
      'public_id' =>  $path,
      'folder' => 'whr_images/' . $folder . ''
    ]);

    return $data['secure_url'];
  }
}
