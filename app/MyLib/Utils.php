<?php
namespace App\MyLib;

class Utils {
  /**
   * The following "printTruncated" method was extracted from the web
   * and is available at the following URL:
   * http://stackoverflow.com/questions/1193500/truncate-text-containing-html-ignoring-tags
   *
   * @return string
   */
  public static function printTruncated(int $maxLength, string $html, bool $isUtf8 = true) {
    $returnStr = "";
    $printedLength = 0;
    $position = 0;
    $tags = array();

    // For UTF-8, we need to count multibyte sequences as one character.
    $re = $isUtf8
        ? '{</?([a-z]+)[^>]*>|&#?[a-zA-Z0-9]+;|[\x80-\xFF][\x80-\xBF]*}'
        : '{</?([a-z]+)[^>]*>|&#?[a-zA-Z0-9]+;}';

    while ($printedLength < $maxLength && preg_match($re, $html, $match, PREG_OFFSET_CAPTURE, $position)) {
      list($tag, $tagPosition) = $match[0];

      // Print text leading up to the tag.
      $str = substr($html, $position, $tagPosition - $position);
      if ($printedLength + strlen($str) > $maxLength) {
        $returnStr .= substr($str, 0, $maxLength - $printedLength);
        $printedLength = $maxLength;
        break;
      }

      $returnStr .= $str;
      $printedLength += strlen($str);
      if ($printedLength >= $maxLength) break;

      if ($tag[0] == '&' || ord($tag) >= 0x80) {
        // Pass the entity or UTF-8 multibyte sequence through unchanged.
        $returnStr .= $tag;
        $printedLength++;
      }
      else {
        // Handle the tag.
        $tagName = $match[1][0];
        if ($tag[1] == '/') {
          // This is a closing tag.

          $openingTag = array_pop($tags);
          assert($openingTag == $tagName); // check that tags are properly nested.

          $returnStr .= $tag;
        }
        else if ($tag[strlen($tag) - 2] == '/') {
          // Self-closing tag.
          $returnStr .= $tag;
        }
        else {
          // Opening tag.
          $returnStr .= $tag;
          $tags[] = $tagName;
        }
      }

      // Continue after the tag.
      $position = $tagPosition + strlen($tag);
    }

    // Print any remaining text.
    if ($printedLength < $maxLength && $position < strlen($html)) {
      $returnStr .= substr($html, $position, $maxLength - $printedLength);
    }

    // Close any open tags.
    while (!empty($tags)) {
      $returnStr .= sprintf('</%s>', array_pop($tags));
    }

    return $returnStr;
  }
}
