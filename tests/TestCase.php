<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    public function assertThrows($expectedExceptionType, $callback)
    {
        try {
            $callback();
        } catch (\Throwable $e) {
            $this->assertInstanceOf($expectedExceptionType, $e);
            return;
        }

        $this->fail("Expected {$expectedExceptionType} to be thrown. Got none.");
    }
}
