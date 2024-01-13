<?php

namespace Coyfi;

class Model extends CoyfiObject
{
    protected static $table;

    /**
     * @return static[]
     */
    public static function all(): array
    {
        $table = static::$table;

        return array_map(fn ($row) => new static($row), Builder::select("SELECT * FROM {$table};"));
    }

    public static function findByCode($code): ?static
    {
        return self::findByColumn('code', $code);
    }

    public static function findByName($name): ?static
    {
        return self::findByColumn('name', $name);
    }

    protected static function findByColumn($column, $value): ?static
    {
        $table = static::$table;
        $result = Builder::find("SELECT * FROM {$table} WHERE {$column}='{$value}' LIMIT 1;");
        if ($result) {
            return new static($result);
        }

        return null;
    }
}
