<?php

namespace Coyfi\Traits;

use Coyfi\Cfdi;
use Coyfi\Nodes\Address;
use Coyfi\Nodes\CancellationStatus;
use Coyfi\Nodes\Consignment;
use Coyfi\Nodes\GlobalInformation;
use Coyfi\Nodes\Good;
use Coyfi\Nodes\InlandTransport;
use Coyfi\Nodes\Item;
use Coyfi\Nodes\Location;
use Coyfi\Nodes\PaymentComplement;
use Coyfi\Nodes\PaymentRelatedDocument;
use Coyfi\Nodes\PaymentRelatedDocumentTax;
use Coyfi\Nodes\Receiver;
use Coyfi\Nodes\RelatedCfdi;
use Coyfi\Nodes\Sign;
use Coyfi\Nodes\Status;
use Coyfi\Nodes\Tax;
use Coyfi\Nodes\TransportOperator;

trait HasFromArray
{
    public static function fromArray($attributes)
    {
        $cfdi = new Cfdi([
            ...isset($attributes['uuid']) ? ['uuid' => $attributes['uuid']] : [],
            ...isset($attributes['xml']) ? ['xml' => $attributes['xml']] : [],
            ...isset($attributes['total']) ? ['total' => $attributes['total']] : [],
            ...isset($attributes['date']) ? ['date' => $attributes['date']] : [],
            ...isset($attributes['status']) ? ['status' => $attributes['status']] : [],

            ...isset($attributes['invoice_number']) ? ['invoice_number' => $attributes['invoice_number']] : [],
            ...isset($attributes['invoice_prefix']) ? ['invoice_prefix' => $attributes['invoice_prefix']] : [],
            ...isset($attributes['cfdi_type']) ? ['cfdi_type' => $attributes['cfdi_type']] : [],
            ...isset($attributes['payment_method']) ? ['payment_method' => $attributes['payment_method']] : [],
            ...isset($attributes['payment_form']) ? ['payment_form' => $attributes['payment_form']] : [],
            ...isset($attributes['payment_terms']) ? ['payment_terms' => $attributes['payment_terms']] : [],
        ]);

        if (isset($attributes['sign'])) {
            $cfdi->sign = new Sign($attributes['sign']);
        }

        if (isset($attributes['receiver'])) {
            $cfdi->receiver = new Receiver($attributes['receiver']);
        }

        if (isset($attributes['global_information'])) {
            $cfdi->global_information = new GlobalInformation($attributes['global_information']);
        }

        if (isset($attributes['items'])) {
            $cfdi->items = array_map(function ($item_attributes) {
                $item = new Item([
                    'code' => $item_attributes['code'],
                    'description' => $item_attributes['description'],
                    'unit_price' => $item_attributes['unit_price'],
                    'subtotal' => $item_attributes['subtotal'],
                    'unit' => $item_attributes['unit'],
                    'quantity' => $item_attributes['quantity'],
                    'tax_breakdown' => $item_attributes['tax_breakdown'],
                ]);
                if (isset($item_attributes['taxes'])) {
                    $item->taxes = array_map(fn ($tax) => new Tax($tax), $item_attributes['taxes']);
                }

                return $item;
            }, $attributes['items']);
        }

        if (isset($attributes['payment_complements'])) {
            $cfdi->payment_complements = array_map(function ($payment_complement) {
                return new PaymentComplement([
                    'payment_date' => $payment_complement['payment_date'],
                    'payment_form' => $payment_complement['payment_form'],
                    'currency' => $payment_complement['currency'],
                    'exchange_rate' => $payment_complement['exchange_rate'],
                    'transaction_number' => $payment_complement['transaction_number'] ?? null,
                    'payer_account_rfc' => $payment_complement['payer_account_rfc'] ?? null,
                    'payer_bank_name' => $payment_complement['payer_bank_name'] ?? null,
                    'payer_account_number' => $payment_complement['payer_account_number'] ?? null,
                    'beneficiary_account_rfc' => $payment_complement['beneficiary_account_rfc'] ?? null,
                    'beneficiary_account_number' => $payment_complement['beneficiary_account_number'] ?? null,
                    'related' => array_map(function ($related_document) {
                        $paymentRelatedDocument = new PaymentRelatedDocument([
                            'amount' => $related_document['amount'],
                            'uuid' => $related_document['uuid'],
                            'payment_form' => $related_document['payment_form'],
                            'remaining' => $related_document['remaining'],
                            'payment_number' => $related_document['payment_number'],
                            'tax_breakdown' => $related_document['tax_breakdown'],
                        ]);
                        if (isset($related_document['taxes'])) {
                            $paymentRelatedDocument->taxes = array_map(fn ($tax) => new PaymentRelatedDocumentTax($tax), $related_document['taxes']);
                        }

                    }, $payment_complement['related']),
                ]);
            }, $attributes['payment_complements']);
        }

        if (isset($attributes['related'])) {
            $cfdi->related = array_map(function ($related_cfdi) {
                return new RelatedCfdi($related_cfdi);
            }, $attributes['related']);
        }

        if (isset($attributes['consignment'])) {
            $cfdi->consignment = new Consignment([
                'country' => $attributes['consignment']['country'],
                'international' => $attributes['consignment']['international'],
            ]);

            if (isset($attributes['consignment']['locations'])) {
                $cfdi->consignment->locations = array_map(function ($location_attributtes) {
                    $location = new Location([
                        'type' => $location_attributtes['type'],
                        'rfc' => $location_attributtes['rfc'],
                        'name' => $location_attributtes['name'],
                        'date' => $location_attributtes['date'],
                        ...isset($location_attributtes['distance']) ? ['distance' => $location_attributtes['distance']] : [],

                    ]);

                    if (isset($location_attributtes['addresses'])) {
                        $location->addresses = array_map(fn ($address) => new Address($address), $location_attributtes['addresses']);
                    }

                    return $location;
                }, $attributes['consignment']['locations']);
            }

            if (isset($attributes['consignment']['goods'])) {
                $cfdi->consignment->goods = array_map(function ($good) {
                    return new Good($good);
                }, $attributes['consignment']['goods']);
            }
            if (isset($attributes['consignment']['inland_transport'])) {
                $cfdi->consignment->inland_transport = new InlandTransport($attributes['consignment']['inland_transport']);
            }
            if (isset($attributes['consignment']['transport_operators'])) {
                $cfdi->consignment->transport_operators = array_map(function ($transport_operator) {
                    return new TransportOperator($transport_operator);
                }, $attributes['consignment']['transport_operators']);
            }
        }

        if (isset($attributes['cancellation_status'])) {
            $cfdi->cancellation_status = new CancellationStatus($attributes['cancellation_status']);
        }

        if (isset($attributes['status'])) {
            $cfdi->status = new Status($attributes['status']);
        }
        if (isset($attributes['global_information'])) {
            $cfdi->global_information = new GlobalInformation($attributes['global_information']);
        }

        return $cfdi;
    }
}
