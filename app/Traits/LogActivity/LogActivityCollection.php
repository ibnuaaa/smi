<?php

namespace App\Traits\LogActivity;

/* Models */
use App\Models\LogActivity;
use App\Models\User;

use DB;

trait LogActivityCollection
{
    public function __construct()
    {
        $this->LogActivityModel = LogActivity::class;
        $this->LogActivityTable = getTable($this->LogActivityModel);

        $this->UserModel = User::class;
        $this->UserTable = getTable($this->UserModel);
    }

    public function GetLogActivityDetails($LogActivitys)
    {
        $LogActivityID = $LogActivitys->pluck('id');

        $LogActivitys->map(function($LogActivity) {
            return $LogActivity;
        });
        return $LogActivitys;
    }

}
