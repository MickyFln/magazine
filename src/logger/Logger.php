<?php

namespace logger;

class Logger
{
  const LOG_LEVEL_DEBUG = 1;
  const LOG_LEVEL_INFO = 2;
  const LOG_LEVEL_WARN = 3;
  const LOG_LEVEL_ERROR = 4;

  const LOG_DIRECTORY = '/logs/';
  protected $logFile;
  protected int $logLevel;

  function __construct(int $level)
  {
    $this->logLevel = $level;

    $currLogFile = dirname(__FILE__, 3) . self::LOG_DIRECTORY . date('Ymd') . '.log';

    if (file_exists($currLogFile)) {
      $this->logFile = fopen($currLogFile, 'a');
    } else {
      $this->logFile = fopen($currLogFile, 'w');
    }
  }

  function debug(string $message, $data = null)
  {
    $debugMessage = 'DEBUG: ' . $message . '\n';
    $this->log($debugMessage, $data, self::LOG_LEVEL_DEBUG);
  }
  function info(string $message, $data = null)
  {
    $debugMessage = 'INFO:  ' . $message . '\n';
    $this->log($debugMessage, $data, self::LOG_LEVEL_DEBUG);
  }
  function warn(string $message, $data = null)
  {
    $debugMessage = 'WARN:  ' . $message . '\n';
    $this->log($debugMessage, $data, self::LOG_LEVEL_DEBUG);
  }
  function error(string $message, $data = null)
  {
    $debugMessage = 'ERROR: ' . $message . '\n';
    $this->log($debugMessage, $data, self::LOG_LEVEL_DEBUG);
  }

  private function log($message, $data, $level)
  {
    if ($level < $this->logLevel) {
      return;
    }

    fwrite($this->logFile, $message);
    if (!is_null($data)) {
      ob_start();
      var_dump($data);

      $message = ob_get_clean();
      fwrite($this->logFile, $message);
    }
  }

  function closeLogFile()
  {
    fclose($this->logFile);
  }
}
