<?php

namespace Coyfi\Traits;

use Coyfi\Cfdi;
use Coyfi\Nodes\Address;
use Coyfi\Nodes\CancellationStatus;
use Coyfi\Nodes\Complement;
use Coyfi\Nodes\Consignment;
use Coyfi\Nodes\GlobalInformation;
use Coyfi\Nodes\Good;
use Coyfi\Nodes\InlandTransport;
use Coyfi\Nodes\Item;
use Coyfi\Nodes\Location;
use Coyfi\Nodes\Receiver;
use Coyfi\Nodes\RelatedCfdi;
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

            ...isset($attributes['invoice_number']) ? ['invoice_number' => $attributes['invoice_number']] : [],
            ...isset($attributes['invoice_prefix']) ? ['invoice_prefix' => $attributes['invoice_prefix']] : [],
            ...isset($attributes['cfdi_type']) ? ['cfdi_type' => $attributes['cfdi_type']] : [],
            ...isset($attributes['payment_method']) ? ['payment_method' => $attributes['payment_method']] : [],
            ...isset($attributes['payment_form']) ? ['payment_form' => $attributes['payment_form']] : [],
            ...isset($attributes['payment_date']) ? ['payment_date' => $attributes['payment_date']] : [],
            ...isset($attributes['payment_conditions']) ? ['payment_conditions' => $attributes['payment_conditions']] : [],
            ...isset($attributes['payment_number']) ? ['payment_number' => $attributes['payment_number']] : [],
        ]);

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

        if (isset($attributes['complements'])) {
            $cfdi->complements = array_map(function ($complement) {
                return new Complement($complement);
            }, $attributes['complements']);
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
