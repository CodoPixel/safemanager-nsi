<?php

require_once "config.php";
require_once "Client.php";

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
      $dsn = "mysql:host=localhost;dbname=safemanager;charset=utf8mb4;";
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

  public function loginWithCredentials(string $email, string $password): ?Client {
    $query = self::$pdo->prepare("SELECT * FROM client WHERE email=:email");
    $query->execute(["email" => $email]);
    $query->setFetchMode(PDO::FETCH_CLASS, Client::class);
    /** @var Client|bool */
    $client = $query->fetch();

    if ($client instanceof Client) {
      $hash = $client->getHashedPassword();
      if (password_verify($password, $hash)) {
        $_SESSION['clientID'] = $client->getClientID();
        return $client;
      } else {
        throw new Exception("Addresse email ou mot de passe incorrects.");
      }
    } else {
      throw new Exception("Cet utilisateur n'existe pas.");
    }
  }
}