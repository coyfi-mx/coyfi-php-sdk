<?php

namespace Tests\Feature;

use Coyfi\Cfdi;
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
        $cfdi = Cfdi::fromArray([
            'invoice_number' => 1,
            'invoice_prefix' => 'E',
            'cfdi_type' => 'E',
            'payment_form' => '01',
            'payment_method' => 'PUE',
            'payment_conditions' => 'Sin condiciones',
            'payment_date' => date_format($now, 'Y-m-d H:i:s'),
            'receiver' => [
                'cfdi_use' => 'G03',
                'business_name' => 'MARIA OLIVIA MARTINEZ SAGAZ',
                'rfc' => 'MASO451221PM4',
                'tax_regime' => '612',
                'zip_code' => '80290',
            ],
            'items' => [
                [
                    'code' => '01010101',
                    'description' => 'NOTA DE CREDITO CORRESPONDIENTE A LA FACTURA TAL',
                    'unit_price' => 100.0,
                    'subtotal' => 100.0,
                    'unit' => 'ACT',
                    'quantity' => 1,
                    'tax_breakdown' => '01',
                ],
            ],
            'related' => [
                [
                    'type' => '01',
                    'uuid' => '4E54D99A-597D-479D-A742-170B106096C0',
                ],
            ],
        ]);

        $cfdi->stamp();
        $cfdi_array = Cfdi::retrieve($cfdi->uuid);

        $this->assertEquals($cfdi_array, $cfdi->toArray());
        $this->assertTrue(Uuid::isValid($cfdi->uuid));
        $this->assertXmlStringEqualsXmlString($cfdi->xml, $cfdi->xml);
    }
}
