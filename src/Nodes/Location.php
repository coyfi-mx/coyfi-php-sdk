<?php

namespace Coyfi\Cfdi\Nodes;

use Coyfi\Cfdi\CoyfiObject;

class Location extends CoyfiObject
{
    public $type;
    public $rfc;
    public $name;
    public $date;
    public $distance;
    public array $addresses;
}
