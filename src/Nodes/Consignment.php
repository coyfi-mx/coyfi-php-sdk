<?php

namespace Coyfi\Cfdi\Nodes;

use Coyfi\Cfdi\CoyfiObject;

class Consignment extends CoyfiObject
{
    public $country;
    public $international;
    public array $locations;
    public array $goods;
}
