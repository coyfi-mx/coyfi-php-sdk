<?php

namespace Coyfi\Models;

use Coyfi\Model;

class TransportOperatorType extends Model
{
    protected static $table = 'transport_operator_types';

    public $id;
    public $name;
    public $code;
    public $available_at;
    public $revoked_at;
}
