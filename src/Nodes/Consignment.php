<?php

namespace Coyfi\Nodes;

use Coyfi\CoyfiObject;

class Consignment extends CoyfiObject
{
    public $country;
    public $international;
    public array $locations;
    public array $goods;
}
