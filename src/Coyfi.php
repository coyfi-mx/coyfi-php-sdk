<?php

namespace Coyfi;

class Coyfi
{
    private static $key;
    private static $secret;

    public static function setup($key, $secret)
    {
        self::$key = $key;
        self::$secret = $secret;
    }

    public static function isProduction()
    {
        return self::config('sdk.env') == 'production';
    }

    public static function getKey()
    {
        return self::$key;
    }

    public static function getSecret()
    {
        return self::$secret;
    }

    public static function config($key = null)
    {
        $names = explode('.', $key);
        $file_name = array_shift($names);
        $config = include __DIR__ . "/../config/{$file_name}.php";

        $config_value = $config;
        while ($config_key = array_shift($names)) {
            $config_value = $config_value[$config_key] ?? null;
        }

        return $config_value;
    }

    public static function env($key, $default = null)
    {
        $env = getenv($key);

        return $env === false ? $default : $env;
    }
}
