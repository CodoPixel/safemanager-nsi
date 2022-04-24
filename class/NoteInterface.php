<?php

require_once 'Label.php';

class Note {
  protected $ID;
  protected $clientID;
  protected $labelID;
  protected $title;
  protected $content;
  protected $date;

  // added later 
  protected $label;
  
  public function getID():string {
    return $this->ID;
  }

  public function getClientID():string {
    return $this->clientID;
  }

  public function getLabelID():string {
    return $this->labelID;
  }

  public function setLabel(Label $label):void {
    $this->label = $label;
  }

  public function getLabel():?Label {
    return $this->label;
  }

  public function getTitle():string {
    return $this->title;
  }

  public function getContent():string {
    return $this->content;
  }

  public function getDate():DateTime {
    return new DateTime('@' . $this->date);
  }
}