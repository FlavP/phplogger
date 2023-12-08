<?php

declare(strict_types=1);

use PFlav\PHPLogger\Logger;

require_once __DIR__ . '/vendor/autoload.php';

$logger = new Logger();

$logger->addTarget('file', 'critical');

$logger->debug('Debug Message');

$logger->critical('Critical Message');