<?php

class Label {
  protected $ID;
  protected $labelID;
  protected $clientID;
  protected $hexColor;
  protected $title;

  public function getID():?string {
    return $this->ID;
  }

  public function getLabelID():?string {
    return $this->labelID;
  }

  public function getClientID():?string {
    return $this->clientID;
  }

  public function getHexColor():string {
    return '#' . $this->hexColor;
  }

  public function getTitle():string {
    return $this->title;
  }
}