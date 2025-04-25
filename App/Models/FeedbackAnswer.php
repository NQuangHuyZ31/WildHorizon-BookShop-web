<?php

namespace App\Models;

use PDO;

class FeedbackAnswer extends Model
{
  protected $table = 'feedback_answers';
  protected $primary_key = 'id';

  public function find($feedbackID)
  {
    $query = "SELECT *FROM $this->table WHERE feedback_id = ?";
    $stmt = $this->db->prepare($query);
    $stmt->bindValue(1, $feedbackID, PDO::PARAM_INT);
    $stmt->execute();

    return $stmt->fetch(PDO::FETCH_ASSOC);
  }
}
