<?php

namespace Coyfi\Nodes;

use Coyfi\CoyfiObject;

class Location extends CoyfiObject
{
    public $type;
    public $rfc;
    public $name;
    public $date;
    public $distance;
    public array $addresses;
}
