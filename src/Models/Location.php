<?php

namespace Coyfi\Models;

use Coyfi\Model;

class Location extends Model
{
    protected static $table = 'locations';

    public $name;
    public $code;

    public static function find($name, $state, $zip_code): ?static
    {
        $zip_code = ZipCode::findByCode($zip_code);
        if ($zip_code->location_id) {
            $items = self::query(['id' => $zip_code->location_id]);
            if ($result = array_pop($items)) {
                return $result;
            }
        }
        $state = State::findByName($state);
        $items = self::query(['name' => $name, 'state_id' => $state->id]);
        if ($result = array_pop($items)) {
            return $result;
        }

        return null;
    }
}
