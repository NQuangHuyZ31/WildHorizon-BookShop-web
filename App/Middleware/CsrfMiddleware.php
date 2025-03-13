<?php

namespace App\Middleware;

use Core\CSRF;
use Core\Session;

class CsrfMiddleware
{
  public function verify($request, $next)
  {
    if (isset($_POST['csrf_token'])) {
      if (CSRF::verifyToken($_POST['csrf_token'])) {
        return $next($request);
      } else {
        header('location: ' . Session::get('current_url') . '');
      }
    }
  }
}
