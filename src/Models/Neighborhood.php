<?php

namespace Coyfi\Models;

use Coyfi\Builder;
use Coyfi\Model;

class Neighborhood extends Model
{
    protected static $table = 'neighborhoods';

    public $name;
    public $code;

    public static function find($name, $zip_code): ?static
    {
        $zip_code = ZipCode::findByCode($zip_code);
        $table = static::$table;
        $result = Builder::find("SELECT * FROM {$table} WHERE name='{$name}' AND zip_code_id={$zip_code->id} LIMIT 1;");
        if ($result) {
            return new static($result);
        }

        return null;
    }
}
