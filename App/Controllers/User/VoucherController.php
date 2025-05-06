<?php

namespace App\Controllers\User;

use App\Controllers\Controller;
use App\Models\Voucher;

class VoucherController extends Controller
{
  protected $page = 'Voucher';
  protected $voucher;

  public function __construct()
  {
    parent::__construct();
    $this->voucher = new Voucher();
  }

  public function index()
  {
    $pageName = $this->page;
    $vouchers = $this->voucher->getAll();

    require_once VIEW_PATH . 'user/promotions/voucher.php';
  }
}
