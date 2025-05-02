<?php

namespace App\Models;

use PDO;

class BannerAdvertising extends Model
{
  protected $table = 'banner_advertisings';
  protected $primary_key = 'id';

  public function getAll()
  {
    $query = "SELECT *FROM $this->table WHERE is_deleted = 0 order by status";
    $stmt = $this->db->prepare($query);
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }

  public function getActive()
  {
    $query = "SELECT *FROM $this->table WHERE status = 'Active' and is_deleted = 0";
    $stmt = $this->db->prepare($query);
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }

  // Get limit offset
  public function getLimit($limit, $offset)
  {
    $query = "SELECT * FROM $this->table WHERE is_deleted = 0 LIMIT :limit OFFSET :offset";
    $stmt = $this->db->prepare($query);

    $stmt->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
    $stmt->bindValue(':offset', (int)$offset, PDO::PARAM_INT);

    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }

  public function insert($data)
  {
    $query = "INSERT INTO $this->table(name,image,status,position,created_at) values(?,?,?,?,?)";

    $stmt = $this->db->prepare($query);
    $stmt->bindValue(1, $data['name'], PDO::PARAM_STR);
    $stmt->bindValue(2, $data['image'], PDO::PARAM_STR);
    $stmt->bindValue(3, $data['status'], PDO::PARAM_STR);
    $stmt->bindValue(4, $data['position'], PDO::PARAM_STR);
    $stmt->bindValue(5, $data['created_at'], PDO::PARAM_STR);

    return $stmt->execute();
  }

  public function findByID($id)
  {
    $query = "SELECT *FROM $this->table WHERE id = ? and is_deleted = 0";
    $stmt = $this->db->prepare($query);
    $stmt->bindValue(1, $id, PDO::PARAM_INT);
    $stmt->execute();

    return $stmt->fetch(PDO::FETCH_ASSOC);
  }

  public function update($data, $bannerID)
  {
    $query = "UPDATE $this->table set name = ?, image = ?, status = ?, position = ?, updated_at = ? WHERE id = ? and is_deleted = 0";
    $stmt = $this->db->prepare($query);
    $stmt->bindValue(1, $data['name'], PDO::PARAM_STR);
    $stmt->bindValue(2, $data['image'], PDO::PARAM_STR);
    $stmt->bindValue(3, $data['status'], PDO::PARAM_STR);
    $stmt->bindValue(4, $data['position'], PDO::PARAM_STR);
    $stmt->bindValue(5, $data['updated_at']);
    $stmt->bindValue(6, $bannerID, PDO::PARAM_INT);

    return $stmt->execute();
  }

  public function updateColumn($column, $value, $bannerID)
  {
    $query = "UPDATE $this->table set $column = ?, updated_at = ? WHERE id = ?";
    $date = date('Y-m-d H:i:s');
    $stmt = $this->db->prepare($query);
    $stmt->bindValue(1, $value, PDO::PARAM_STR);
    $stmt->bindValue(2, $date);
    $stmt->bindValue(3, $bannerID, PDO::PARAM_INT);

    return $stmt->execute();
  }
}
