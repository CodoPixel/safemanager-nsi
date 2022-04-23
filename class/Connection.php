<?php

require_once 'Sex.php';

class Connection {
  protected $ID;
  protected $pk;
  protected $clientID;
  protected $title;
  protected $url;
  protected $date;
  protected $password;
  protected $email;
  protected $age;
  protected $sex;
  protected $pseudo;
  protected $firstname;
  protected $lastname;
  protected $more;

  public function getID():int {
    return $this->ID;
  }

  public function getPk() {
    return $this->pk;
  }

  public function getClientID():string {
    return $this->clientID;
  }

  public function getTitle():string {
    return $this->title;
  }

  public function getURL():?string {
    return $this->url;
  }

  public function getDate() {
    return new DateTime('@' . $this->date);
  }

  public function getPassword():string {
    return $this->password;
  }

  public function getEmail():?string {
    return $this->email;
  }

  public function setPassword(string $decryptedPassword):void {
    $this->password = $decryptedPassword;
  }

  public function setEmail(string $decryptedEmail):void {
    $this->email = $decryptedEmail;
  }

  public function getAge():?int {
    return $this->age;
  }

  public function getSex():Sex {
    return new Sex($this->sex);
  }

  public function getPseudo():?string {
    return $this->pseudo;
  }

  public function getFirstname():?string {
    return $this->firstname;
  }

  public function getLastname():?string {
    return $this->lastname;
  }

  public function getMore():?string {
    return $this->more;
  }
}