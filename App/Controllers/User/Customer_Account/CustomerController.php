<?php

namespace App\Controllers\User\Customer_Account;

use App\Controllers\Controller;
use App\Models\User;
use Core\Session;

class CustomerController extends Controller
{
  protected $user;
  protected $customer;
  public function __construct()
  {

    parent::__construct();
    $this->user = new User();
    $this->customer = $this->user->find(Session::get('user')['id']);
  }
}
