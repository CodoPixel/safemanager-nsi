<?php

require_once "config.php";
require_once "Client.php";
require_once "Helpers/AuthHelper.php";
require_once "Connection.php";
require_once "Sex.php";
require_once 'ClientException.php';
require_once 'Debug.php';
require_once 'Label.php';
require_once 'DefaultLabel.php';
require_once 'NoteInterface.php';

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
      $dsn = "mysql:host=localhost;dbname=safemanager;charset=utf8mb4;";
      $username = "root";
      $password = "root";
     /*  $dsn = "mysql:host=db5007315961.hosting-data.io;dbname=dbs6027614;charset=utf8mb4";
      $username = "dbu1992276";
      $password = "SafeManagerNSIDB"; */

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
   * @param string $email The given email address
   * @param string $password The password of length [6, 255[
   * @param string $firstname The first name
   * @param string $lastname The last name
   */
  public function register(string $email, string $password, string $firstname, string $lastname) {
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      throw new ClientException("Email fausse");
    }

    $uniqueID = $this->encryptUniqueID();
    $query = self::$pdo->prepare("INSERT INTO client (email, clientID, firstname, lastname, password, registrationDate) VALUES (:email, :clientID, :firstname, :lastname, :password, :date)");
    $query->execute([
      "email" => $email,
      "clientID" => $uniqueID,
      "firstname" => $firstname,
      "lastname" => $lastname,
      "password" => password_hash($password, PASSWORD_BCRYPT),
      "date" => (new DateTime())->getTimestamp()
    ]);

    $_SESSION["clientID"] = $uniqueID;
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
   * Checks whether the data sent by the user is valid to be saved in the database.
   * The password is not mandatory (because they user may not want to change it).
   * However, if it's been given by the javascript algorithm, then we must check its validity.
   */
  public function isValidClientDataForProfilUpdate($data):bool {
    return $data["email"] != null &&
      $data["streamerMode"] != null &&
      $data["darkMode"] != null &&
      $data["firstname"] != null &&
      $data["lastname"] != null &&
      $data["password"] != null ?
        (mb_strlen($data["password"]) >= 6 &&
        mb_strlen($data["password"]) < 255 &&
        !ctype_space($data["password"])) : true &&
      ($data["darkMode"] === "true" || $data["darkMode"] === "false") &&
      ($data["streamerMode"] === "true" || $data["streamerMode"] === "false") &&
      filter_var(trim($data["email"]), FILTER_VALIDATE_EMAIL) &&
      strlen(trim($data["email"])) < 255 &&
      mb_strlen(trim($data["firstname"])) < 255 &&
      mb_strlen(trim($data["lastname"])) < 255 &&
      !empty(trim($data["email"])) &&
      !empty(trim($data["firstname"])) &&
      !empty(trim($data["lastname"]));
  }

  /**
   * Saves new profil for currently logged in user.
   * @throws ClientException
   */
  public function saveProfil($data) {
    $client = $this->getClient();
    if (!$this->isValidClientDataForProfilUpdate($data)) {
      throw new ClientException("Données invalides");
    }
    $newData = [
      "clientID" => $client->getClientID(),
      "email" => trim($data["email"]),
      "firstname" => trim($data["firstname"]),
      "lastname" => trim($data["lastname"]),
      "streamerMode" => $data["streamerMode"] === "true" ? 1 : 0,
      "darkMode" => $data["darkMode"] === "true" ? 1 : 0
    ];
    if ($data["password"] != null) {
      $newData["password"] = password_hash($data["password"], PASSWORD_BCRYPT);
      $query = self::$pdo->prepare("UPDATE client SET email=:email, password=:password, firstname=:firstname, lastname=:lastname, streamerMode=:streamerMode, darkMode=:darkMode WHERE clientID=:clientID");
    } else {
      $query = self::$pdo->prepare("UPDATE client SET email=:email, firstname=:firstname, lastname=:lastname, streamerMode=:streamerMode, darkMode=:darkMode WHERE clientID=:clientID");
    }
    $query->execute($newData);
  }

  /**
   * Deletes the account of the currently logged in user.
   * @throws ClientException
   */
  public function deleteAccount() {
    $client = $this->getClient();
    $data = ["clientID" => $client->getClientID()];
    $clientQuery = self::$pdo->prepare("DELETE FROM client WHERE clientID=:clientID");
    $imagesQuery = self::$pdo->prepare("DELETE FROM images WHERE clientID=:clientID");
    $labelsQuery = self::$pdo->prepare("DELETE FROM labels WHERE clientID=:clientID");
    $notesQuery  = self::$pdo->prepare("DELETE FROM notes  WHERE clientID=:clientID");
    $passwordsQuery = self::$pdo->prepare("DELETE FROM passwords WHERE clientID=:clientID");
    $clientQuery->execute($data);
    $imagesQuery->execute($data);
    $labelsQuery->execute($data);
    $notesQuery->execute($data);
    $passwordsQuery->execute($data);
    AuthHelper::logOut();
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
   * @param ?Client $client The currently logged in user to save performance.
   * @return Connection[]
   * @throws ClientException
   */
  public function getConnectionsOfCurrentClient(?Client $client = null): array {
    $connections = [];
    $client = $client ?? $this->getClient();
    $query = self::$pdo->prepare("SELECT * FROM passwords WHERE clientID=:clientID");
    $query->execute(["clientID" => $client->getClientID()]);
    $connections = $query->fetchAll(PDO::FETCH_CLASS, Connection::class);
    return $connections;
  }

  /**
   * Gets a connection with its ID.
   * @param int $id The ID of the connection within the database.
   * @param ?Client $client To save performance, the currently logged in user.
   * @throws ClientException
   */
  public function getSelectedConnection(int $id, ?Client $client = null): Connection {
    $client = $client ?? $this->getClient();
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
      "age" => strlen($newData["age"]) > 0 ? (int)$newData["age"] : null,
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

  /**
   * Checks whether a label already exists or not.
   * @param string $title
   * @param string $color
   * @return bool
   */
  public function doesLabelAlreadyExist(string $title, string $color):bool {
    $query = self::$pdo->prepare("SELECT * FROM labels WHERE title=:title or hexColor=:color");
    $query->execute([
      "title" => $title,
      "color" => $color,
    ]);
    $label = $query->fetch();
    if ($label === false) {
      return false;
    } else {
      return true;
    }
  }

  /**
   * Adds a new label if it doesn't already exist.
   * @param string $title
   * @param string $color
   * @throws ClientException
   */
  public function addNewLabel(string $title, string $color):string {
    $newID = $this->encryptUniqueID();
    $client = $this->getClient();
    if ($this->doesLabelAlreadyExist($title, $color)) {
      throw new ClientException("Ce label existe déjà.");
    }
    $query = self::$pdo->prepare("INSERT INTO labels (labelID, clientID, hexColor, title) VALUES (:labelid, :clientid, :color, :title)");
    $query->execute([
      "labelid" => $newID,
      "clientid" => $client->getClientID(),
      "color" => $color,
      "title" => $title,
    ]);
    return $newID;
  }

  /**
   * Gets all the labels of the currently logged in user.
   * @param ?Client $client The currently logged in user to save performance.
   * @throws ClientException
   * @return Label[]
   */
  public function getAllLabels(?Client $client = null):array {
    $client = $client ?? $this->getClient();
    $query = self::$pdo->prepare("SELECT * FROM labels WHERE clientID=:clientID");
    $query->execute(["clientID" => $client->getClientID()]);
    $labels = $query->fetchAll(PDO::FETCH_CLASS, Label::class);
    return $labels;
  }

  /**
   * Gets a label.
   * @param string $labelID
   */
  public function getLabel(string $labelID):Label {
    $query = self::$pdo->prepare("SELECT * FROM labels WHERE labelID=:id");
    $query->execute(["id" => $labelID]);
    $query->setFetchMode(PDO::FETCH_CLASS, Label::class);
    $label = $query->fetch();
    if ($label === false) {
      return new DefaultLabel();
    }
    return $label;
  }

  /**
   * Checks whether a note already exist (it checks only the title).
   * @param mixed $data
   * @param int $selectedNoteID The ID of the note we're editing (we want to be able to not change the title on editing)
   * @return bool
   */
  public function doesNoteAlreadyExist($data, ?int $selectedNoteID):bool {
    if ($selectedNoteID === null) {
      $query = self::$pdo->prepare("SELECT * FROM notes WHERE title=:title");
      $query->execute(["title" => $data["title"]]);
    } else {
      $query = self::$pdo->prepare("SELECT * FROM notes WHERE title=:title and not ID=:id");
      $query->execute(["title" => $data["title"], "id" => $selectedNoteID]);
    }
    $note = $query->fetch();
    if ($note === false) {
      return false;
    } else {
      return true;
    }
  }

  /**
   * Gets the number of notes for the currently logged in user.
   * @param ?Client $client The client if it has already been fetched from the database (for better performance).
   * @return int
   */
  public function getNumberOfNotes(?Client $client): int {
    $client = $client ?? $this->getClient();
    $query = self::$pdo->prepare("SELECT COUNT(*) FROM notes WHERE clientID=:clientID");
    $query->execute(["clientID" => $client->getClientID()]);
    $numberOfNotes = (int)$query->fetchColumn();
    return $numberOfNotes;
  }

  /**
   * Gets the number of passwords for the currently logged in user.
   * @param ?Client $client The client if it has already been fetched from the database (for better performance).
   * @return int
   */
  public function getNumberOfPasswords(?Client $client): int {
    $client = $client ?? $this->getClient();
    $query = self::$pdo->prepare("SELECT COUNT(*) FROM passwords WHERE clientID=:clientID");
    $query->execute(["clientID" => $client->getClientID()]);
    $numberOfPasswords = (int)$query->fetchColumn();
    return $numberOfPasswords;
  }

  /**
   * Creates a new note.
   * @param mixed $data
   * @throws ClientException
   */
  public function createNewNote($data) {
    $client = $this->getClient();
    if ($this->doesNoteAlreadyExist($data, null)) {
      throw new ClientException("Cette note existe déjà.");
    }
    $query = self::$pdo->prepare("INSERT INTO notes (clientID, labelID, title, content, date) VALUES (:clientid, :labelid, :title, :content, :date)");
    $query->execute([
      "clientid" => $client->getClientID(),
      "labelid" => $data["labelID"],
      "title" => trim($data["title"]),
      "content" => trim($data["content"]),
      "date" => (new DateTime())->getTimestamp(),
    ]);
  }

  /**
   * Modifies an existing note.
   * @param int $selectedNoteID
   * @param mixed $data
   */
  public function editNote(int $selectedNoteID, $data) {
    $client = $this->getClient();
    if ($this->doesNoteAlreadyExist($data, $selectedNoteID)) {
      throw new ClientException("Cette note existe déjà.");
    }
    $query = self::$pdo->prepare("UPDATE notes SET labelID=:labelID, title=:newtitle, content=:newcontent WHERE clientID=:clientID and ID=:id");
    $query->execute([
      "clientID" => $client->getClientID(),
      "id" => $selectedNoteID,
      "labelID" => $data["labelID"],
      "newtitle" => trim($data["title"]),
      "newcontent" => trim($data["content"]),
    ]);
  }

  /**
   * Gets all the notes of the currently logged in user.
   * @param ?Client $client To save performance.
   * @return Note[]
   * @throws ClientException
   */
  public function getAllNotes(?Client $client = null):array {
    $client = $client ?? $this->getClient();
    $query = self::$pdo->prepare("SELECT * FROM notes WHERE clientID=:clientID");
    $query->execute(["clientID" => $client->getClientID()]);
    $notes = $query->fetchAll(PDO::FETCH_CLASS, Note::class);
    for ($i = 0; $i < count($notes); $i++) {
      $label = $this->getLabel($notes[$i]->getLabelID());
      $notes[$i]->setLabel($label);
    }
    return $notes;
  }

  /**
   * Gets a note.
   * @param int $selectedNoteID
   * @param ?Client $client The currently logged in user to save performance.
   * @return Note
   * @throws ClientException
   */
  public function getNote(int $selectedNoteID, ?Client $client = null):Note {
    $client = $this->getClient();
    $query = self::$pdo->prepare("SELECT * FROM notes WHERE clientID=:clientID and ID=:id");
    $query->execute([
      "clientID" => $client->getClientID(),
      "id" => $selectedNoteID,
    ]);
    $query->setFetchMode(PDO::FETCH_CLASS, Note::class);
    $note = $query->fetch();
    if ($note === false) {
      throw new ClientException("Cette note n'existe pas.");
    } else {
      return $note;
    }
  }

  /**
   * Deletes a note.
   * @param int $selectedNoteID
   */
  public function deleteNote(int $selectedNoteID) {
    $client = $this->getClient();
    $query = self::$pdo->prepare("DELETE FROM notes WHERE clientID=:clientID and ID=:id");
    $query->execute([
      "clientID" => $client->getClientID(),
      "id" => $selectedNoteID
    ]);
  }
}