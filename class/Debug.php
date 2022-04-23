<?php

class Debug
{
  public static function dump($var, bool $exit = false): void
  {
    echo "<pre>";
    var_dump($var);
    echo "</pre>";
    if ($exit) {
      die();
    }
  }
}