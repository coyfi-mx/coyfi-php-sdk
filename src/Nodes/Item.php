<?php

namespace Coyfi\Nodes;

use Coyfi\CoyfiObject;

class Item extends CoyfiObject
{
    public $code;
    public $description;
    public $unit_price;
    public $subtotal;
    public $unit;
    public $quantity;
    public $tax_breakdown;
    public array $taxes;
}
