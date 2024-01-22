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
    public $state;
    public $city;
    public $location;
    public $neighborhoods;

    public static function query(array $attributes = [], $offset = 0, $limit = 50, $like = false): array
    {
        $zip_codes = parent::query($attributes, $offset, $limit, $like);

        return array_map(function ($zip_code) {
            $states = State::query(['id' => $zip_code->state_id]);
            $cities = City::query(['id' => $zip_code->city_id]);
            $locations = Location::query(['id' => $zip_code->location_id]);
            $neighborhoods = Neighborhood::query(['zip_code_id' => $zip_code->id]);
            $zip_code->state = array_pop($states);
            $zip_code->city = array_pop($cities);
            $zip_code->location = array_pop($locations);
            $zip_code->neighborhoods = $neighborhoods;

            return $zip_code;
        }, $zip_codes);
    }
}
