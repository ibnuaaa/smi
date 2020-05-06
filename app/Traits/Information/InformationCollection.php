<?php

namespace App\Traits\Information;

/* Models */
use App\Models\Information;

use DB;

trait InformationCollection
{
    public function __construct()
    {
        $this->InformationModel = Information::class;
        $this->InformationTable = getTable($this->InformationModel);
    }

    public function GetInformationDetails($Informations)
    {
        $InformationID = $Informations->pluck('id');

        $Informations->map(function($Information) {
            return $Information;
        });
        return $Informations;
    }

}
