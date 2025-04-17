<?php

namespace App\Controllers;

use Helpers\Hash;

class TestController
{
  public function index()
  {
    $otp = Hash::encrypt('1234', 'iuh');
    $opt_decrype = Hash::encrypt('1234', 'iuh');
    $otpa = Hash::decrypt($otp, 'iuh');
    $otpb = Hash::decrypt($opt_decrype, 'iuh');
    echo $otpa . '\n' . $otpb;
  }
}
