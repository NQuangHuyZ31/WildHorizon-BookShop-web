<?php
namespace App\Requests;
class LoginValidate{

  public static function validate($data){

    $errors = [];

    if(empty($data['email'])){
      $errors['email'] = 'Không được để trống';
    }

    if(empty($data['password'])){
      $errors['password'] = 'Không được để trống';
    }

    return $errors;
  }
}