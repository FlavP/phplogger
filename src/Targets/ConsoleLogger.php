<?php

declare(strict_types=1);

namespace PFlav\PHPLogger\Targets;

class ConsoleLogger extends AbstractLogger
{
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

    protected function write(string $message): void
    {
        echo "Console Message " . $message . "\n";
    }
}