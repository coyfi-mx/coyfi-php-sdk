<?php

namespace Coyfi\Models;

use Coyfi\Builder;
use Coyfi\Model;

class City extends Model
{
    protected static $table = 'cities';

    public $id;
    public $name;
    public $code;
    public $state_id;
    public $available_at;
    public $revoked_at;

    public static function find($name, $state): ?static
    {
        $state = State::findByName($state);
        $table = static::$table;
        $result = Builder::find("SELECT * FROM {$table} WHERE name='{$name}' AND state_id={$state->id} LIMIT 1;");
        if ($result) {
            return new static($result);
        }

        return null;
    }
}
