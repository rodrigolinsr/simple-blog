<?php
namespace App\MyLib;

use App\MyLib\IniHandler;

class BlogSettings {
  public static function getIniFileLocation() : string {
    return realpath(base_path('blog-settings.ini'));
  }

  public static function getSettings() : array {
    return IniHandler::parseFile(self::getIniFileLocation());
  }

  public static function setSettings(array $settings) : bool {
    return IniHandler::writeFile(self::getIniFileLocation(), $settings);
  }
}
