<?php

namespace Coyfi\Models;

use Coyfi\Model;

class TaxRegime extends Model
{
    protected static $table = 'tax_regimes';

    public $id;
    public $name;
    public $code;
}
