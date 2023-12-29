<?php

if (! function_exists('config')) {
    function config($key = null)
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
}
