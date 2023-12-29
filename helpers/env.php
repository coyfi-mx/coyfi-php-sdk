<?php

use Dotenv\Dotenv;

$parent_env = __DIR__ . '/../../.env';
$dotenv = Dotenv::createImmutable(file_exists($parent_env) ? $parent_env : __DIR__);
$dotenv->safeLoad();

if (! function_exists('env')) {
    /**
     * Gets the value of an environment variable.
     *
     * @param  string  $key
     * @param  mixed  $default
     * @return mixed
     */
    function env($key, $default = null)
    {
        $env = getenv($key);

        return $env === false ? $default : $env;
    }
}
