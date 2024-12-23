<?php

namespace Coyfi\Models;

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
        $items = self::query(['name' => $name, 'state_id' => $state->id]);

        return array_pop($items);
    }
}
