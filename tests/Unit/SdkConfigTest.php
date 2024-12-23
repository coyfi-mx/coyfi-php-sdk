<?php

namespace Tests\Unit;

use Coyfi\Coyfi;
use Tests\TestCase;

class SdkConfigTest extends TestCase
{
    /**
     * @test
     */
    public function thatSecretKeyCanBeSet(): void
    {
        $key = Coyfi::config('sdk.key');
        $secret = Coyfi::config('sdk.secret');
        Coyfi::setup($key, $secret);

        $this->assertNotEmpty($key);
        $this->assertNotEmpty($secret);
        $this->assertEquals($key, Coyfi::getKey());
        $this->assertEquals($secret, Coyfi::getSecret());
    }
}
