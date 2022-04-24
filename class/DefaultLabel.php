<?php

require_once 'Label.php';

class DefaultLabel extends Label {
  public function __construct() {
    $this->ID = null;
    $this->labelID = null;
    $this->clientID = null;
    $this->hexColor = "000000";
    $this->title = "Neutre";
  }
}