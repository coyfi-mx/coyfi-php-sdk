<?php

namespace Coyfi\Models;

use Coyfi\Model;

class PersonType extends Model
{
    protected static $table = 'person_types';

    public $id;
    public $name;
    public $code;
}
