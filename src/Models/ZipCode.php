<?php

namespace Coyfi\Models;

use Coyfi\Model;

class ZipCode extends Model
{
    protected static $table = 'zip_codes';

    public $id;
    public $code;
    public $state_id;
    public $city_id;
    public $location_id;
    public $border_fiscal_stimulus;
    public $time_zone_description;
    public $available_at;
    public $revoked_at;
}
