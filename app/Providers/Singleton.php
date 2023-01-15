<?php

namespace App\Providers;

use Exception;

class Singleton
{
    private static $instances = [];

    public static function getInstance(): Singleton
    {
        $cls = static::class;

        if (!isset(self::$instances[$cls])) {
            self::$instances[$cls] = new static();
        }

        return self::$instances[$cls];
    }
}
