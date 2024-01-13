<?php

namespace Tests\Unit;

use Coyfi\Models\Country;
use Tests\TestCase;

class DatabaseModelTest extends TestCase
{
    /**
     * @test
     */
    public function anModelIndexCanBeRetrieved(): void
    {
        $countries = Country::all();

        $this->assertNotEmpty($countries);
        $this->assertInstanceOf(Country::class, array_pop($countries));
    }

    /**
     * @test
     */
    public function anModelCanBeRetrievedByCode(): void
    {
        $country = Country::findByCode('MEX');

        $this->assertInstanceOf(Country::class, $country);
    }

    /**
     * @test
     */
    public function anModelCanBeRetrievedByName(): void
    {
        $country = Country::findByName('México');

        $this->assertInstanceOf(Country::class, $country);
    }
}
