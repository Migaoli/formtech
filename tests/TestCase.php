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

    public function jsonWithFiles($method, $uri, array $data = [], array $files = [], array $headers = []) {
        $content = json_encode($data);

        $headers = array_merge([
            'CONTENT_LENGTH' => mb_strlen($content, '8bit'),
            'CONTENT_TYPE' => 'application/json',
            'Accept' => 'application/json',
        ], $headers);

        return $this->call(
            $method, $uri, [], [], $files, $this->transformHeadersToServerVars($headers), $content
        );
    }
}
