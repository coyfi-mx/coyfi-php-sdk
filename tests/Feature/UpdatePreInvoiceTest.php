<?php

namespace Tests\Feature;

use Coyfi\Cfdi;
use Coyfi\Nodes\GlobalInformation;
use Coyfi\Nodes\Item;
use Coyfi\Nodes\Receiver;
use Coyfi\Nodes\Tax;
use Tests\TestCase;

class UpdatePreInvoiceTest extends TestCase
{
    /**
     * @test
     */
    public function updatePreInvoice(): void
    {
        $cfdi = new Cfdi([
            'uuid' => 'PRE-' . '7821ABD3-472D-59FE-A851-02C58AC09A04',
            'invoice_number' => 1,
            'invoice_prefix' => 'I',
            'cfdi_type' => 'I',
            'payment_form' => '01',
            'payment_method' => 'PUE',
            'pre_invoice' => true,
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
        $cfdi->save();

        $cfdi->status = 'REGISTRADA';
        $cfdi->update();
        $this->assertEquals('REGISTRADA', $cfdi->status, 'Pre invoice not updated');
    }
}
