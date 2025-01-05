<?php

namespace Core;

interface Middleware
{
  public function handle($request, $next);
}
