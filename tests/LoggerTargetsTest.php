<?php

declare(strict_types=1);

namespace Tests;

use InvalidArgumentException;
use PFlav\PHPLogger\Logger;
use PFlav\PHPLogger\Targets\AbstractLogger;
use PHPUnit\Framework\TestCase;

class LoggerTargetsTest extends TestCase
{
    use LoggerTestTrait;

    private Logger $logger;

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
        // There was no output from either target for debug messages
        $this->assertEquals("", $this->getDebugOutput());
        // There was output from both targets for info messages
        $this->assertStringContainsString("Console Message Info: Hello World\n", $this->getInfoOutput());
        $this->assertStringContainsString("Email sent with message Info: Hello World\n", $this->getInfoOutput());
        // There was output from both targets for warning messages
        $this->assertStringContainsString("Console Message Warning: Hello World\n", $this->getWarningOutput());
        $this->assertStringContainsString("Email sent with message Warning: Hello World\n", $this->getWarningOutput());
        // There was output from both targets for error messages
        $this->assertStringContainsString("Console Message Critical: Hello World\n", $this->getCriticalOutput());
        $this->assertStringContainsString("Email sent with message Critical: Hello World\n", $this->getCriticalOutput());
    }

    /** @test */
    public function two_different_logger_targets_have_different_log_levels_after_adding_the_second_target()
    {
        // Set the log level for console to info
        $this->logger->setLogLevel(AbstractLogger::LOG_LEVEL_INFO);
        // Add the email target which had a default log level of debug
        $this->logger->addTarget('email');
        // There was a debug message logged to the console for email
        $this->assertEquals("Email sent with message Debug: Hello World\n", $this->getDebugOutput());
        // There was output from both targets for info messages
        $this->assertStringContainsString("Console Message Info: Hello World\n", $this->getInfoOutput());
        $this->assertStringContainsString("Email sent with message Info: Hello World\n", $this->getInfoOutput());
        // There was output from both targets for warning messages
        $this->assertStringContainsString("Console Message Warning: Hello World\n", $this->getWarningOutput());
        $this->assertStringContainsString("Email sent with message Warning: Hello World\n", $this->getWarningOutput());
        // There was output from both targets for error messages
        $this->assertStringContainsString("Console Message Critical: Hello World\n", $this->getCriticalOutput());
        $this->assertStringContainsString("Email sent with message Critical: Hello World\n", $this->getCriticalOutput());
        // There was no debug message logged to the console for console
        $this->assertStringNotContainsString("Console Message Debug: Hello World\n", $this->getDebugOutput());
    }

    /** @test */
    public function a_target_can_be_added_with_a_log_level()
    {
        // Add the email target with a log level of warning
        $this->logger->addTarget('email', AbstractLogger::LOG_LEVEL_WARNING);
        // There was output for debug, info, warning and error messages from the console target
        $this->assertStringContainsString("Console Message Debug: Hello World\n", $this->getDebugOutput());
        $this->assertStringContainsString("Console Message Info: Hello World\n", $this->getInfoOutput());
        $this->assertStringContainsString("Console Message Warning: Hello World\n", $this->getWarningOutput());
        $this->assertStringContainsString("Console Message Critical: Hello World\n", $this->getCriticalOutput());
        // There was output for warning and error messages from the email target
        $this->assertStringContainsString("Email sent with message Warning: Hello World\n", $this->getWarningOutput());
        $this->assertStringContainsString("Email sent with message Critical: Hello World\n", $this->getCriticalOutput());
        // There was no output for debug and info messages from the email target
        $this->assertStringNotContainsString("Email sent with message Debug: Hello World\n", $this->getDebugOutput());
        $this->assertStringNotContainsString("Email sent with message Info: Hello World\n", $this->getInfoOutput());
    }

    /** @test */
    public function a_target_can_change_its_log_level()
    {
        // Add the email target with a log level of critical
        $this->logger->addTarget('email', AbstractLogger::LOG_LEVEL_CRITICAL);
        // There was output for debug, info, warning and error messages from the console target
        $this->assertStringContainsString("Console Message Debug: Hello World\n", $this->getDebugOutput());
        $this->assertStringContainsString("Console Message Info: Hello World\n", $this->getInfoOutput());
        $this->assertStringContainsString("Console Message Warning: Hello World\n", $this->getWarningOutput());
        $this->assertStringContainsString("Console Message Critical: Hello World\n", $this->getCriticalOutput());
        // There was output for critical messages from the email target
        $this->assertStringContainsString("Email sent with message Critical: Hello World\n", $this->getCriticalOutput());
        // There was no output for debug, info and warning messages from the email target
        $this->assertStringNotContainsString("Email sent with message Debug: Hello World\n", $this->getDebugOutput());
        $this->assertStringNotContainsString("Email sent with message Info: Hello World\n", $this->getInfoOutput());
        $this->assertStringNotContainsString("Email sent with message Warning: Hello World\n", $this->getWarningOutput());
        // Change the log level for both email and console targets to info
        $this->logger->addTarget('email', AbstractLogger::LOG_LEVEL_INFO);
        $this->logger->addTarget('console', AbstractLogger::LOG_LEVEL_INFO);
        // There was no output for debug messages from the email and console targets
        $this->assertStringNotContainsString("Email sent with message Debug: Hello World\n", $this->getDebugOutput());
        $this->assertStringNotContainsString("Console Message Debug: Hello World\n", $this->getDebugOutput());
        // There was output for info, warning and critical messages from the email and console targets
        $this->assertStringContainsString("Email sent with message Info: Hello World\n", $this->getInfoOutput());
        $this->assertStringContainsString("Email sent with message Warning: Hello World\n", $this->getWarningOutput());
        $this->assertStringContainsString("Email sent with message Critical: Hello World\n", $this->getCriticalOutput());
        $this->assertStringContainsString("Console Message Info: Hello World\n", $this->getInfoOutput());
        $this->assertStringContainsString("Console Message Warning: Hello World\n", $this->getWarningOutput());
        $this->assertStringContainsString("Console Message Critical: Hello World\n", $this->getCriticalOutput());
    }

    /** @test */
    public function an_exception_is_thrown_when_an_invalid_target_is_passed()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->logger->addTarget('invalid');
    }

    protected function setUp(): void
    {
        parent::setUp();
        $this->logger = new Logger();
    }
}