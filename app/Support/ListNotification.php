<?php

namespace App\Support;

Class ListNotification {
    public static $Instance;

    protected $Data;

    public static function Init()
    {
       if (static::$Instance == NULL) {
            static::$Instance = new self();
        }
        return static::$Instance;
    }

    public function InitAllNotification($Data)
    {
        $this->Data = $Data;
    }

    public static function getListNotification($notifications)
    {
        return $notifications;
    }
}
