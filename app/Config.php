<?php

namespace App;

class Config
{
    protected static $items = [];

    public static function load($file)
    {
        if (file_exists($file)) {
            static::$items = require $file;
        }
    }

    public static function get($key, $default = null)
    {
        $segments = explode('.', $key);
        $value = static::$items;
        foreach ($segments as $segment) {
            if (is_array($value) && array_key_exists($segment, $value)) {
                $value = $value[$segment];
            } else {
                return $default;
            }
        }
        return $value;
    }

    public static function env($key, $default = null)
    {
        return $_ENV[$key] ?? getenv($key) ?: $default;
    }
}
