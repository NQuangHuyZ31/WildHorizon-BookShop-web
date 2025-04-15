<?php

namespace App\Controllers\User\Customer_Account;

use App\Models\CustomerAddress;
use App\Requests\AddressValidate;
use Core\CSRF;
use Core\Session;
use Exception;

class CustomerAddressController extends CustomerController
{
  protected $user;
  protected $customer_address;

  public function __construct()
  {
    parent::__construct();
    $this->customer_address = new CustomerAddress();
  }

  public function index()
  {

    $customer = $this->customer;
    $customer_address = $this->customer_address->getAddress(Session::get('user')['id']);

    require_once VIEW_PATH . 'user/accounts/address/customer-address.php';
  }

  // Thêm địa chỉ
  public function showPageAddNew()
  {

    $customer = $this->customer;
    require_once VIEW_PATH . 'user/accounts/address/customer-address-add-new.php';
  }

  // Xử lí thêm địa chỉ
  public function addNewAddress()
  {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      if (CSRF::verifyToken($_POST['csrf_token'])) {
        CSRF::destroyToken();
        $token = CSRF::generateToken();
        try {
          $this->db->beginTransaction();

          $error = AddressValidate::validate($_POST);
          if (!empty($error)) {
            http_response_code(400);
            echo json_encode([
              'msg' => $error,
              'token' => $token
            ]);
            exit();
          }

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
          http_response_code(200);
          echo json_encode([
            'success' => [
              'status' => 1,
              'msg' => 'Thêm thành công'
            ],
            'token' => $token
          ]);
        } catch (Exception $e) {
          $this->db->rollBack();
          http_response_code(400);
          echo json_encode(['msg' => $e->getMessage(), 'token' => $_POST['csrf_token']]);
          exit();
        }
      } else {
        http_response_code(400);
        echo json_encode(['msg' => 'Lỗi xác thực csrf_token', 'token' => $_POST['csrf_token']]);
        exit();
      }
    } else {
      http_response_code(400);
      echo json_encode(['msg' => 'Phương thức không hợp lệ', 'token' => $_POST['csrf_token']]);
      exit();
    }
  }

  // Xóa địa chỉ
  public function deleteAddress()
  {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      if (CSRF::verifyToken($_POST['csrf_token'])) {
        CSRF::destroyToken();
        $token = CSRF::generateToken();
        try {
          //code...
          $this->customer_address->deleteAddress($_POST['addressID'], Session::get('user')['id']);
          http_response_code(200);
          echo json_encode(['msg' => 'Thành công', 'token' => $token]);
        } catch (\Throwable $th) {
          //throw $th;
          $this->db->rollBack();
          http_response_code(400);
          echo json_encode(['msg' => $th->getMessage(), 'token' => $token]);
        }
      } else {
        http_response_code(405);
        echo json_encode(['msg' => 'Lỗi csrf', 'token' => $_POST['csrf_token']]);
      }
    } else {
      http_response_code(405);
      echo json_encode(['msg' => 'Phương thức không hỗ trợ', 'token' => $_POST['csrf_token']]);
      exit;
    }
  }

  // Sửa địa chỉ
  public function showPageEditAddress($id)
  {
    $customer = $this->customer;
    $address = $this->customer_address->getAddressByID($id);

    require_once VIEW_PATH . 'user/accounts/address/customer-address-edit.php';
  }

  // Cập nhật địa chỉ
  public function updateAddress()
  {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      if (CSRF::verifyToken($_POST['csrf_token'])) {
        CSRF::destroyToken();
        $token = CSRF::generateToken();

        $error = AddressValidate::validate($_POST);
        if ($error) {
          http_response_code(400);
          echo json_encode(['msg' => $error, 'token' => $token]);
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
          http_response_code(200);
          echo json_encode(['status' => http_response_code(200), 'msg' => 'Cập nhật thành công', 'token' => $token]);
        } catch (\Throwable $th) {
          //throw $th;
          $this->db->rollBack();
          echo json_encode(['msg' => $th->getMessage(), 'token' => $token]);
        }
      } else {
        http_response_code(405);
        echo json_encode(['msg' => 'Lỗi xác thực csrf', 'token' => $_POST['csrf_token']]);
      }
    } else {
      http_response_code(405);
      echo json_encode(['msg' => 'Phương thức không hỗ trợ', 'token' => $_POST['csrf_token']]);
    }
  }
}
