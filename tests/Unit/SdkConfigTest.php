<?php

namespace Unit;

use Coyfi\Cfdi\Coyfi;
use PHPUnit\Framework\TestCase;

class SdkConfigTest extends TestCase
{
    /**
     * @test
     */
    public function thatEnvConfigExists(): void
    {
        $this->assertNotEmpty(config('sdk.env'));
    }

    /**
     * @test
     */
    public function thatSecretKeyCanBeSet(): void
    {
        $key = config('sdk.key');
        $secret = config('sdk.secret');
        Coyfi::setup($key, $secret);

        $this->assertEquals($key, Coyfi::getKey());
        $this->assertEquals($secret, Coyfi::getSecret());
    }
}
