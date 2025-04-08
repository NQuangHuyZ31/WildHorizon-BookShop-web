<?php

namespace Helpers;

class CreateSlug
{
  public static function createSlug($slug)
  {

    $slug = strtolower($slug);

    // Loại bỏ dấu tiếng Việt
    $slug = preg_replace('/[áàảãạâấầẩẫậăắằẳẵặ]/u', 'a', $slug);

    $slug = preg_replace('/[éèẻẽẹêếềểễệ]/u', 'e', $slug);

    $slug = preg_replace('/[iíìỉĩị]/u', 'i', $slug);

    $slug = preg_replace('/[óòỏõọôốồổỗộơớờởỡợ]/u', 'o', $slug);

    $slug = preg_replace('/[úùủũụưứừửữự]/u', 'u', $slug);

    $slug = preg_replace('/[ýỳỷỹỵ]/u', 'y', $slug);

    $slug = preg_replace('/[đ]/u', 'd', $slug);

    // Loại bỏ các ký tự không phải chữ cái hoặc số, thay bằng dấu gạch ngang
    $slug = preg_replace('/[^a-z0-9\s-]/', '', $slug);

    // Thay khoảng trắng và dấu gạch ngang liên tiếp bằng một dấu gạch ngang
    $slug = preg_replace('/[\s-]+/', '-', $slug);

    // Loại bỏ dấu gạch ngang ở đầu và cuối chuỗi (nếu có)
    $slug = trim($slug, '-');

    return $slug;
  }
}
