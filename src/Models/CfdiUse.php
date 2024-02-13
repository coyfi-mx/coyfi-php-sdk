<?php

namespace Coyfi\Models;

use Coyfi\Model;

class CfdiUse extends Model
{
    protected static $table = 'cfdi_uses';

    public $id;
    public $name;
    public $code;
}
