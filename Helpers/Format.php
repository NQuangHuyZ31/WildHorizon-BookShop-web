<?php

namespace Helpers;

class Format
{
  public static function forMatPrice($price)
  {
    return number_format($price, 0, '.', '.');
  }

  public  static function formatNumber($number)
  {
    return number_format($number, 0);
  }
}
