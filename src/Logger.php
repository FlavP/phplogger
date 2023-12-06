<?php

declare(strict_types=1);

namespace PFlav\PHPLogger;

class Logger
{
    public function log(string $message): void
    {
        echo $message . "\n";
    }
}