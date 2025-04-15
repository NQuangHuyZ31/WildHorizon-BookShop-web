<?php

namespace Helpers;

class Log
{
  protected static $logFile = 'data.log';

  public static function text($logData)
  {
    self::writeLog($logData);
  }

  public static function array(array $logData)
  {
    self::writeLog(print_r($logData, true));
  }

  public static function json($logData)
  {
    self::writeLog(json_encode($logData, JSON_PRETTY_PRINT));
  }

  protected static function writeLog($logData)
  {
    file_put_contents(self::$logFile, date('Y-m-d H:i:s') . ' - ' . $logData . PHP_EOL, FILE_APPEND);
  }
}
