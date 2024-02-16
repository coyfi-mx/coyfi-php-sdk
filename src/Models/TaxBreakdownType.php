<?php

namespace Coyfi\Models;

use Coyfi\Model;

class TaxBreakdownType extends Model
{
    protected static $table = 'tax_breakdown_types';

    public $id;
    public $name;
    public $code;
}
