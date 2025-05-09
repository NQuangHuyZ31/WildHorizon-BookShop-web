<?php

namespace App\Controllers\User\Customer_Account;

use App\Models\UserVoucher;

class CustomerVoucherController extends CustomerController
{

  protected $page = 'Voucher của bạn';
  protected $customer_voucher;

  public function __construct()
  {
    parent::__construct();
    $this->customer_voucher = new UserVoucher();
  }

  public function index()
  {
    $pageName = $this->page;
    $customer = $this->customer;
    $customer_voucher = $this->customer_voucher->getAllByUser($customer['id']);
    require_once VIEW_PATH . 'user/accounts/customer-voucher.php';
  }
}
