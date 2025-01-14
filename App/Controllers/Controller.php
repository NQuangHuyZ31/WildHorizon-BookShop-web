<?php
namespace App\Controllers;
use Core\Database;
use Core\Auth;

class Controller{

  protected $db;
  protected $auth;

  public function __construct(){
    $this->db = Database::getInstance()->getConnection();
    $this->auth = new Auth($this->db);
  }
}