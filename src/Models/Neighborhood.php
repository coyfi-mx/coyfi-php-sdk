<?php

namespace Coyfi\Models;

use Coyfi\Model;

class Neighborhood extends Model
{
    protected static $table = 'neighborhoods';

    public $name;
    public $code;
}
