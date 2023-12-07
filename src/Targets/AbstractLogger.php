<?php

declare(strict_types=1);

namespace PFlav\PHPLogger\Targets;

abstract class AbstractLogger
{
    public const LOG_LEVEL_DEBUG = 'debug';
    public const LOG_LEVEL_INFO = 'info';
    public const LOG_LEVEL_WARNING = 'warning';
    public const LOG_LEVEL_CRITICAL = 'critical';
    public string $logLevel = self::LOG_LEVEL_DEBUG;
    public array $logLevels = [
        self::LOG_LEVEL_DEBUG => 1,
        self::LOG_LEVEL_INFO => 2,
        self::LOG_LEVEL_WARNING => 3,
        self::LOG_LEVEL_CRITICAL => 4
    ];

    abstract public function debug(string $message): void;

    abstract public function info(string $message): void;

    abstract public function warning(string $message): void;

    abstract public function critical(string $message): void;

    protected function log(string $message, string $logLevel): void
    {
        if ($this->logLevels[$logLevel] < $this->logLevels[$this->getLogLevel()]) {
            return;
        }

        $this->write($message);
    }

    public function getLogLevel(): string
    {
        return $this->logLevel;
    }

    public function setLogLevel(string $logLevel = null): void
    {
        if (!isset($this->logLevels[$logLevel])) {
            return;
        }

        $this->logLevel = $logLevel;
    }

    abstract protected function write(string $message): void;
}