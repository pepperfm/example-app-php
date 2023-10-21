<?php

declare(strict_types=1);

namespace App\App;

class App
{
    protected static array $container = [];

    public static function bind(string $key, $val): void
    {
        static::$container[$key] = $val;
    }

    public static function get(string $key)
    {
        return static::$container[$key] ?? null;
    }
}
