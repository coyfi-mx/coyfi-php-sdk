<?php

namespace Feature;

use Coyfi\Cfdi;
use Coyfi\Coyfi;
use Coyfi\Nodes\Address;
use Coyfi\Nodes\Consignment;
use Coyfi\Nodes\Good;
use Coyfi\Nodes\InlandTransport;
use Coyfi\Nodes\Item;
use Coyfi\Nodes\Location;
use Coyfi\Nodes\Receiver;
use Coyfi\Nodes\TransportOperator;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

class ConsignmentNoteTest extends TestCase
{
    protected function setUp(): void
    {
        $key = Coyfi::config('sdk.key');
        $secret = Coyfi::config('sdk.secret');
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
                        'code' => '24131510',
                        'description' => 'Refrigeradores de mostrador',
                        'quantity' => 10.00,
                        'unit' => 'H87',
                        'dimensions' => '59/40/36plg',
                        'dangerous' => 'No',
                        'packaging' => '4D',
                        'weight' => 715.000,
                    ]),
                ],
                'inland_transport' => new InlandTransport([
                    'licence_type' => 'TPAF01',
                    'licence_number' => '0X2XTXZ0X5X0X3X2X1X0',
                    'transport_type' => 'C2',
                    'weight' => 35.5,
                    'license_plate' => '501AA',
                    'year' => '2020',
                    'civil_insurer_name' => ' PFG& Seguros S.A. de C.V.',
                    'civil_insurance_policy' => '154647',
                    'goods_insurer_name' => 'La VillaIOS S. A. de C. V.',
                    'goods_insurance_policy' => '368549',
                    'insurance_amount' => 1200.00,
                ]),
                'transport_operators' => [
                    new TransportOperator([
                        'type' => '01',
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
        dump($cfdi->xml);
    }
}
