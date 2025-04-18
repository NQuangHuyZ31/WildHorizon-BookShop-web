<?php

namespace App\Controllers\User\Customer_Account;

class CustomerSpecialEventController extends CustomerController
{
  protected $user;

  public function index()
  {

    $customer = $this->customer;
    require_once VIEW_PATH . 'user/accounts/customer-specialoffer.php';
  }
}
