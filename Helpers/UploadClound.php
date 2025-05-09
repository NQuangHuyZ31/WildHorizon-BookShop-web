<?php

namespace Helpers;

use Cloudinary\Cloudinary;
use Cloudinary\Api\Upload\UploadApi;
use Cloudinary\Configuration\Configuration;

require 'vendor/autoload.php';
class UploadClound
{
  public static function upload($file, $folder, $path)
  {

    Configuration::instance([
      'cloud' => [
        'cloud_name' => clound_name,
        'api_key' => clound_api_key,
        'api_secret' => clound_api_serect
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

  public static function getPublicIdFromUrl($url)
  {
    // Tách đường dẫn từ URL
    $parts = explode('/', parse_url($url, PHP_URL_PATH));

    // Tìm vị trí 'upload' trong mảng
    $uploadIndex = array_search('upload', $parts);

    if ($uploadIndex === false || !isset($parts[$uploadIndex + 1])) {
      return null;
    }

    // Lấy phần còn lại sau 'upload'
    $publicIdParts = array_slice($parts, $uploadIndex + 1);

    // Nếu có phiên bản dạng v12345 → loại bỏ
    if (preg_match('/^v\d+$/', $publicIdParts[0])) {
      array_shift($publicIdParts);
    }

    // Ghép lại path đầy đủ
    $fullPath = implode('/', $publicIdParts);

    // Tách tên file và phần mở rộng
    $extension = pathinfo($fullPath, PATHINFO_EXTENSION);
    $filename = pathinfo($fullPath, PATHINFO_FILENAME);

    // Nếu có folder → lấy lại phần folder
    $folder = dirname($fullPath);
    if ($folder === '.' || $folder === '') {
      return $filename;
    } else {
      return $folder . '/' . $filename;
    }
  }


  public static function extractPublicId($url)
  {
    $path = parse_url($url, PHP_URL_PATH); // Lấy phần đường dẫn
    $parts = explode('/', $path);
    $filename = end($parts); // Lấy tên file: zq7l7bhy1o6xruk5qfuu.webp
    return pathinfo($filename, PATHINFO_FILENAME); // Trả về tên không có đuôi
  }

  public static function delete($publicId)
  {
    // Cấu hình Cloudinary
    $config = Configuration::instance([
      'cloud' => [
        'cloud_name' => clound_name,
        'api_key' => clound_api_key,
        'api_secret' => clound_api_serect
      ],
      'url' => [
        'secure' => true
      ]
    ]);

    // Truyền cấu hình khi tạo Cloudinary
    $cloudinary = new Cloudinary($config);

    // Gọi hàm destroy
    $result = $cloudinary->uploadApi()->destroy($publicId);

    return $result;
  }
}
