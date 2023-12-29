<?php

namespace Coyfi\Cfdi;

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
        return config('sdk.env') == 'production';
    }

    public static function getKey()
    {
        return self::$key;
    }

    public static function getSecret()
    {
        return self::$secret;
    }
}
