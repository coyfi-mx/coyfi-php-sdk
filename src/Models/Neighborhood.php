<?php

namespace Coyfi\Models;

use Coyfi\Model;

class Neighborhood extends Model
{
    protected static $table = 'neighborhoods';

    public $name;
    public $code;

    public static function find($name, $zip_code): ?static
    {
        $zip_code = ZipCode::findByCode($zip_code);
        $items = self::query(['name' => $name, 'zip_code_id' => $zip_code->id]);

        return array_pop($items);
    }
}
