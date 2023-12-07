<?php

declare(strict_types=1);

namespace Tests;

trait LoggerTestTrait
{
    private function getDebugOutput(): string
    {
        ob_start();
        $this->logger->debug("Hello World");
        return ob_get_clean();
    }

    private function getInfoOutput(): string
    {
        ob_start();
        $this->logger->info("Hello World");
        return ob_get_clean();
    }

    private function getWarningOutput(): string
    {
        ob_start();
        $this->logger->warning("Hello World");
        return ob_get_clean();
    }

    private function getCriticalOutput(): string
    {
        ob_start();
        $this->logger->critical("Hello World");
        return ob_get_clean();
    }
}