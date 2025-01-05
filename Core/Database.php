<?php

namespace Core;

class Database
{
  private static $instance = null;

  private $connection;

  private function __construct()
  {
    $this->connection = new \mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

    if ($this->connection->connect_error) {
      die("Kết nối thất bại: " . $this->connection->connect_error);
    }
  }

  public static function getInstance()
  {
    if (self::$instance === null) {
      self::$instance = new self();
    }
    return self::$instance;
  }

  public function getConnection()
  {
    return $this->connection;
  }
}
