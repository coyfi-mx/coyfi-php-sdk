<?php

namespace Coyfi\Models;

use Coyfi\Model;

class PaymentForm extends Model
{
    protected static $table = 'payment_forms';

    public $id;
    public $name;
    public $code;
}
