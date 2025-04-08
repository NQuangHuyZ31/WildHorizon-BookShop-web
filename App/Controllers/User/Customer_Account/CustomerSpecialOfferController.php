<?php

namespace App\Controllers\User\Customer_Account;

use App\Models\User;
use Core\Session;

class CustomerSpecialOfferController
{
  protected $user;

  public function __construct()
  {
    $this->user = new User();
  }

  public function index()
  {

    $user_id = Session::get('user')['id'];
    $customer = $this->user->find($user_id);
    require_once VIEW_PATH . 'user/accounts/customer-specialoffer.php';
  }
}
