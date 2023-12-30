<?php

namespace Feature;

use Coyfi\Cfdi\Cfdi;
use Coyfi\Cfdi\Coyfi;
use Coyfi\Cfdi\Nodes\Address;
use Coyfi\Cfdi\Nodes\Consignment;
use Coyfi\Cfdi\Nodes\Good;
use Coyfi\Cfdi\Nodes\Item;
use Coyfi\Cfdi\Nodes\Location;
use Coyfi\Cfdi\Nodes\Receiver;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

class ConsignmentNoteTest extends TestCase
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
    public function thatConsignmentNoteCanBeStamped(): void
    {
        $cfdi = new Cfdi([
            'invoice_number' => 1,
            'invoice_prefix' => 'P',
            'cfdi_type' => 'I',
            'payment_method' => 'PUE',
            'payment_form' => '01',
            'receiver' => new Receiver([
                'cfdi_use' => 'G03',
                'business_name' => 'PÚBLICO EN GENERAL',
                'rfc' => 'XAXX010101000',
                'tax_regime' => '616',
                'zip_code' => '04000',
            ]),
            'items' => [
                new Item([
                    'code' => '78101802',
                    'description' => 'Servicios transporte de carga por carretera',
                    'unit_price' => 100.0,
                    'subtotal' => 100.0,
                    'unit' => 'E48',
                    'quantity' => 1,
                    'tax_breakdown' => '01',
                ]),
            ],
            'consignment' => new Consignment([
                'country' => 'MEX',
                'international' => 'No',
                'locations' => [
                    new Location([
                        'type' => 'Origen',
                        'rfc' => 'XAXX010101000',
                        'name' => 'Juan Perez',
                        'date' => '2023-12-26 12:12',
                        'addresses' => [
                            new Address([
                                'street' => 'Avenida Reforma Norte.',
                                'street_number' => '77',
                                'suite_number' => '1303',
                                'zip_code' => '06300',
                                'neighborhood' => '0900',
                                'locality' => '06',
                                'reference' => 'Frente al parque de Santa Úrsula',
                                'city' => '015',
                                'state' => 'CMX',
                                'country' => 'MEX',
                            ]),
                        ],
                    ]),
                    new Location([
                        'type' => 'Destino',
                        'rfc' => 'XAXX010101000',
                        'name' => 'Juan Palacios',
                        'date' => '2023-12-27 12:12',
                        'distance' => 123.45,
                        'addresses' => [
                            new Address([
                                'street' => 'Avenida Reforma Norte.',
                                'street_number' => '77',
                                'suite_number' => '1303',
                                'zip_code' => '06300',
                                'neighborhood' => '0900',
                                'locality' => '06',
                                'reference' => 'Frente al parque de Santa Úrsula',
                                'city' => '015',
                                'state' => 'CMX',
                                'country' => 'MEX',
                            ]),
                        ],
                    ]),
                ],
                'goods' => [
                    new Good([
                        'licence_number' => '000004',
                        'name' => 'Pancracio Chug Wan',
                        'rfc' => 'PEVG960713H32',
                    ]),
                ],
            ]),
        ]);

        $cfdi->stamp();
        $this->assertTrue(Uuid::isValid($cfdi->uuid));
        $this->assertXmlStringEqualsXmlString($cfdi->xml, $cfdi->xml);
    }
}
