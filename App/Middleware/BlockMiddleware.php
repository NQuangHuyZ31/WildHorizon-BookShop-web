<?php

namespace App\Middleware;

use Core\Middleware;
use Core\Session;

class BlockMiddleware implements Middleware
{
  public function handle($request, $next)
  {
    if (Session::has('user')) {
      if (Session::get('user')['role'] == 'customer') {
        header('location: ' . Session::get('current_url') . '');
      } else {
        Session::destroy();
      }
    }
    return $next($request);
  }
}
