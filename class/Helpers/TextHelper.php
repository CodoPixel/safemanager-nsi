<?php 

class TextHelper {
  /**
   * Gets the real number of characters in a string.
   * @param  string $text The string to analyze.
   * @return int The number of characters.
   */
  public static function length(string $text): int
  {
  return mb_strlen($text, "utf-8");
  }

  /**
   * Returns an extract of a text.
   * @param string $text The full text.
   * @param int $limit The maximum number of characters of the extract.
   * @return string The extract of the text.
   */
  public static function extractOf(string $text, int $limit): string
  {
    return self::length($text) <= $limit ? $text : mb_substr($text, 0, $limit, "utf-8") . '...';
  }

  public static function extractOfURL(string $url): string {
    return (strpos($url, 'https://') === false ? 'http://' : "https://") . '...';
  }
}