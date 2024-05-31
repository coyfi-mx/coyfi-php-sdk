<?php

namespace Tests\Feature;

use Coyfi\Cfdi;
use Tests\TestCase;

class CancelInvoiceTest extends TestCase
{
    /**
     * @test
     */
    public function thatInvoiceCanBeCancelled(): void
    {
        $cfdi = Cfdi::fromArray([
            'uuid' => 'FFA1DB2F-F8DB-56B6-B27A-0D0B4B2D6D8B',
            'total' => '0.000000',
            'receiver' => [
                'cfdi_use' => 'S01',
                'business_name' => 'PUBLICO EN GENERAL',
                'rfc' => 'XAXX010101000',
                'tax_regime' => '616',
                'zip_code' => '04000',
            ],
        ]);
        $cancellation_status = $cfdi->cancel('02');

        $this->assertEquals($cancellation_status->total, $cfdi->total);
    }

    /**
     * @test
     */
    public function thatInvoiceStatusCanBeRetrieved(): void
    {
        $cfdi = Cfdi::fromArray([
            'uuid' => 'FFA1DB2F-F8DB-56B6-B27A-0D0B4B2D6D8B',
            'total' => '0.000000',
            'receiver' => [
                'cfdi_use' => 'S01',
                'business_name' => 'PUBLICO EN GENERAL',
                'rfc' => 'XAXX010101000',
                'tax_regime' => '616',
                'zip_code' => '04000',
            ],
        ]);
        $status = $cfdi->status();

        $this->assertEquals($status->total, $cfdi->total);
    }
}
