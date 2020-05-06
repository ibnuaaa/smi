<?php

namespace App\Traits\Log;

/* Models */
use App\Models\Log;

use DB;

trait LogCollection
{
    public function __construct()
    {
        $this->LogModel = Log::class;
        $this->LogTable = getTable($this->LogModel);
    }

    public function GetLogDetails($Logs)
    {
        $LogID = $Logs->pluck('id');

        $Logs->map(function($Log) {
            return $Log;
        });
        return $Logs;
    }

}
