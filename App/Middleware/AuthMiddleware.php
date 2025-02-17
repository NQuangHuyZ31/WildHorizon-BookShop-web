<?php

namespace App\Middleware;

use Core\Middleware;
use Core\Session;

class AuthMiddleware implements Middleware
{
  public function handle($request, $next)
  {

    if(!Session::has('user')){
      header('Location:' . BASE_URL . '/dang-nhap');
    }else if (Session::get('user')['role'] != 'customer') {
      Session::delete('user');
      header('location:'.BASE_URL.'/');
    } 
    return $next($request);
  }
}
