<?php

declare(strict_types=1);

require_once __DIR__ . '/vendor/autoload.php';

$logger = new \PFlav\PHPLogger\Logger();

$logger->debug('Hello World');