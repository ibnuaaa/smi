<?php

namespace App\Support;

Class Counter {
    public static $Instance;

    protected $Data;

    public static function Init()
    {
       if (static::$Instance == NULL) {
            static::$Instance = new self();
        }
        return static::$Instance;
    }

    public function InitAllCounter($Data)
    {
        $this->Data = $Data;
    }

    public static function getCount($Id)
    {
        // return '';
        return static::$Instance->Data[$Id];
    }
}
