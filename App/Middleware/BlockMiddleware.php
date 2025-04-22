<?php

namespace App\Middleware;

use Core\Middleware;
use Core\Session;

class BlockMiddleware implements Middleware
{
  public function handle($request, $next)
  {
    header('location:' . Session::get('current_url') . '');
  }
}
