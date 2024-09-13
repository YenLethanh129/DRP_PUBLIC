<?
namespace App\Core;
class Logger{
  public static function logError($logFile, $message){
    if (!file_exists($logFile)) {
      $file = fopen($logFile, 'w');
      if ($file === false) {
        die('Unable to create log file.');
      }
      fclose($file);
    }
    $dateTime = date('d-m-Y H:i:s');
    $logMessage = $dateTime . ': ' . $message . PHP_EOL;
    error_log($logMessage, 3, $logFile);
  }
  public static function logDebug($message) {
    if (!file_exists(DEBUG_LOG)) {
      $file = fopen(DEBUG_LOG, 'w');
      if ($file === false) {
        die('Unable to create log file.');
      }
      fclose($file);
    }
    $dateTime = date('d-m-Y H:i:s');
    $logMessage = "[DEBUG] [$dateTime] $message\n";
    file_put_contents(DEBUG_LOG, $logMessage, FILE_APPEND);
  }
}
?>