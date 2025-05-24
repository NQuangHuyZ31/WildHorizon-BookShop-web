<?php

namespace App\Middleware;

use Core\Middleware;
use Core\Session;

class AuthAdminMiddleware implements Middleware
{
  public function handle($request, $next)
  {

    if (Session::has('user') && Session::get('user')['role'] != 'admin') {
      header('location: ' . BASE_URL . '/');
      exit;
    } else {
      if (!Session::has('admin')) {
        header('Location:' . BASE_URL . '/admin/login');
      } else if (Session::get('admin')['role'] != 'admin') {
        Session::delete('user');
        header('location:' . BASE_URL . '/admin/login');
      }
    }
    return $next($request);
  }
}
