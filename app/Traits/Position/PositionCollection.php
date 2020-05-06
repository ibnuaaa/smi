<?php

namespace App\Traits\Position;

/* Models */
use App\Models\Position;
use App\Models\User;

use DB;

trait PositionCollection
{



    public function __construct()
    {
        $this->PositionModel = Position::class;
        $this->PositionTable = getTable($this->PositionModel);

        $this->UserModel = User::class;
        $this->UserTable = getTable($this->UserModel);

    }

    public function GetPositionDetails($Positions)
    {
        $PositionID = $Positions->pluck('id');

        $Positions->map(function($Position) {
            return $Position;
        });
        return $Positions;
    }

    public function getSelection($data, $arr = []) {

        $item = $data;
        unset($item['parents']);
        $arr[] = $item;

        if ($data['parents']) return $this->getSelection($data['parents'], $arr);
        else return $arr ;
    }



}
