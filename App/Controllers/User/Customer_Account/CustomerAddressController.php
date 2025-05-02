<?php

namespace App\Controllers\User\Customer_Account;

use App\Models\CustomerAddress;
use App\Requests\AddressValidate;
use Core\CSRF;
use Core\Response;
use Core\Session;
use Exception;

class CustomerAddressController extends CustomerController
{

  protected $page = 'Sổ địa chỉ';
  protected $user;
  protected $customer_address;

  public function __construct()
  {
    parent::__construct();
    $this->customer_address = new CustomerAddress();
  }

  public function index()
  {

    $pageName = $this->page;
    $customer = $this->customer;
    $customer_address = $this->customer_address->getAddress(Session::get('user')['id']);

    require_once VIEW_PATH . 'user/accounts/address/customer-address.php';
  }

  // Thêm địa chỉ
  public function showPageAddNew()
  {
    $pageName = $this->page;
    $customer = $this->customer;
    require_once VIEW_PATH . 'user/accounts/address/customer-address-add-new.php';
  }

  // Xử lí thêm địa chỉ
  public function addNewAddress()
  {

    $this->checkMethod($_POST['csrf_token']);

    CSRF::destroyToken();
    $token = CSRF::generateToken();

    // Validate
    $error = AddressValidate::validate($_POST);
    if (!empty($error)) {
      Response::json([
        'error' => [
          'msg' => $error,
        ],
        'token' => $token
      ], 404);
    }

    try {
      $this->db->beginTransaction();

      $defaultAddress = isset($_POST['default_address']) ? 1 : 0;
      $dataNewAddress = [
        'username' => $_POST['username'],
        'phone' => $_POST['phone'],
        'province' => $_POST['province'],
        'district' => $_POST['district'],
        'ward' => $_POST['ward'],
        'address' => $_POST['address'],
        'default_address' => $defaultAddress,
        'created_at' => date('Y-m-d'),
      ];

      // Cập nhật lại các địa chỉ khác không là mặc định
      if ($defaultAddress == 1) {
        $this->customer_address->updateDefaultAddress(Session::get('user')['id'], 0);
      }

      // Thêm địa chỉ mới 
      $this->customer_address->insertAddress($dataNewAddress, Session::get('user')['id']);
      $this->db->commit();
      Response::json([
        'success' => [
          'msg' => 'Thêm thành công'
        ],
        'token' => $token
      ], 200);
    } catch (Exception $e) {
      $this->db->rollBack();
      Response::json([
        'error' => [
          'msg' => $e->getMessage(),
        ],
        'token' => $_POST['csrf_token']
      ], 500);
    }
  }

  // Xóa địa chỉ
  public function deleteAddress()
  {

    $this->checkMethod($_POST['csrf_token']);

    CSRF::destroyToken();
    $token = CSRF::generateToken();

    try {
      //code...
      $this->customer_address->deleteAddress($_POST['addressID'], Session::get('user')['id']);

      Response::json([
        'success' => [
          'msg' => 'Thành công',
        ],
        'token' => $token
      ], 200);
    } catch (\Throwable $th) {
      //throw $th
      Response::json([
        'error' => [
          'msg' => 'Có lỗi xảy ra. Vui lòng thử lại',
        ],
        'token' => $token
      ], 500);
    }
  }

  // Sửa địa chỉ
  public function showPageEditAddress($id)
  {
    $pageName = $this->page;
    $customer = $this->customer;
    $address = $this->customer_address->getAddressByID($id);

    require_once VIEW_PATH . 'user/accounts/address/customer-address-edit.php';
  }

  // Cập nhật địa chỉ
  public function updateAddress()
  {

    $this->checkMethod($_POST['csrf_token']);

    CSRF::destroyToken();
    $token = CSRF::generateToken();

    // validate
    $error = AddressValidate::validate($_POST);
    if (!empty($error)) {
      Response::json([
        'error' => [
          'msg' => $error,
        ],
        'token' => $token
      ], 404);
    }

    try {
      //code...
      $this->db->beginTransaction();
      // Cập nhật thông tin
      $defaultAddress = isset($_POST['default_address']) ? 1 : 0;

      if ($defaultAddress == 1) {
        $this->customer_address->updateDefaultAddress(Session::get('user')['id'], 0);
      }

      $updateAddressData = [
        'username' => $_POST['username'],
        'phone' => $_POST['phone'],
        'province' => $_POST['province'],
        'district' => $_POST['district'],
        'ward' => $_POST['ward'],
        'address' => $_POST['address'],
        'default_address' => $defaultAddress,
        'addressID' => $_POST['addressID']
      ];

      $this->customer_address->updateAddress(Session::get('user')['id'], $updateAddressData);
      $this->db->commit();

      Response::json([
        'success' => [
          'msg' => 'Cập nhật thành công',
        ],
        'token' => $token
      ], 200);
    } catch (\Throwable $th) {
      //throw $th;
      $this->db->rollBack();
      Response::json([
        'error' => [
          'msg' => $th->getMessage(),
        ],
        'token' => $token
      ], 500);
    }
  }
}
