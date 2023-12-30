<?php

namespace Feature;

use Coyfi\Cfdi\Cfdi;
use Coyfi\Cfdi\Coyfi;
use Coyfi\Cfdi\Nodes\Complement;
use Coyfi\Cfdi\Nodes\Item;
use Coyfi\Cfdi\Nodes\Receiver;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

class PaymentComplementTest extends TestCase
{
    protected function setUp(): void
    {
        $key = config('sdk.key');
        $secret = config('sdk.secret');
        Coyfi::setup($key, $secret);
    }

    /**
     * @test
     */
    public function thatPaymentComplementCanBeStamped(): void
    {
        $cfdi = new Cfdi([
            'invoice_number' => 1,
            'invoice_prefix' => 'P',
            'cfdi_type' => 'P',
            'payment_method' => 'PUE',
            'payment_conditions' => 'Sin condiciones',
            'payment_date' => '2023-12-27',
            'payment_number' => 2,
            'receiver' => new Receiver([
                'cfdi_use' => 'G03',
                'business_name' => 'PÚBLICO EN GENERAL',
                'rfc' => 'XAXX010101000',
                'tax_regime' => '616',
                'zip_code' => '04000',
            ]),
            'items' => [
                new Item([
                    'code' => '84111506',
                    'description' => 'Pago',
                    'unit_price' => 0,
                    'subtotal' => 0,
                    'unit' => 'ACT',
                    'quantity' => 1,
                    'tax_breakdown' => '01',
                ]),
            ],
            'complements' => [
                new Complement([
                    'amount' => 100,
                    'uuid' => '4E54D99A-597D-479D-A742-170B106096C0',
                    'payment_form' => '01',
                ]),
            ],
        ]);

        $cfdi->stamp();
        $this->assertTrue(Uuid::isValid($cfdi->uuid));
        $this->assertXmlStringEqualsXmlString($cfdi->xml, $cfdi->xml);
    }
}
