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
    public $cities;
    public $locations;

    public static function query(array $attributes = [], $offset = 0, $limit = 50): array
    {
        $states = parent::query($attributes, $offset, $limit);

        return array_map(function ($state) {
            $state->cities = City::query(['state_id' => $state->id]);
            $state->locations = Location::query(['state_id' => $state->id]);

            return $state;
        }, $states);
    }
}
