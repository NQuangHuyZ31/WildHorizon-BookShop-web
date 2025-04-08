<?php

namespace App\Controllers\User\Customer_Account;

use App\Controllers\Controller;
use App\Models\User;
use Core\Session;

class AccountController extends Controller
{
  protected $user;
  public function __construct()
  {
    $this->user = new User();
  }
  public function index()
  {
    $customer = $this->user->find(Session::get('user')['id']);

    require_once VIEW_PATH . 'user/accounts/account.php';
  }
}
