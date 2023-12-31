<?php

declare(strict_types=1);

namespace Tests;

use PFlav\PHPLogger\Logger;
use PFlav\PHPLogger\Targets\AbstractLogger;
use PHPUnit\Framework\TestCase;

class LoggerTest extends TestCase
{
    use LoggerTestTrait;

    private Logger $logger;

    /** @test */
    public function a_logger_logs_a_debug_message_to_the_console()
    {
        $this->assertEquals("Console Message Debug: Hello World\n", $this->getDebugOutput());
    }

    /** @test */
    public function a_logger_logs_an_info_message_to_the_console()
    {
        $this->assertEquals("Console Message Info: Hello World\n", $this->getInfoOutput());
    }

    /** @test */
    public function a_logger_logs_a_warning_message_to_the_console()
    {
        $this->assertEquals("Console Message Warning: Hello World\n", $this->getWarningOutput());
    }

    /** @test */
    public function a_logger_logs_an_error_message_to_the_console()
    {
        $this->assertEquals("Console Message Critical: Hello World\n", $this->getCriticalOutput());
    }

    /** @test */
    public function a_debug_message_is_not_logged_if_the_log_level_is_set_to_info_but_info_warning_and_error_messages_are()
    {
        $this->logger->setLogLevel(AbstractLogger::LOG_LEVEL_INFO);
        $this->assertEquals("", $this->getDebugOutput());
        $this->assertEquals("Console Message Info: Hello World\n", $this->getInfoOutput());
        $this->assertEquals("Console Message Warning: Hello World\n", $this->getWarningOutput());
        $this->assertEquals("Console Message Critical: Hello World\n", $this->getCriticalOutput());
    }

    /** @test */
    public function debug_and_info_messages_are_not_logged_if_the_log_level_is_set_to_warning_but_warning_and_error_messages_are()
    {
        $this->logger->setLogLevel(AbstractLogger::LOG_LEVEL_WARNING);
        $this->assertEquals("", $this->getDebugOutput());
        $this->assertEquals("", $this->getInfoOutput());
        $this->assertEquals("Console Message Warning: Hello World\n", $this->getWarningOutput());
        $this->assertEquals("Console Message Critical: Hello World\n", $this->getCriticalOutput());
    }

    /** @test */
    public function only_error_messages_are_logged_when_the_log_level_is_set_to_critical()
    {
        $this->logger->setLogLevel(AbstractLogger::LOG_LEVEL_CRITICAL);
        $this->assertEquals("", $this->getDebugOutput());
        $this->assertEquals("", $this->getInfoOutput());
        $this->assertEquals("", $this->getWarningOutput());
        $this->assertEquals("Console Message Critical: Hello World\n", $this->getCriticalOutput());
    }

    /** @test */
    public function the_log_level_is_unchanged_if_an_invalid_log_level_is_set()
    {
        $this->logger->setLogLevel("Invalid Log Level");
        $this->assertEquals("Console Message Debug: Hello World\n", $this->getDebugOutput());
        $this->assertEquals("Console Message Info: Hello World\n", $this->getInfoOutput());
        $this->assertEquals("Console Message Warning: Hello World\n", $this->getWarningOutput());
        $this->assertEquals("Console Message Critical: Hello World\n", $this->getCriticalOutput());
    }

    /** @test */
    public function the_log_level_is_unchanged_if_a_null_log_level_is_set()
    {
        $this->logger->setLogLevel();
        $this->assertEquals("Console Message Debug: Hello World\n", $this->getDebugOutput());
        $this->assertEquals("Console Message Info: Hello World\n", $this->getInfoOutput());
        $this->assertEquals("Console Message Warning: Hello World\n", $this->getWarningOutput());
        $this->assertEquals("Console Message Critical: Hello World\n", $this->getCriticalOutput());
    }

    protected function setUp(): void
    {
        parent::setUp();
        $this->logger = new Logger();
    }
}