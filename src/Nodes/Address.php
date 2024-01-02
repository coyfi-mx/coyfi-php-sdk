<?php

namespace Coyfi\Nodes;

use Coyfi\CoyfiObject;

class Address extends CoyfiObject
{
    public $street;
    public $street_number;
    public $suite_number;
    public $zip_code;
    public $neighborhood;
    public $locality;
    public $reference;
    public $city;
    public $state;
    public $country;
}
