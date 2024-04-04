<?php

namespace Coyfi;

use Coyfi\Nodes\CancellationStatus;
use Coyfi\Nodes\Consignment;
use Coyfi\Nodes\GlobalInformation;
use Coyfi\Nodes\InvoiceStatus;
use Coyfi\Nodes\Item;
use Coyfi\Nodes\Receiver;
use Coyfi\Nodes\Sign;
use Coyfi\Traits\HasFromArray;
use DateTime;
use DateTimeZone;

class Cfdi extends CoyfiObject
{
    use HasFromArray;

    public $uuid;
    public $xml;
    public $total;
    public $date;
    public $status;
    public Sign $sign;

    public $invoice_number;
    public $invoice_prefix;
    public $cfdi_type;
    public $payment_form;
    public $payment_method;
    public $payment_terms;

    public Receiver $receiver;
    /**
     * @var array<Item>
     */
    public array $items;
    public array $related;
    public array $payment_complements;
    public Consignment $consignment;
    public CancellationStatus $cancellation_status;
    public InvoiceStatus $invoice_status;
    public GlobalInformation $global_information;

    public static function retrieve($uuid)
    {
        return ApiResource::get("cfdi/{$uuid}");
    }

    public function stamp()
    {
        $response = ApiResource::post('cfdi', $this->toArray());
        $response['sign'] = new Sign($response['sign']);

        $datetime = new DateTime;
        $datetime->setTimestamp(strtotime($response['date']));
        $datetime->setTimezone(new DateTimeZone('America/Mexico_City'));
        $response['date'] = $datetime->format('Y-m-d H:i:s');

        $this->fill($response);
    }

    public function getVerificationUrl()
    {
        return 'https://verificacfdi.facturaelectronica.sat.gob.mx/default.aspx?id=' .
            $this->uuid . '&re=' . $this->sign->rfc . '&rr=' . $this->receiver->rfc .
            '&fe=' . substr($this->sign->cfd, -8) . '&tt=' . $this->total;
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
        $this->invoice_status = new InvoiceStatus($response);

        return $this->invoice_status;
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

    public function downloadReceiptXML()
    {
        return ApiResource::get("cfdi/{$this->uuid}/receipt-xml");
    }
}
