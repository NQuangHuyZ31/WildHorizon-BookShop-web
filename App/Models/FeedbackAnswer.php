<?php

namespace App\Models;

use PDO;

class FeedbackAnswer extends Model
{
  protected $table = 'feedback_answers';
  protected $primary_key = 'id';

  public function insert($data)
  {
    $query = "INSERT INTO $this->table(feedback_id,answer,created_at) values(?,?,?)";
    $stmt = $this->db->prepare($query);
    $stmt->bindValue(1, $data['feedback_id'], PDO::PARAM_INT);
    $stmt->bindValue(2, $data['answer'], PDO::PARAM_STR);
    $stmt->bindValue(3, $data['created_at']);
    $stmt->execute();
  }

  public function find($feedbackID)
  {
    $query = "SELECT *FROM $this->table WHERE feedback_id = ?";
    $stmt = $this->db->prepare($query);
    $stmt->bindValue(1, $feedbackID, PDO::PARAM_INT);
    $stmt->execute();

    return $stmt->fetch(PDO::FETCH_ASSOC);
  }
}
