<?php

namespace App\Support\Log;

use DateTime;

class Model
{
    static $Json = [
        'timestamp' => NULL,
        'environment' => NULL,
        'data' => NULL
    ];

    public static function custom($JsonArray)
    {
        self::$Json = $JsonArray;
    }

    public static function Model($Model)
    {
        return $this;
    }
}
