<?php

namespace Tests;

use Coyfi\Coyfi;
use Dotenv\Dotenv;
use PHPUnit\Framework\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    protected function setUp(): void
    {
        $dotenv = Dotenv::createImmutable(__DIR__ . '/../');
        $dotenv->safeLoad();

        $key = Coyfi::config('sdk.key');
        $secret = Coyfi::config('sdk.secret');
        Coyfi::setup($key, $secret);
    }
}
