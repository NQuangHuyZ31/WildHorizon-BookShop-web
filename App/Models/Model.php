<?php

namespace App\Models;

use Core\Database;

class Model
{

  protected $db;

  public function __construct()
  {

    $this->db = Database::getInstance()->getConnection();
  }

}
