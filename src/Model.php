<?php

namespace Coyfi;

class Model extends CoyfiObject
{
    protected static $table;

    public static function findByCode($code): ?static
    {
        $items = self::query(['code' => $code]);

        return array_pop($items);
    }

    public static function findByName($name): ?static
    {
        $items = self::query(['name' => $name]);

        return array_pop($items);
    }

    /**
     * @return static[]
     */
    public static function query(array $attributes = [], $offset = 0, $limit = 50): array
    {
        $table = static::$table;
        $conditions = array_map(function ($key) use ($attributes) {
            return "{$key}='{$attributes[$key]}'";
        }, array_keys($attributes));

        if (count($conditions)) {
            $conditions = 'WHERE ' . implode(' AND ', $conditions);
        } else {
            $conditions = '';
        }

        return array_map(fn ($row) => new static($row), Builder::select("SELECT * FROM {$table} {$conditions} LIMIT {$limit} OFFSET {$offset};"));
    }
}
