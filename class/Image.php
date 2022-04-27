<?php

class Image {
  protected $ID;
  protected $clientID;
  protected $name;
  protected $date;

  public function getID(): string {
    return $this->ID;
  }

  public function getClientID():string {
    return $this->clientID;
  }

  public function getName():string {
    return $this->name;
  }

  public function getDate():DateTime {
    return new DateTime('@' . $this->date);
  }
}