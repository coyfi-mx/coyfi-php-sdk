<?php

namespace Coyfi\Cfdi\Nodes;

use Coyfi\Cfdi\CoyfiObject;

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
