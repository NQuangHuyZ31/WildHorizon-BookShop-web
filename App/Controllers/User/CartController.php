<?php

namespace App\Controllers\User;

use App\Controllers\Controller;

class CartController extends Controller{

  public function index(){

    include_once VIEW_PATH.'user/cart.php';
  }
}