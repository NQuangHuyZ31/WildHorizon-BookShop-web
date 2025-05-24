<?php

namespace App\Controllers\User;

use App\Controllers\Controller;

class IntroduceController extends Controller
{
  protected $page = 'Giới thiệu';
  public function index()
  {
    $pageName = $this->page;
    require_once VIEW_PATH . 'user/introduce.php';
  }
}
