<?php

namespace Tests\Feature;

use Coyfi\Subscription;
use Tests\TestCase;

class ActiveSubscriptionTest extends TestCase
{
    /**
     * @test
     */
    public function thatActiveSubscriptionCanBeRetrieved(): void
    {
        $subscription = Subscription::retrieve();

        $this->assertNotEmpty($subscription->expires_at);
        $this->assertNotEmpty($subscription->benefits);
    }
}
