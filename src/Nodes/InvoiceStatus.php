<?php

namespace Coyfi\Nodes;

use Coyfi\CoyfiObject;

class InvoiceStatus extends CoyfiObject
{
    public $invoice_issuer_rfc;
    public $invoice_receiver_rfc;
    public $total;
    public $efos_validation_details;
    public $efos_validation;
    public $cancellable;
    public $status_code;
    public $status;
    public $authorized_certification_provider_id;
    public $updated_at;
    public $created_at;

}
