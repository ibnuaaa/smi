<?php

namespace App\Traits\ConfigNumbering;

/* Models */
use App\Models\ConfigNumbering;

use DB;

trait ConfigNumberingCollection
{
    public function __construct()
    {
        $this->ConfigNumberingModel = ConfigNumbering::class;
        $this->ConfigNumberingTable = getTable($this->ConfigNumberingModel);
    }

    public function GetConfigNumberingDetails($ConfigNumberings)
    {
        $ConfigNumberingID = $ConfigNumberings->pluck('id');

        $ConfigNumberings->map(function($ConfigNumbering) {
            return $ConfigNumbering;
        });
        return $ConfigNumberings;
    }

}
