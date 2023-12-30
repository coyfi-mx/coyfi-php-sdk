<?php

namespace Coyfi\Cfdi;

use Coyfi\Cfdi\Nodes\Receiver;

class Cfdi extends CoyfiObject
{
    public $uuid;
    public $xml;

    public $invoice_number;
    public $invoice_prefix;
    public $cfdi_type;
    public $payment_form;
    public $payment_method;
    public $payment_date;
    public $payment_conditions;
    public $payment_number;

    public Receiver $receiver;
    public array $items;
    public array $related;
    public array $complements;

    public function stamp()
    {
        $response = ApiResource::post('cfdi', $this->toArray());
        $this->fill($response);
    }
}
