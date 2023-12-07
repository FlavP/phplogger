<?php

declare(strict_types=1);

namespace PFlav\PHPLogger;

use PFlav\PHPLogger\Targets\AbstractLogger;

class Logger
{
    private array $targets = [];


    public function __construct()
    {
        $this->addTarget('console');
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

    public function setLogLevel(string $logLevel = null): void
    {
        foreach ($this->getTargets() as $target) {
            /** @var Targets\AbstractLogger $target */
            $target->setLogLevel($logLevel);
        }
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

    public function getTargets(): array
    {
        return $this->targets;
    }

    protected function createTarget(string $target): Targets\AbstractLogger
    {
        $className = 'PFlav\\PHPLogger\\Targets\\' . ucfirst($target) . 'Logger';
        return new $className();
    }
}