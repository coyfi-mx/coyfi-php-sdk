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
            'uuid' => '14162DEF-6CF5-5CFE-98F0-162D51FBFBB1',
            'total' => 117.16,
            'receiver' => [
                'cfdi_use' => 'G03',
                'business_name' => 'PÚBLICO EN GENERAL',
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
            'uuid' => '14162DEF-6CF5-5CFE-98F0-162D51FBFBB1',
            'total' => 117.16,
            'receiver' => [
                'cfdi_use' => 'G03',
                'business_name' => 'PÚBLICO EN GENERAL',
                'rfc' => 'XAXX010101000',
                'tax_regime' => '616',
                'zip_code' => '04000',
            ],
        ]);
        $status = $cfdi->status();

        $this->assertEquals($status->total, $cfdi->total);
    }
}
