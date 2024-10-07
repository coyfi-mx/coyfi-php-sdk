<?php

namespace Tests\Feature;

use Coyfi\Cfdi;
use Coyfi\Nodes\Item;
use Coyfi\Nodes\PaymentComplement;
use Coyfi\Nodes\PaymentRelatedDocument;
use Coyfi\Nodes\PaymentRelatedDocumentTax;
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
            'payment_conditions' => 'Sin condiciones',
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
                    'unit_price' => 0,
                    'subtotal' => 0,
                    'unit' => 'ACT',
                    'quantity' => 1,
                    'tax_breakdown' => '01',
                ]),
            ],
            'payment_complements' => [
                new PaymentComplement([
                    'payment_date' => date_format($now, 'Y-m-d H:i:s'),
                    'payment_method' => 'PUE',
                    'payment_form' => '01',
                    'currency' => 'MXN',
                    'exchange_rate' => 1,
                    'related' => [new PaymentRelatedDocument([
                        'invoice_prefix' => 'A',
                        'invoice_number' => 99,
                        'currency' => 'MXN',
                        'amount' => 100,
                        'uuid' => '4E54D99A-597D-479D-A742-170B106096C0',
                        'remaining' => 100,
                        'payment_form' => '01',
                        'payment_number' => 1,
                        'tax_breakdown' => '02',
                        'taxes' => [
                            new PaymentRelatedDocumentTax([
                                'rate' => 0.16,
                                'type' => '002',
                                'factor' => 'Tasa',
                            ]),
                        ],
                    ])],
                ]),
            ],
        ]);

        $cfdi->stamp();
        $cfdi_array = Cfdi::retrieve($cfdi->uuid);

        $this->assertEquals($cfdi_array, $cfdi->toArray());
        $this->assertTrue(Uuid::isValid($cfdi->uuid));
        $this->assertXmlStringEqualsXmlString($cfdi->xml, $cfdi->xml);
    }
}
