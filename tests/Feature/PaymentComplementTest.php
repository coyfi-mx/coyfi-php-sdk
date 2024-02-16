<?php

namespace Tests\Feature;

use Coyfi\Cfdi;
use Coyfi\Nodes\Complement;
use Coyfi\Nodes\Item;
use Coyfi\Nodes\Receiver;
use DateTime;
use DateTimeZone;
use Ramsey\Uuid\Uuid;
use Tests\TestCase;

class PaymentComplementTest extends TestCase
{
    /**
     * @test
     */
    public function paymentComplementCanBeStamped(): void
    {
        $now = new DateTime('now', new DateTimeZone('America/Mexico_City'));
        $now->modify('-1 day');
        $cfdi = new Cfdi([
            'invoice_number' => 1,
            'invoice_prefix' => 'P',
            'cfdi_type' => 'P',
            'payment_method' => 'PUE',
            'payment_conditions' => 'Sin condiciones',
            'payment_date' => date_format($now, 'Y-m-d'),
            'payment_number' => 2,
            'receiver' => new Receiver([
                'cfdi_use' => 'G03',
                'business_name' => 'MARIA OLIVIA MARTINEZ SAGAZ',
                'rfc' => 'MASO451221PM4',
                'tax_regime' => '612',
                'zip_code' => '80290',
            ]),
            'items' => [
                new Item([
                    'code' => '84111506',
                    'description' => 'Pago',
                    'unit_price' => 100,
                    'subtotal' => 100,
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
                    'remaining' => 100,
                    'payment_number' => 1,
                ]),
            ],
        ]);

        $cfdi->stamp();

        $this->assertTrue(Uuid::isValid($cfdi->uuid));
        $this->assertXmlStringEqualsXmlString($cfdi->xml, $cfdi->xml);
    }
}
