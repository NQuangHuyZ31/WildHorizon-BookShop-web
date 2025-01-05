<?php

namespace App\Middleware;

use Core\Middleware;

class AuthMiddleware implements Middleware
{
  public function handle($request, $next)
  {
    if (2==1) {
      header('Location:' .BASE_URL.'/dang-ky');
      exit;
    }

    return $next($request);
  }
}
