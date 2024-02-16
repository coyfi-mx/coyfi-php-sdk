<?php

namespace Tests\Unit;

use Coyfi\Cfdi;
use Tests\TestCase;

class CreateCfdiFromArrayTest extends TestCase
{
    /**
     * @test
     */
    public function cfdiCanBeCreatedFromArray(): void
    {
        $attributtes = [
            'invoice_number' => 1,
            'invoice_prefix' => 'P',
            'cfdi_type' => 'I',
            'payment_method' => 'PUE',
            'payment_form' => '01',
            'receiver' => [
                'cfdi_use' => 'G03',
                'business_name' => 'PÚBLICO EN GENERAL',
                'rfc' => 'XAXX010101000',
                'tax_regime' => '616',
                'zip_code' => '04000',
            ],
            'global_information' => [
                'frequency' => '01',
                'month' => date('m', time()),
                'year' => date('Y', time()),
            ],
            'items' => [
                [
                    'code' => '78101802',
                    'description' => 'Servicios transporte de carga por carretera',
                    'unit_price' => 100.0,
                    'subtotal' => 100.0,
                    'unit' => 'E48',
                    'quantity' => 1,
                    'tax_breakdown' => '02',
                    'taxes' => [
                        [
                            'rate' => 0.16,
                            'type' => '002',
                            'factor' => 'Tasa',
                        ],
                    ],
                ],
            ],
            'consignment' => [
                'country' => 'MEX',
                'international' => 'No',
                'locations' => [
                    [
                        'type' => 'Origen',
                        'rfc' => 'XAXX010101000',
                        'name' => 'Juan Perez',
                        'date' => '2023-12-26 12:12',
                        'addresses' => [
                            [
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
                            ],
                        ],
                    ],
                    [
                        'type' => 'Destino',
                        'rfc' => 'XAXX010101000',
                        'name' => 'Juan Palacios',
                        'date' => '2023-12-27 12:12',
                        'distance' => 123.45,
                        'addresses' => [
                            [
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
                            ],
                        ],
                    ],
                ],
                'goods' => [
                    [
                        'code' => '24131510',
                        'description' => 'Refrigeradores de mostrador',
                        'quantity' => 10.00,
                        'unit' => 'H87',
                        'dimensions' => '59/40/36plg',
                        'dangerous' => 'No',
                        'packaging' => '4D',
                        'weight' => 715.000,
                    ],
                ],
                'inland_transport' => [
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
                ],
                'transport_operators' => [
                    [
                        'type' => '01',
                        'licence_number' => '000004',
                        'name' => 'Pancracio Chug Wan',
                        'rfc' => 'PEVG960713H32',
                    ],
                ],
            ],
        ];
        $consigment_cfdi = Cfdi::fromArray($attributtes);
        $this->assertInstanceOf(Cfdi::class, $consigment_cfdi);

    }
}
