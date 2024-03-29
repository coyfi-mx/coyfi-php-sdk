<?php

namespace Tests\Feature;

use Coyfi\Cfdi;
use Coyfi\Nodes\GlobalInformation;
use Coyfi\Nodes\Item;
use Coyfi\Nodes\Receiver;
use Coyfi\Nodes\Tax;
use Ramsey\Uuid\Uuid;
use Tests\TestCase;

class IncomeInvoiceTest extends TestCase
{
    /**
     * @test
     */
    public function thatInvoiceCanBeStamped(): void
    {
        $cfdi = new Cfdi([
            'invoice_number' => 1,
            'invoice_prefix' => 'I',
            'cfdi_type' => 'I',
            'payment_form' => '01',
            'payment_method' => 'PUE',
            'payment_conditions' => 'Sin condiciones',
            'receiver' => new Receiver([
                'cfdi_use' => 'S01',
                'business_name' => 'PUBLICO EN GENERAL',
                'rfc' => 'XAXX010101000',
                'tax_regime' => '616',
                'zip_code' => '04000',
            ]),
            'global_information' => new GlobalInformation([
                'frequency' => '01',
                'month' => date('m', time()),
                'year' => date('Y', time()),
            ]),
            'items' => [
                new Item([
                    'code' => '01010101',
                    'description' => 'Cosa 1',
                    'unit_price' => 100.0,
                    'subtotal' => 100.0,
                    'unit' => 'H87',
                    'quantity' => 1,
                    'tax_breakdown' => '02',
                    'taxes' => [
                        new Tax([
                            'rate' => 0.16,
                            'type' => '002',
                            'factor' => 'Tasa',
                        ]),
                    ],
                ]),
            ],
        ]);
        $cfdi->stamp();
        $cfdi_array = Cfdi::retrieve($cfdi->uuid);

        $this->assertEquals($cfdi_array, $cfdi->toArray());
        $this->assertTrue(Uuid::isValid($cfdi->uuid));
        $this->assertEquals($cfdi->uuid, $cfdi->sign->uuid);
        $this->assertXmlStringEqualsXmlString($cfdi->xml, $cfdi->xml);
    }
}
