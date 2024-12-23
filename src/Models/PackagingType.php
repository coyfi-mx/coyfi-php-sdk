<?php

namespace Coyfi\Models;

use Coyfi\Model;

class PackagingType extends Model
{
    protected static $table = 'packaging_types';

    public $id;
    public $name;
    public $code;
}
