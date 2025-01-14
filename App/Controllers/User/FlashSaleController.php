<?php

namespace App\Controllers\User;

use App\Controllers\Controller;

class FlashSaleController extends Controller
{

  public function index()
  {

    // $keyword = isset($_GET['search']) ? trim($_GET['search']) : '';

    // // Kiểm tra nếu có từ khóa tìm kiếm
    // if ($keyword !== '') {
    //   // Lấy dữ liệu theo keyword
    //   $product = 'aaaaaa';
    // } else {
    //   // Lấy toàn bộ dữ liệu
    //   $product = 'bbbbbb';
    // }

    // Trả về view cùng dữ liệu
    include_once VIEW_PATH . 'user/flash-sale.php';
  }
}
