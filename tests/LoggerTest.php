<?php

use PFlav\PHPLogger\Logger;
use PHPUnit\Framework\TestCase;

class LoggerTest extends TestCase
{
    /** @test */
    public function a_logger_echoes_a_message_in_the_console()
    {
        $logger = new Logger();
        ob_start();
        $logger->log("Hello World");
        $output = ob_get_clean();
        $this->assertEquals("Hello World\n", $output);
    }
}