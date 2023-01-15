<?php

namespace App\Providers;

use Exception;

class Singleton
{
    private static $instances = [];

    public static function getInstance(): Singleton
    {
        $class = static::class;

        if (!isset(self::$instances[$class])) {
            self::$instances[$class] = new static();
        }

        return self::$instances[$class];
    }
}
