<?php

namespace Core;

class Format
{
  public static function forMatPrice($price)
  {
    return number_format($price, 0, '.', ',');
  }
}
