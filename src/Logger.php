<?php

declare(strict_types=1);

namespace PFlav\PHPLogger;

use InvalidArgumentException;
use PFlav\PHPLogger\Targets\AbstractLogger;
use Throwable;

class Logger
{
    private array $targets = [];
    public function __construct()
    {
        $this->addTarget('console');
    }

    public function addTarget(string $target, string $logLevel = AbstractLogger::LOG_LEVEL_DEBUG): void
    {
        $logger = $this->createTarget($target);
        $index = array_search($logger, $this->targets);
        if ($index !== false) {
            $this->targets[$index]->setLogLevel($logLevel);
        } else {
            $logger->setLogLevel($logLevel);
            $this->targets[] = $logger;
        }
    }

    protected function createTarget(string $target): Targets\AbstractLogger
    {
        $className = 'PFlav\\PHPLogger\\Targets\\' . ucfirst($target) . 'Logger';
        try {
            return new $className();
        } catch (Throwable $e) {
            throw new InvalidArgumentException('Invalid target: ' . $target);
        }
    }

    public function setLogLevel(string $logLevel = null): void
    {
        foreach ($this->getTargets() as $target) {
            /** @var Targets\AbstractLogger $target */
            $target->setLogLevel($logLevel);
        }
    }

    public function getTargets(): array
    {
        return $this->targets;
    }

    public function debug(string $message): void
    {
        foreach ($this->getTargets() as $target) {
            /** @var Targets\AbstractLogger $target */
            $target->debug($message);
        }
    }

    public function info(string $message): void
    {
        foreach ($this->getTargets() as $target) {
            /** @var Targets\AbstractLogger $target */
            $target->info($message);
        }
    }

    public function warning(string $message): void
    {
        foreach ($this->getTargets() as $target) {
            /** @var Targets\AbstractLogger $target */
            $target->warning($message);
        }
    }

    public function critical(string $message): void
    {
        foreach ($this->getTargets() as $target) {
            /** @var Targets\AbstractLogger $target */
            $target->critical($message);
        }
    }
}