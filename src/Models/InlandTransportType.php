<?php

namespace Coyfi\Models;

use Coyfi\Model;

class InlandTransportType extends Model
{
    protected static $table = 'inland_transport_types';

    public $id;
    public $name;
    public $code;
    public $wheels;
    public $axles;
    public $trailer;
}
