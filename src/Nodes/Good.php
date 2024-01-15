<?php

namespace Coyfi\Nodes;

use Coyfi\CoyfiObject;

class Good extends CoyfiObject
{
    public $code;
    public $description;
    public $quantity;
    public $unit;
    public $dimensions;
    public $dangerous;
    public $packaging;
    public $weight;
}
