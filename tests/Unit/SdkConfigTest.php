<?php

namespace Unit;

use Coyfi\Coyfi;
use PHPUnit\Framework\TestCase;

class SdkConfigTest extends TestCase
{
    /**
     * @test
     */
    public function thatEnvConfigExists(): void
    {
        $this->assertNotEmpty(Coyfi::config('sdk.env'));
    }

    /**
     * @test
     */
    public function thatSecretKeyCanBeSet(): void
    {
        $key = Coyfi::config('sdk.key');
        $secret = Coyfi::config('sdk.secret');
        Coyfi::setup($key, $secret);

        $this->assertEquals($key, Coyfi::getKey());
        $this->assertEquals($secret, Coyfi::getSecret());
    }
}
