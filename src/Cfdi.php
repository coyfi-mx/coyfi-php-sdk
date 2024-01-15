<?php

namespace Coyfi;

use Coyfi\Nodes\Consignment;
use Coyfi\Nodes\Item;
use Coyfi\Nodes\Receiver;
use Coyfi\Nodes\Sign;

class Cfdi extends CoyfiObject
{
    public $uuid;
    public $xml;
    public $total;

    public $invoice_number;
    public $invoice_prefix;
    public $cfdi_type;
    public $payment_form;
    public $payment_method;
    public $payment_date;
    public $payment_conditions;
    public $payment_number;

    public Receiver $receiver;
    /**
     * @var array<Item>
     */
    public array $items;
    public array $related;
    public array $complements;
    public Sign $sign;
    public Consignment $consignment;

    public function stamp()
    {
        $response = ApiResource::post('cfdi', $this->toArray());
        $response['sign'] = new Sign($response['sign']);
        $this->fill($response);
    }

    public function getVerificationUrl()
    {
        return 'https://verificacfdi.facturaelectronica.sat.gob.mx/default.aspx?id=' .
            $this->uuid . '&re=' . $this->sign->rfc . '&rr=' . $this->receiver->rfc .
            '&fe=' . substr($this->sign->cfd, -8);
    }
}
