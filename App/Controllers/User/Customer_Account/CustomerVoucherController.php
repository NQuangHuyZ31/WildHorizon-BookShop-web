<?php

namespace App\Controllers\User\Customer_Account;

class CustomerVoucherController extends CustomerController
{
  public function index()
  {
    $customer = $this->customer;
    require_once VIEW_PATH . 'user/accounts/customer-voucher.php';
  }
}
