<?php

namespace Coyfi\Nodes;

use Coyfi\CoyfiObject;

class Consignment extends CoyfiObject
{
    public $country;
    public $international;
    public array $locations;
    public array $goods;
    public InlandTransport $inland_transport;
    public array $transport_operators;
}
