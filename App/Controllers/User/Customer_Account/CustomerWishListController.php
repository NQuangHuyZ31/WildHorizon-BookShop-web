<?php

namespace App\Controllers\User\Customer_Account;

class CustomerWishListController extends CustomerController
{
  protected $page = 'Yêu thích';

  public function index()
  {
    $pageName = $this->page;
    $customer = $this->customer;
    require_once VIEW_PATH . 'user/accounts/customer-wishlist.php';
  }
}
