<?php

namespace Coyfi\Nodes;

use Coyfi\CoyfiObject;

class CancellationStatus extends CoyfiObject
{
    public $status;
    public $cancellation_status;
    public $total;
    public $invoice_issuer_rfc;
    public $reason;
    public $replacement_invoice_number;
    public $authorized_certification_provider_id;
    public $updated_at;
    public $created_at;
}
