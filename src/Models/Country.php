<?php

namespace Coyfi\Models;

use Coyfi\Model;

class Country extends Model
{
    protected static $table = 'countries';

    public $name;
    public $code;
}
