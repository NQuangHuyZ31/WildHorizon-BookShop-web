<?php

namespace App\Controllers\User\Customer_Account;

class CustomerVoucherController extends CustomerController
{

  protected $page = 'Voucher của bạn';

  public function index()
  {
    $pageName = $this->page;
    $customer = $this->customer;
    require_once VIEW_PATH . 'user/accounts/customer-voucher.php';
  }
}
