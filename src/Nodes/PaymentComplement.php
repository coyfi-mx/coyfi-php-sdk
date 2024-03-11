<?php

namespace Coyfi\Nodes;

use Coyfi\CoyfiObject;

class PaymentComplement extends CoyfiObject
{
    public $payment_date;
    public $payment_form;
    public $currency;
    public $exchange_rate;
    public $transaction_number;
    public $payer_account_rfc;
    public $payer_bank_name;
    public $payer_account_number;
    public $beneficiary_account_rfc;
    public $beneficiary_account_number;
    /**
     * @var array<PaymentRelatedDocument>
     */
    public array $related;
}
