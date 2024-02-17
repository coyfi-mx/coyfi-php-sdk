<?php

namespace Coyfi\Models;

use Coyfi\Model;

class PaymentMethod extends Model
{
    protected static $table = 'payment_methods';

    public $id;
    public $name;
    public $code;
}
