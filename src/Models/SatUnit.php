<?php

namespace Coyfi\Models;

use Coyfi\Model;

class SatUnit extends Model
{
    protected static $table = 'sat_units';

    public $id;
    public $unit_key;
    public $description;
}
