<?php

namespace Coyfi\Nodes;

use Coyfi\CoyfiObject;

class PaymentRelatedDocument extends CoyfiObject
{
    public $amount;
    public $uuid;
    public $payment_form;
    public $remaining;
    public $payment_number;
    public $tax_breakdown;
    public array $taxes;
}
