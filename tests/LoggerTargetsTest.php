<?php

declare(strict_types=1);

namespace Tests;

use PFlav\PHPLogger\Logger;
use PHPUnit\Framework\TestCase;

class LoggerTargetsTest extends TestCase
{
    use LoggerTestTrait;
    private Logger $logger;
    protected function setUp(): void
    {
        parent::setUp();
        $this->logger = new Logger();
    }

    /** @test */
    public function a_logger_also_sends_the_debug_message_via_email()
    {
       $this->logger->addTarget('email');
       $this->assertStringContainsString("Debug: Hello World\n", $this->getDebugOutput());
       $this->assertStringContainsString("Email sent with message Debug: Hello World\n", $this->getDebugOutput());
    }
}