<?php

namespace App\Controllers\User;

use App\Controllers\Controller;
use App\Models\User;
use App\Models\UserVoucher;
use App\Models\Voucher;
use Core\CSRF;
use Core\Response;
use Core\Session;

class VoucherController extends Controller
{
  protected $page = 'Voucher';
  protected $voucher;
  protected $customer_voucher;
  protected $user;

  public function __construct()
  {
    parent::__construct();
    $this->voucher = new Voucher();
    $this->customer_voucher = new UserVoucher();
    $this->user = new User();
  }

  public function index()
  {
    $pageName = $this->page;
    $customer = Session::has('user') ? $this->user->find(Session::get('user')['id']) : '';
    $arrayVoucher = [];
    $vouchers = $this->voucher->getAll();
    foreach ($vouchers as $voucher) {
      $voucherID = $voucher['id'];

      $voucherItem = $this->voucher->findByID($voucherID);
      if (!isset($arrayVoucher[$voucherID])) {
        $arrayVoucher[$voucherID] = [
          'voucher' => $voucherItem,
          'customer_voucher' => []
        ];

        $customer_voucher = [];
        if (!empty($customer)) {
          $customer_voucher = $this->customer_voucher->findByVoucherID($voucherID, $customer['id']);
        }

        $arrayVoucher[$voucherID]['customer_voucher'] = $customer_voucher;
      }
    }

    require_once VIEW_PATH . 'user/promotions/voucher.php';
  }

  public function saveVoucher()
  {

    // Kiểm tra
    $csrfToken = $_SERVER['HTTP_X_CSRF_TOKEN'] ?? null;
    if (isset($csrfToken)) {
      $csrfToken = $csrfToken;
      $this->checkMethod($csrfToken);
    } else {
      // Token không tồn tại, xử lý lỗi tại đây
      Response::json([
        'error' => [
          'msg' => 'Có lỗi xảy ra. Vui lòng thử lại'
        ],
        'token' => $csrfToken,
      ], 400);
    }

    CSRF::destroyToken();
    $token = CSRF::generateToken();
    // Tìm voucher
    $voucher = $this->voucher->findByID($_POST['voucherID']);
    $customer_voucher = $this->customer_voucher->findByVoucherID($_POST['voucherID'], Session::get('user')['id']);

    // nếu không có voucher
    if (!$voucher) {
      Response::json([
        'error' => [
          'msg' => 'Voucher này không tồn tại'
        ],
        'token' => $token
      ], 400);
    }

    // Check voucher đã lưu chưa
    if ($customer_voucher) {
      Response::json([
        'error' => [
          'msg' => 'Voucher này đã được lưu'
        ],
        'token' => $token
      ], 400);
    }

    // Check xem voucher còn không
    if ($voucher['quantity'] <= 0) {
      Response::json([
        'error' => [
          'msg' => 'Voucher này đã hết lượt sử dụng'
        ],
        'token' => $token
      ], 400);
    }

    // Lưu voucher
    $data = [
      'user_id' => Session::get('user')['id'],
      'voucher_id' => $_POST['voucherID'],
      'created_at' => date('Y-m-d H:i:s')
    ];

    if ($this->customer_voucher->insert($data)) {
      Response::json([
        'success' => [
          'msg' => 'Lưu voucher thành công',
          'title' => 'Đã lưu'
        ],
        'token' => $token
      ], 200);
    }

    // 
    Response::json([
      'success' => [
        'msg' => 'Có lỗi xảy ra',
      ],
      'token' => $token
    ], 400);
  }
}
