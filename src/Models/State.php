<?php

namespace Coyfi\Models;

use Coyfi\Model;

class State extends Model
{
    protected static $table = 'states';

    public $id;
    public $name;
    public $code;
    public $country_id;
    public $available_at;
    public $revoked_at;
}
