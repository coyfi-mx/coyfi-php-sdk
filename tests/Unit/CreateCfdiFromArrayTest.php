<?php

namespace Tests\Unit;

use Coyfi\Cfdi;
use DateTime;
use DateTimeZone;
use Tests\TestCase;

class CreateCfdiFromArrayTest extends TestCase
{
    /**
     * @test
     */
    public function cfdiCanBeCreatedFromArray(): void
    {
        $now = new DateTime('now', new DateTimeZone('America/Mexico_City'));

        $attributtes = [
            'invoice_number' => 1,
            'invoice_prefix' => 'P',
            'cfdi_type' => 'I',
            'payment_method' => 'PUE',
            'payment_form' => '01',
            'sign' => [
                'cfd' => 'ZKK+zbRPzDf7EF66wFWuQ5kvJvXguge5WViz1xbnYDxKfglQ7BrYYrlt/CJbRVlUxv29igT+l5i22OHGtkG/wOrmgUiIkKXetAkcQVb+dy0gG6Ahzs1yihcaZo6+EYZFzIAngmSFZY1GW47XtPqQ7zpsd1OOmQ0Z81hGxrXoAzwiLJaQajxKZaxs79IVSQRBNU9XwNZziGhvlOq93ieOwHgTxE3DVCeP/IIs/XCEwm3hXhBte1VzAqGWy/MXIjenFFF6BNw6P6caYVPD7oGAxXEbmroNfB3Tu0fOPunG7KwF9ZYK3pN94SBMMIQaYlcou0Lepw+DFATbCK3Dlnkurg==',
                'rfc' => 'CVD110412TF6',
                'uuid' => '9DF46DD5-CE79-555D-8635-30ED1138FFF6',
                'stamp' => 'fhmtIp+UT816BRySdCie2oljLwJJXc/ls+qHLjN4cK19wo7Z039vF6UHRRth6clhN2hBUrdoLIQHxS5vBe1k+DQkZhmyjE1rA2usia6eC9zMosetiGWu3fFdNi2W1KpuxMBKhCfOjxj6OdAHrgv71mhvfExI+YdU6BF7Fo+sgEJ1oUgtij9UjUP2uPgZqTu5seb25vrjX1gLZZvr3ij5ly+x04x/Aqqf49foOUWlsOn48qlpe87S7BXAnDXRbChBgWHYUzTsJmFvhuGvYez5iFZVKu74kZWagn/+0Of2jp7cjpPiLFQ2+FqsaRvDqJJpc8MJl8EPJ459v6BfItooQQ==',
                'version' => '1.1',
                'stamp_date' => '2024-02-07T17:02:36',
                'cert_number' => '30001000000500003456',
            ],
            'receiver' => [
                'cfdi_use' => 'S01',
                'business_name' => 'PUBLICO EN GENERAL',
                'rfc' => 'XAXX010101000',
                'tax_regime' => '616',
                'zip_code' => '04000',
            ],
            'global_information' => [
                'frequency' => '01',
                'month' => date('m', time()),
                'year' => date('Y', time()),
            ],
            'related' => [
                [
                    'type' => '01',
                    'uuid' => '4E54D99A-597D-479D-A742-170B106096C0',
                ],
            ],
            'payment_complements' => [
                [
                    'payment_date' => date_format($now, 'Y-m-d H:i:s'),
                    'payment_method' => 'PUE',
                    'payment_form' => '01',
                    'currency' => 'MXN',
                    'exchange_rate' => 1,
                    'related' => [[
                        'amount' => 100,
                        'uuid' => '4E54D99A-597D-479D-A742-170B106096C0',
                        'remaining' => 100,
                        'payment_form' => '01',
                        'payment_number' => 1,
                    ]],
                ],
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
                        'date' => '2023-12-26 12:12:00',
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
                        'date' => '2023-12-27 12:12:00',
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
                    'civil_insurer_name' => 'PFG& Seguros S.A. de C.V.',
                    'civil_insurance_policy' => '154647',
                    'goods_insurer_name' => 'La VillaIOS S. A. de C. V.',
                    'goods_insurance_policy' => '368549',
                    'insurance_amount' => 1200,
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
