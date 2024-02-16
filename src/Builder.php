<?php

namespace Coyfi;

use Exception;
use SQLite3;
use ZipArchive;

class Builder
{
    public static function select(string $query): array
    {
        $rows = [];
        try {
            $connection = static::getConnection();
            $result = $connection->query($query);
            while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
                $rows[] = $row;
            }
        } finally {
            if (isset($connection)) {
                $connection->close();
            }
        }

        return $rows;
    }

    public static function find(string $query): ?array
    {
        try {
            $connection = static::getConnection();
            $result = $connection->query($query);
            $row = $result->fetchArray(SQLITE3_ASSOC);

        } finally {
            if (isset($connection)) {
                $connection->close();
            }
        }
        if ($row === false) {
            return null;
        }

        return $row;
    }

    private static function getConnection(): SQLite3
    {
        $extensions = get_loaded_extensions();
        if (array_search('zip', $extensions) === false || array_search('sqlite3', $extensions) === false) {
            throw new Exception('Extensions zip and sqlite3 must be enabled');
        }
        $database_path = sys_get_temp_dir() . '/coyfi.db';
        if (! file_exists($database_path)) {
            $zip = new ZipArchive;
            $zip->open(Coyfi::config('sdk.path') . 'database/coyfi.zip');
            $zip->extractTo(sys_get_temp_dir());
            $zip->close();
        }

        return new SQLite3($database_path);

    }
}
