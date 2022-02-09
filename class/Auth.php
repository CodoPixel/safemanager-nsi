<?php

require_once "config.php";

class Auth {
  protected static $pdo;
  const VALID_IMAGE_EXTENSIONS = ["jpg", "jpeg", "png"];

  /**
   * Starts a connection between PHP and the database.
   * @throws PDOException
   * @return PDO
   */
  private static function init_pdo(): PDO {
    if (!self::$pdo) {
      $dns = "mysql:host=localhost;dbname=safemanager;charset=utf8mb4;";
      $username = "root";
      $password = "";

      self::$pdo = new PDO($dsn, $username, $password, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
      ]);
    }

    return self::$pdo;
  }

  public function __construct() {
    $this->init_pdo();
  }
}