<?php

namespace App\MyLib;

class IniHandler {
  public static function parseFile(string $fileLocation) : array {
    return parse_ini_file($fileLocation, true);
  }

  public static function writeFile(string $fileLocation, array $settings) : bool {
    return self::writeToIniFile($fileLocation, $settings);
  }

  private static function writeToIniFile(string $fileLocation, array $settings) : bool {
    $res = [];
    foreach($settings as $key => $val) {
      if(is_array($val)) {
        $res[] = "[$key]";
        foreach($val as $skey => $sval) {
          $res[] = "$skey = ".(is_numeric($sval) ? $sval : '"'.$sval.'"');
        }
      }
      else {
        $res[] = "$key = ".(is_numeric($val) ? $val : '"'.$val.'"');
      }
    }
    return self::safeFileRewrite($fileLocation, implode(PHP_EOL, $res));
  }

  private static function safeFileRewrite(string $fileLocation, string $settings) : bool {
    $success = false;

    if ($fp = fopen($fileLocation, 'w')) {
      $startTime = microtime(TRUE);
      do {
        $canWrite = flock($fp, LOCK_EX);
        // If lock not obtained sleep for 0 - 100 milliseconds, to avoid collision and CPU load
        if(!$canWrite) {
          usleep(round(rand(0, 100)*1000));
        }
      } while ((!$canWrite) && ((microtime(TRUE)-$startTime) < 5));

      if ($canWrite) {
        fwrite($fp, $settings);
        flock($fp, LOCK_UN);

        $success = true;
      }

      fclose($fp);
    }

    return $success;
  }
}
