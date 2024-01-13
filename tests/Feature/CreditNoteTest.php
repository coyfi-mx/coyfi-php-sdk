<?php

namespace Tests\Feature;

use Coyfi\Cfdi;
use Coyfi\Nodes\Item;
use Coyfi\Nodes\Receiver;
use Coyfi\Nodes\RelatedCfdi;
use DateTime;
use DateTimeZone;
use Ramsey\Uuid\Uuid;
use Tests\TestCase;

class CreditNoteTest extends TestCase
{
    /**
     * @test
     */
    public function thatCreditNoteCanBeStamped(): void
    {
        $now = new DateTime('now', new DateTimeZone('America/Mexico_City'));
        $now->modify('-1 day');
        $cfdi = new Cfdi([
            'invoice_number' => 1,
            'invoice_prefix' => 'E',
            'cfdi_type' => 'E',
            'payment_form' => '01',
            'payment_method' => 'PUE',
            'payment_conditions' => 'Sin condiciones',
            'payment_date' => date_format($now, 'Y-m-d'),
            'receiver' => new Receiver([
                'cfdi_use' => 'G03',
                'business_name' => 'PÚBLICO EN GENERAL',
                'rfc' => 'XAXX010101000',
                'tax_regime' => '616',
                'zip_code' => '04000',
            ]),
            'items' => [
                new Item([
                    'code' => '01010101',
                    'description' => 'NOTA DE CREDITO CORRESPONDIENTE A LA FACTURA TAL',
                    'unit_price' => 100.0,
                    'subtotal' => 100.0,
                    'unit' => 'ACT',
                    'quantity' => 1,
                    'tax_breakdown' => '01',
                ]),
            ],
            'related' => [
                new RelatedCfdi([
                    'type' => '01',
                    'uuid' => '4E54D99A-597D-479D-A742-170B106096C0',
                ]),
            ],
        ]);

        $cfdi->stamp();
        $this->assertTrue(Uuid::isValid($cfdi->uuid));
        $this->assertXmlStringEqualsXmlString($cfdi->xml, $cfdi->xml);
    }
}
