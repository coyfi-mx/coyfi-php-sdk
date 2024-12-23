<?php

namespace Coyfi\Models;

use Coyfi\Model;

class TransportLicenseType extends Model
{
    protected static $table = 'transport_license_types';

    public $id;
    public $name;
    public $code;
    public $available_at;
    public $revoked_at;
}
