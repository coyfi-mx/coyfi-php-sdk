<?php

namespace Coyfi\Models;

use Coyfi\Model;

class CfdiType extends Model
{
    protected static $table = 'cfdi_types';

    public $id;
    public $name;
    public $code;
}
