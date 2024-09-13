<?php

use App\Core\Logger;

if (!isset($_SESSION)) {
  session_start();
}
require_once($_SERVER['DOCUMENT_ROOT'] . "/vendor/autoload.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/Config/general_config.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/Config/env.php");

set_error_handler('handleError');
set_exception_handler('handleException');
function handleError(int $errno, string $errstr, string $errfile, int $errline)
{
  $errorType = getErrorType($errno);
  $backtrace = debug_backtrace();
  $backtrace = array_slice($backtrace, 2); // remove handleError from the call stack

  // Start building the backtrace string
  $backtraceStr = '';
  foreach ($backtrace as $i => $call) {
    $file = $call['file'] ?? 'UNKNOWN';
    $line = $call['line'] ?? 'UNKNOWN';
    $function = $call['function'] ?? 'UNKNOWN';
    $class = $call['class'] ?? 'UNKNOWN';
    $type = $call['type'] ?? 'UNKNOWN';
    $backtraceStr .= "#$i $file($line): $class$type$function()\n";
  }
  $backtraceStr .= "{main}";

  Logger::logError(ERROR_LOG, "$errorType: [$errno] $errstr - $errfile:$errline\nCall Stack:\n$backtraceStr");

  // Don't halt the script execution
  return true;
}
function handleException($exception)
{
  $backtrace = $exception->getTraceAsString(); // get the call stack as a string
  Logger::logError(EXCEPTION_LOG, "Uncaught Exception: " . $exception->getMessage() . "\nCall Stack:\n$backtrace");

  // Don't halt the script execution
  return true;
}
function handlePDOException($exception)
{
  $backtrace = $exception->getTraceAsString(); // get the call stack as a string
  Logger::logError(DB_RELATED_LOG, "Uncaught Exception: " . $exception->getMessage() . "\nCall Stack:\n$backtrace");

  // Don't halt the script execution
  return true;
}
function getErrorType($errno)
{
  $errorTypes = array(
    E_ERROR             => 'E_ERROR',
    E_WARNING           => 'E_WARNING',
    E_PARSE             => 'E_PARSE',
    E_NOTICE            => 'E_NOTICE',
    E_CORE_ERROR        => 'E_CORE_ERROR',
    E_CORE_WARNING      => 'E_CORE_WARNING',
    E_COMPILE_ERROR     => 'E_COMPILE_ERROR',
    E_COMPILE_WARNING   => 'E_COMPILE_WARNING',
    E_USER_ERROR        => 'E_USER_ERROR',
    E_USER_WARNING      => 'E_USER_WARNING',
    E_USER_NOTICE       => 'E_USER_NOTICE',
    E_STRICT            => 'E_STRICT',
    E_RECOVERABLE_ERROR => 'E_RECOVERABLE_ERROR',
    E_DEPRECATED        => 'E_DEPRECATED',
    E_USER_DEPRECATED   => 'E_USER_DEPRECATED'
  );
  return $errorTypes[$errno] ?? 'UNKNOWN';
}
