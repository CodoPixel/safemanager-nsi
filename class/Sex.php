<?php

class Sex {
  protected $number;
  const SEXES = [
    0 => "Non défini",
    1 => "Homme",
    2 => "Femme"
  ];

  public function __construct(int $number) {
    $this->number = $number;
  }

  public function getNumber():int {
    return $this->number;
  }

  public function getString():string {
    return self::SEXES[$this->number];
  }
}