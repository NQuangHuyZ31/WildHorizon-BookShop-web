<?php

namespace Core;

class Database
{
  private static $instance = null;

  private $connection;
  private $host = DB_HOST;
  private $dbname = DB_NAME;
  private $username = DB_USER;
  private $password = DB_PASS;

  private function __construct()
  {
    try {
      $this->connection = new \PDO("mysql:host={$this->host};dbname={$this->dbname};charset=utf8", $this->username, $this->password);
      $this->connection->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
    } catch (\PDOException $e) {
      die("Kết nối cơ sở dữ liệu thất bại: " . $e->getMessage());
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
