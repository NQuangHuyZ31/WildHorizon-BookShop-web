<?php

namespace App\Models;

use PDO;

class CustomerAddress extends Model
{
  protected $table = 'customer_addresses';
  protected $primary_key = 'id';

  public function getAddress($userID)
  {

    $query = "SELECT c.id, c.province, c.district, c.ward, c.address, c.default_address, c.username, c.phone 
              FROM $this->table c WHERE user_id = ? order by c.default_address desc";
    $stmt = $this->db->prepare($query);
    $stmt->bindValue(1, $userID, PDO::PARAM_INT);
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }

  // Lấy địa chỉ theo id address
  public function getAddressByID($addressID, $userID)
  {

    $query = "SELECT c.id, c.province, c.district, c.ward, c.address, c.default_address, c.username, c.phone 
              FROM $this->table c WHERE id = ? and user_id = ?";
    $stmt = $this->db->prepare($query);
    $stmt->bindValue(1, $addressID, PDO::PARAM_INT);
    $stmt->bindValue(2, $userID, PDO::PARAM_INT);
    $stmt->execute();

    return $stmt->fetch(PDO::FETCH_ASSOC);
  }
  // Thêm địa chỉ
  public function insertAddress($data, $userID)
  {
    $query = "INSERT INTO $this->table(user_id, username, phone, province, district, ward, address, default_address, created_at) values 
        (?,?,?,?,?,?,?,?,?)";
    $stmt = $this->db->prepare($query);
    $stmt->bindValue(1, $userID, PDO::PARAM_INT);
    $stmt->bindValue(2, $data['username'], PDO::PARAM_STR);
    $stmt->bindValue(3, $data['phone'], PDO::PARAM_STR);
    $stmt->bindValue(4, $data['province'], PDO::PARAM_STR);
    $stmt->bindValue(5, $data['district'], PDO::PARAM_STR);
    $stmt->bindValue(6, $data['ward'], PDO::PARAM_STR);
    $stmt->bindValue(7, $data['address'], PDO::PARAM_STR);
    $stmt->bindValue(8, $data['default_address'], PDO::PARAM_INT);
    $stmt->bindValue(9, $data['created_at'], PDO::PARAM_STR);

    return $stmt->execute();
  }

  // Cập nhật lại defaultAddress
  public function updateDefaultAddress($userID, $defaultAddress)
  {
    $query = "UPDATE $this->table SET default_address = ? WHERE user_id = ?";
    $stmt = $this->db->prepare($query);
    $stmt->bindValue(1, $defaultAddress, PDO::PARAM_INT);
    $stmt->bindValue(2, $userID, PDO::PARAM_INT);

    return $stmt->execute();
  }

  // Xóa địa chỉ
  public function deleteAddress($addressID, $userID)
  {
    $query = "DELETE FROM $this->table WHERE id = ? and user_id = ?";
    $stmt = $this->db->prepare($query);
    $stmt->bindValue(1, $addressID, PDO::PARAM_INT);
    $stmt->bindValue(2, $userID, PDO::PARAM_INT);

    return $stmt->execute();
  }

  // Cập nhật thông tin địa chỉ
  public function updateAddress($userID, $data)
  {
    $query = "UPDATE $this->table SET username = ?, phone = ?, province = ?, district = ?, ward = ?, address = ?, default_address = ?
              WHERE user_id = ? and id = ?";
    $stmt = $this->db->prepare($query);
    $stmt->bindValue(1, $data['username'], PDO::PARAM_STR);
    $stmt->bindValue(2, $data['phone'], PDO::PARAM_STR);
    $stmt->bindValue(3, $data['province'], PDO::PARAM_STR);
    $stmt->bindValue(4, $data['district'], PDO::PARAM_STR);
    $stmt->bindValue(5, $data['ward'], PDO::PARAM_STR);
    $stmt->bindValue(6, $data['address'], PDO::PARAM_STR);
    $stmt->bindValue(7, $data['default_address'], PDO::PARAM_INT);
    $stmt->bindValue(8, $userID, PDO::PARAM_INT);
    $stmt->bindValue(9, $data['addressID'], PDO::PARAM_INT);

    return $stmt->execute();
  }
}
