<?php

require_once "config.php";
require_once "Client.php";
require_once "Helpers/AuthHelper.php";
require_once "Connection.php";
require_once "Sex.php";
require_once 'ClientException.php';
require_once 'Debug.php';

AuthHelper::launchSession();

class Auth {
  protected static $pdo;
  const VALID_IMAGE_EXTENSIONS = ["jpg", "jpeg", "png"];
  const ENCRYID_ALPHABET = "abdcefghijklmnopqrstuvwxyz1234567890";
  const ENCRYID_LENGTH = 6;

  /**
   * Starts a connection between PHP and the database.
   * @throws PDOException
   */
  private function init_pdo() {
    if (!self::$pdo) {
      /* $dsn = "mysql:host=localhost;dbname=safemanager;charset=utf8mb4;";
      $username = "root";
      $password = "root"; */
      $dsn = "mysql:host=db5007315961.hosting-data.io;dbname=dbs6027614;charset=utf8mb4";
      $username = "dbu1992276";
      $password = "SafeManagerNSIDB";

      self::$pdo = new PDO($dsn, $username, $password, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
      ]);
    }
  }

  public function __construct() {
    $this->init_pdo();
  }

  /**
   * Creates a new user in the database with the given credentials.
   */
  public function register(string $email, string $password, string $firstname, string $lastname):void {
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      throw new ClientException("Email fausse");
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

  /**
   * Encrypts a unique ID for the newly created user.
   * @return string
   */
  private function encryptUniqueID(): string {
    $unique_id = "";
    for ($i = 0; $i < self::ENCRYID_LENGTH; $i++) {
      $unique_id .= self::ENCRYID_ALPHABET[random_int(0, mb_strlen(self::ENCRYID_ALPHABET) -1)];
    }
    return $unique_id;
  }

  /**
   * Logs in the user with its credentials.
   * @throws ClientException
   * @return ?Client
   */
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
        throw new ClientException("Addresse email ou mot de passe incorrects.");
      }
    } else {
      throw new ClientException("Cet utilisateur n'existe pas.");
    }
  }

  /**
   * Gets the currently logged in user.
   * @throws ClientException
   * @return Client
   */
  public function getClient(): ?Client {
    $query = self::$pdo->prepare("SELECT * FROM client WHERE clientID=:id");
    $query->execute(["id" => $_SESSION['clientID']]);
    $query->setFetchMode(PDO::FETCH_CLASS, Client::class);
    $client = $query->fetch();

    if ($client instanceof Client) {
      return $client;
    } else {
      throw new ClientException("Cet utilisateur n'existe pas.");
    }
  }

  /**
   * Generates a random key for OpenSSL encryption. Each message has a key.
   * @return string
   */
  private function encryptKey(): string
  {
    return openssl_random_pseudo_bytes(4);
  }

  /**
   * Encrypts a message. This avoids hackers from stealing the messages stored in the database.
   * @param  string $message The message to be encrypted.
   * @param  string $key The encryption key.
   * @return string The encrypted message. If an error occurs, then the unencrypted message is returned instead.
   */
  private function encryptText(string $message, string $key): string
  {
    $ivlen = openssl_cipher_iv_length($cipher="AES-128-CBC");
    if ($ivlen === false) return $message;
    $iv = openssl_random_pseudo_bytes($ivlen);
    $ciphertext_raw = openssl_encrypt($message, $cipher, $key, $options=OPENSSL_RAW_DATA, $iv);
    if ($ciphertext_raw !== false) {
      $hmac = hash_hmac('sha256', $ciphertext_raw, $key, $as_binary=true);
      if ($hmac !== false) {
        $cipherText = base64_encode($iv.$hmac.$ciphertext_raw);
        return $cipherText;
      } else {
        return $message;
      }
    } else {
      return $message;
    }
  }
    
  /**
   * Decrypts a message. The message are decrypted in Ajax, so when the identity of the correct receiver is confirmed.
   * @param  string $encrypted_message The encrypted message.
   * @param  string $key The unique key used for the encryption.
   * @return string The decrypted message.
   */
  public function decryptText(string $encrypted_message, string $key): string
  {
    $c = base64_decode($encrypted_message);
    $ivlen = openssl_cipher_iv_length($cipher="AES-128-CBC");
    $iv = substr($c, 0, $ivlen);
    $hmac = substr($c, $ivlen, $sha2len=32);
    $ciphertext_raw = substr($c, $ivlen+$sha2len);
    $original_plaintext = openssl_decrypt($ciphertext_raw, $cipher, $key, $options=OPENSSL_RAW_DATA, $iv);
    $calcmac = hash_hmac("sha256", $ciphertext_raw, $key, $as_binary=true);
    if (hash_equals($hmac, $calcmac)) {
      return $original_plaintext;
    }
  }

  /**
   * Checks if the data sent by the user is correct in order to create or to modify a connection.
   * @throws ClientException
   */
  public function isValidDataForNewConnection($data) {
    if (strlen($data["title"]) > 255 || strlen($data["url"]) > 255 || strlen($data["password"]) > 255 ||
      strlen($data["email"]) > 255 || strlen($data["age"]) > 255 || strlen($data["pseudo"]) > 255 ||
      strlen($data["firstname"]) > 255 || strlen($data["lastname"]) > 255) {
      throw new ClientException("Données corrompues");
    }
  }

  /**
   * Creates a new connection for the currently logged in user.
   * @throws ClientException
   */
  public function createNewConnection($data): void {
    $this->isValidDataForNewConnection($data);
    $client = $this->getClient();
    $encryptionID = $this->encryptKey();
    $query = self::$pdo->prepare("INSERT INTO passwords (pk, clientID, title, url, date, password, email, age, sex, pseudo, firstname, lastname, more)
      VALUES (:pk, :id, :title, :url, :timestamp, :password, :email, :age, :sex, :pseudo, :firstname, :lastname, :more)");
    $query->execute([
      "pk" => $encryptionID,
      "id" => $client->getClientID(),
      "title" => trim($data["title"]),
      "url" => empty(trim($data["url"])) ? null : trim($data["url"]),
      "timestamp" => (new DateTime())->getTimestamp(),
      "password" => $this->encryptText($data["password"], $encryptionID),
      "email" => $this->encryptText($data["email"], $encryptionID),
      "age" => strlen($data["age"]) > 0 ? (int)$data["age"] : null,
      "sex" => (int)$data["sex"],
      "pseudo" => empty(trim($data["pseudo"])) ? null : trim($data["pseudo"]),
      "firstname" => empty(trim($data["firstname"])) ? null : trim($data["firstname"]),
      "lastname" => empty(trim($data["lastname"])) ? null : trim($data["lastname"]),
      "more" => empty(trim($data["more"])) ? null : trim($data["more"]),
    ]);
  }

  /**
   * Gets all the connections of the currently logged in user.
   * @return Connection[]
   * @throws ClientException
   */
  public function getConnectionsOfCurrentClient(): array {
    $connections = [];
    $client = $this->getClient();
    $query = self::$pdo->prepare("SELECT * FROM passwords WHERE clientID=:clientID");
    $query->execute(["clientID" => $client->getClientID()]);
    $connections = $query->fetchAll(PDO::FETCH_CLASS, Connection::class);
    return $connections;
  }

  /**
   * Gets a connection with its ID.
   * @param int $id The ID of the connection within the database.
   * @throws ClientException
   */
  public function getSelectedConnection(int $id): Connection {
    $client = $this->getClient();
    $query = self::$pdo->prepare("SELECT * FROM passwords WHERE clientID=:clientID and ID=:selectedID");
    $query->execute([
      "clientID" => $client->getClientID(),
      "selectedID" => $id,
    ]);
    $query->setFetchMode(PDO::FETCH_CLASS, Connection::class);
    $connection = $query->fetch();

    if ($connection instanceof Connection) {
      $connection->setPassword($this->decryptText($connection->getPassword(), $connection->getPk()));
      if ($connection->getEmail() !== null) $connection->setEmail($this->decryptText($connection->getEmail(), $connection->getPk()));
      return $connection;
    } else {
      throw new ClientException("Cette connexion n'existe pas.");
    }
  }

  /**
   * Modifies an existing connection with the new given data.
   * @param int   $id
   * @param mixed $newData
   * @throws ClientException
   */
  public function modifyConnection(int $id, $newData):void {
    $this->isValidDataForNewConnection($newData);
    $client = $this->getClient();
    $encryptionID = $this->encryptKey();
    $query = self::$pdo->prepare("UPDATE passwords SET pk=:pk, title=:title, url=:url, password=:password, email=:email,
      age=:age, sex=:sex, pseudo=:pseudo, firstname=:firstname, lastname=:lastname, more=:more
      WHERE clientID=:clientID and ID=:id");
    $query->execute([
      "id" => $id,
      "pk" => $encryptionID,
      "clientID" => $client->getClientID(),
      "title" => trim($newData["title"]),
      "url" => empty(trim($newData["url"])) ? null : trim($newData["url"]),
      "password" => $this->encryptText($newData["password"], $encryptionID),
      "email" => strlen(trim($newData["email"])) > 0 ? $this->encryptText(trim($newData["email"]), $encryptionID) : null,
      "age" => (int)$newData["age"],
      "sex" => (int)$newData["sex"],
      "pseudo" => empty(trim($newData["pseudo"])) ? null : trim($newData["pseudo"]),
      "firstname" => empty(trim($newData["firstname"])) ? null : trim($newData["firstname"]),
      "lastname" => empty(trim($newData["lastname"])) ? null : trim($newData["lastname"]),
      "more" => empty(trim($newData["more"])) ? null : trim($newData["more"]),
    ]);
  }

  /**
   * Deletes a connection.
   * @param int $id
   * @throws ClientException
   */
  public function deleteConnection(int $id) {
    $client = $this->getClient();
    $query = self::$pdo->prepare("DELETE FROM passwords WHERE clientID=:clientID and ID=:id");
    $query->execute([
      "clientID" => $client->getClientID(),
      "id" => $id
    ]);
  }
}