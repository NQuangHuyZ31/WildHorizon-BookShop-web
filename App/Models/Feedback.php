<?php

namespace App\Models;

use PDO;

class Feedback extends Model
{
  protected $table = 'feedbacks';
  protected $primary_key = 'id';

  public function getAll()
  {
    $query = "SELECT f.id, f.type, f.content, f.image, f.status, f.created_at,
     u.username, u.phone  
     FROM $this->table f join users u on f.user_id = u.id ORDER BY f.created_at DESC, f.status ASC";
    $stmt = $this->db->prepare($query);
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }


  public function insert($data)
  {
    $query = "INSERT INTO $this->table(user_id,type,content,image,status,created_at) values(?,?,?,?,?,?)";
    $stmt = $this->db->prepare($query);
    $stmt->bindValue(1, $data['user_id'], PDO::PARAM_INT);
    $stmt->bindValue(2, $data['type'], PDO::PARAM_STR);
    $stmt->bindValue(3, $data['content'], PDO::PARAM_STR);
    $stmt->bindValue(4, $data['image'], PDO::PARAM_STR);
    $stmt->bindValue(5, $data['status'], PDO::PARAM_STR);
    $stmt->bindValue(6, $data['created_at']);

    return $stmt->execute();
  }

  public function findByID($feedbackID)
  {
    $query = "SELECT *FROM $this->table WHERE id = ?";
    $stmt = $this->db->prepare($query);
    $stmt->bindValue(1, $feedbackID, PDO::PARAM_INT);
    $stmt->execute();

    return $stmt->fetch(PDO::FETCH_ASSOC);
  }

  public function find($userID, $status)
  {
    $query = "SELECT *FROM $this->table f JOIN feedback_answers fw on f.id = fw.feedback_id WHERE user_id = ? and status = ?";
    $stmt = $this->db->prepare($query);
    $stmt->bindValue(1, $userID, PDO::PARAM_INT);
    $stmt->bindValue(2, $status, PDO::PARAM_STR);
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }

  public function updateColumn($column, $value, $feedbackID)
  {
    $query = "UPDATE $this->table set $column = ?, updated_at = ? WHERE id = ?";
    $date = date('Y-m-d H:i:s');
    $stmt = $this->db->prepare($query);
    $stmt->bindValue(1, $value);
    $stmt->bindValue(2, $date);
    $stmt->bindValue(3, $feedbackID, PDO::PARAM_INT);
    return $stmt->execute();
  }
}
