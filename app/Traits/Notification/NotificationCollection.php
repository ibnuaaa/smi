<?php

namespace App\Traits\Notification;

/* Models */
use App\Models\Notification;
use App\Models\NotificationUser;

use DB;

trait NotificationCollection
{
    public function __construct()
    {
        $this->NotificationModel = Notification::class;
        $this->NotificationTable = getTable($this->NotificationModel);

        $this->NotificationUserModel = NotificationUser::class;
        $this->NotificationUserTable = getTable($this->NotificationUserModel);
    }

    public function GetNotificationDetails($Notifications)
    {
        $NotificationID = $Notifications->pluck('id');

        $Notifications->map(function($Notification) {
            return $Notification;
        });
        return $Notifications;
    }

}
