<?php

declare(strict_types=1);

namespace PFlav\PHPLogger;

class Logger
{
    const LOG_LEVEL_INFO = 'Info';
    const LOG_LEVEL_DEBUG = 'Debug';
    const LOG_LEVEL_WARNING = 'Warning';
    const LOG_LEVEL_CRITICAL = 'Critical';
    private string $logLevel = self::LOG_LEVEL_DEBUG;
    private array $logLevels = [
        self::LOG_LEVEL_DEBUG => 1,
        self::LOG_LEVEL_INFO => 2,
        self::LOG_LEVEL_WARNING => 3,
        self::LOG_LEVEL_CRITICAL => 4
    ];
    private function log(string $message, string $logLevel): void
    {
        if ($this->logLevels[$logLevel] < $this->logLevels[$this->getLogLevel()]) {
            return;
        }
        echo $message . "\n";
    }

    public function debug(string $message): void
    {
        $this->log('Debug: ' . $message, self::LOG_LEVEL_DEBUG);
    }

    public function info(string $message): void
    {
        $this->log('Info: ' . $message, self::LOG_LEVEL_INFO);
    }

    public function warning(string $message): void
    {
        $this->log('Warning: ' . $message, self::LOG_LEVEL_WARNING);
    }

    public function critical(string $message): void
    {
        $this->log('Critical: ' . $message, self::LOG_LEVEL_CRITICAL);
    }
    
    public function setLogLevel(string $logLevel): void
    {
        $this->logLevel = $logLevel;
    }

    public function getLogLevel(): string
    {
        return $this->logLevel;
    }
}