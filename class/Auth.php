<?php

require_once "config.php";
require_once "Client.php";

class Auth {
  protected static $pdo;
  const VALID_IMAGE_EXTENSIONS = ["jpg", "jpeg", "png"];
  const ENCRYID_ALPHABET = "abdcefghijklmnopqrstuvwxyz1234567890";
  const ENCRYID_LENGTH = 6;

  /**
   * Starts a connection between PHP and the database.
   * @throws PDOException
   */
  private static function init_pdo() {
    if (!self::$pdo) {
      $dsn = "mysql:host=localhost;dbname=safemanager;charset=utf8mb4;";
      $username = "root";
      $password = "";

      self::$pdo = new PDO($dsn, $username, $password, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
      ]);
    }
  }

  public function register(string $email, string $password, string $firstname, string $lastname) {
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        throw new Exception("Email fausse");
    }

    $query = self::$pdo->prepare("INSERT INTO client (email, clientID, firstname, lastname, password, registrationDate) VALUES (:email, :clientID, :firstname, :lastname, :password, :date)");
    $query->execute([
        "email" => $email,
        "clientID" => "abcdef",
        "firstname" => $firstname,
        "lastname" => $lastname,
        "password" => password_hash($password, PASSWORD_BCRYPT),
        "date" => (new DateTime())->getTimestamp()
    ]);

    $_SESSION["clientID"] = $this->encryptUniqueID();
  }

  public function __construct() {
    $this->init_pdo();
  }

    public static function isConnected(){
      if (isset($_SESSION["clientID"])) {
          return True;
      } else {
          return False;
      }
  }

  private function encryptUniqueID(): string {
      $unique_id = "";
      for ($i = 0; $i < self::ENCRYID_LENGTH; $i++) {
          $unique_id .= self::ENCRYID_ALPHABET[random_int(0, mb_strlen(self::ENCRYID_ALPHABET) -1)];
      }
      return $unique_id;
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