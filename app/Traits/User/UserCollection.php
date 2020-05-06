<?php

namespace App\Traits\User;

/* Models */
use App\Models\User;
use App\Models\Position;
use App\Models\PositionsDefault;
use App\Models\PositionsFromApi;
use App\Models\UsersFromApi;

use DB;

trait UserCollection
{
    public function __construct()
    {
        $this->UserModel = User::class;
        $this->UserTable = getTable($this->UserModel);

        $this->PositionModel = Position::class;
        $this->PositionTable = getTable($this->PositionModel);

        $this->PositionsDefaultModel = PositionsDefault::class;
        $this->PositionsDefaultTable = getTable($this->PositionsDefaultModel);

        $this->PositionsFromApiModel = PositionsFromApi::class;
        $this->PositionsFromApiTable = getTable($this->PositionsFromApiModel);

        $this->UsersFromApiModel = UsersFromApi::class;
        $this->UsersFromApiTable = getTable($this->UsersFromApiModel);

    }

    public function GetUserDetails($Users)
    {
        $UserID = $Users->pluck('id');

        $Users->map(function($User) {
            return $User;
        });
        return $Users;
    }

}
