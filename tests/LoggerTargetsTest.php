<?php

declare(strict_types=1);

namespace Tests;

use PFlav\PHPLogger\Logger;
use PFlav\PHPLogger\Targets\AbstractLogger;
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
       $this->assertStringContainsString("Console Message Debug: Hello World\n", $this->getDebugOutput());
       $this->assertStringContainsString("Email sent with message Debug: Hello World\n", $this->getDebugOutput());
    }

    /** @test */
    public function two_different_logger_targets_have_same_log_levels_after_adding_the_second_target()
    {
        $this->logger->addTarget('email');
        $this->logger->setLogLevel(AbstractLogger::LOG_LEVEL_INFO);
        $this->assertEquals("", $this->getDebugOutput());
        $this->assertStringContainsString("Console Message Info: Hello World\n", $this->getInfoOutput());
        $this->assertStringContainsString("Email sent with message Info: Hello World\n", $this->getInfoOutput());
        $this->assertStringContainsString("Console Message Warning: Hello World\n", $this->getWarningOutput());
        $this->assertStringContainsString("Email sent with message Warning: Hello World\n", $this->getWarningOutput());
        $this->assertStringContainsString("Console Message Critical: Hello World\n", $this->getCriticalOutput());
        $this->assertStringContainsString("Email sent with message Critical: Hello World\n", $this->getCriticalOutput());
    }

    /** @test */
    public function two_different_logger_targets_have_different_log_levels_after_adding_the_second_target()
    {
        $this->logger->setLogLevel(AbstractLogger::LOG_LEVEL_INFO);
        $this->logger->addTarget('email');
        $this->assertEquals("Email sent with message Debug: Hello World\n", $this->getDebugOutput());
        $this->assertStringContainsString("Console Message Info: Hello World\n", $this->getInfoOutput());
        $this->assertStringContainsString("Email sent with message Info: Hello World\n", $this->getInfoOutput());
        $this->assertStringContainsString("Console Message Warning: Hello World\n", $this->getWarningOutput());
        $this->assertStringContainsString("Email sent with message Warning: Hello World\n", $this->getWarningOutput());
        $this->assertStringContainsString("Console Message Critical: Hello World\n", $this->getCriticalOutput());
        $this->assertStringContainsString("Email sent with message Critical: Hello World\n", $this->getCriticalOutput());
        $this->assertStringNotContainsString("Console Message Debug: Hello World\n", $this->getDebugOutput());
    }

    /** @test */
    public function a_target_can_be_added_with_a_log_level()
    {
        $this->logger->addTarget('email', AbstractLogger::LOG_LEVEL_WARNING);
        $this->assertStringContainsString("Console Message Debug: Hello World\n", $this->getDebugOutput());
        $this->assertStringContainsString("Console Message Info: Hello World\n", $this->getInfoOutput());
        $this->assertStringContainsString("Console Message Warning: Hello World\n", $this->getWarningOutput());
        $this->assertStringContainsString("Email sent with message Warning: Hello World\n", $this->getWarningOutput());
        $this->assertStringContainsString("Console Message Critical: Hello World\n", $this->getCriticalOutput());
        $this->assertStringContainsString("Email sent with message Critical: Hello World\n", $this->getCriticalOutput());
        $this->assertStringNotContainsString("Email sent with message Debug: Hello World\n", $this->getDebugOutput());
        $this->assertStringNotContainsString("Email sent with message Info: Hello World\n", $this->getInfoOutput());
    }

    /** @test */
    public function a_target_can_change_its_log_level()
    {
        $this->logger->addTarget('email', AbstractLogger::LOG_LEVEL_CRITICAL);
        $this->assertStringContainsString("Console Message Debug: Hello World\n", $this->getDebugOutput());
        $this->assertStringContainsString("Console Message Info: Hello World\n", $this->getInfoOutput());
        $this->assertStringContainsString("Console Message Warning: Hello World\n", $this->getWarningOutput());
        $this->assertStringContainsString("Console Message Critical: Hello World\n", $this->getCriticalOutput());
        $this->assertStringContainsString("Email sent with message Critical: Hello World\n", $this->getCriticalOutput());
        $this->assertStringNotContainsString("Email sent with message Debug: Hello World\n", $this->getDebugOutput());
        $this->assertStringNotContainsString("Email sent with message Info: Hello World\n", $this->getInfoOutput());
        $this->assertStringNotContainsString("Email sent with message Warning: Hello World\n", $this->getWarningOutput());
        $this->logger->addTarget('email', AbstractLogger::LOG_LEVEL_INFO);
        $this->logger->addTarget('console', AbstractLogger::LOG_LEVEL_INFO);
        $this->assertStringNotContainsString("Email sent with message Debug: Hello World\n", $this->getDebugOutput());
        $this->assertStringNotContainsString("Console Message Debug: Hello World\n", $this->getDebugOutput());
        $this->assertStringContainsString("Email sent with message Info: Hello World\n", $this->getInfoOutput());
        $this->assertStringContainsString("Email sent with message Warning: Hello World\n", $this->getWarningOutput());
        $this->assertStringContainsString("Console Message Warning: Hello World\n", $this->getWarningOutput());
        $this->assertStringContainsString("Console Message Critical: Hello World\n", $this->getCriticalOutput());
    }
}