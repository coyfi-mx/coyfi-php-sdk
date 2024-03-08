<?php

namespace Coyfi;

use Coyfi\Nodes\CancellationStatus;
use Coyfi\Nodes\Consignment;
use Coyfi\Nodes\GlobalInformation;
use Coyfi\Nodes\Item;
use Coyfi\Nodes\Receiver;
use Coyfi\Nodes\Sign;
use Coyfi\Nodes\Status;
use Coyfi\Traits\HasFromArray;

class Cfdi extends CoyfiObject
{
    use HasFromArray;

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
    public CancellationStatus $cancellation_status;
    public Status $status;
    public GlobalInformation $global_information;

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

    public function cancel($reason, $replacement_invoice_number = null)
    {
        $response = ApiResource::post("cfdi/{$this->uuid}/cancellation", [
            'total' => $this->total,
            'rfc' => $this->receiver->rfc,
            'reason' => $reason,
            'replacement_invoice_number' => $replacement_invoice_number,
        ]);
        $this->cancellation_status = new CancellationStatus($response);

        return $this->cancellation_status;
    }

    public function status()
    {
        $response = ApiResource::post("cfdi/{$this->uuid}/status", [
            'total' => $this->total,
            'rfc' => $this->receiver->rfc,
        ]);
        $this->status = new Status($response);

        return $this->status;
    }

    public function downloadPDF()
    {
        return ApiResource::get("cfdi/{$this->uuid}/pdf");
    }

    public function downloadXML()
    {
        return ApiResource::get("cfdi/{$this->uuid}/xml");
    }

    public function downloadReceiptPDF()
    {
        return ApiResource::get("cfdi/{$this->uuid}/receipt-pdf");
    }
}
