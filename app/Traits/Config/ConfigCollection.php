<?php

namespace App\Traits\Config;

/* Models */
use App\Models\Config;

use DB;

trait ConfigCollection
{
    public function __construct()
    {
        $this->ConfigModel = Config::class;
        $this->ConfigTable = getTable($this->ConfigModel);
    }

    public function GetConfigDetails($Configs)
    {
        $ConfigID = $Configs->pluck('id');

        $Configs->map(function($Config) {
            return $Config;
        });
        return $Configs;
    }

}
