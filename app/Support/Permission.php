<?php
namespace App\Support;

Class Permission {
    public static $Instance;
    protected $Data;
    public static function Init()
    {
       if (static::$Instance == NULL) {
            static::$Instance = new self();
        }
        return static::$Instance;
    }
    public function InitAllPermission($Data)
    {
        $this->Data = collect($Data)->keyBy('name');
    }

    public static function getPermissions($key = null)
    {
        if ($key) {
            if(!empty(static::$Instance->Data[$key])) return static::$Instance->Data[$key];
            else return false;
        }
        return static::$Instance->Data;
    }
}
