<?php

namespace Coyfi\Models;

use Coyfi\Builder;
use Coyfi\Model;

class Location extends Model
{
    protected static $table = 'locations';

    public $name;
    public $code;

    public static function find($name, $state, $zip_code): ?static
    {
        $table = static::$table;
        $zip_code = ZipCode::findByCode($zip_code);
        if ($zip_code->location_id) {
            if ($result = Builder::find("SELECT * FROM {$table} WHERE id={$zip_code->location_id} LIMIT 1;")) {
                return new static($result);
            }
        }
        $state = State::findByName($state);
        if ($result = Builder::find("SELECT * FROM {$table} WHERE name='{$name}' AND state_id={$state->id} LIMIT 1;")) {
            return new static($result);
        }

        return null;
    }
}
