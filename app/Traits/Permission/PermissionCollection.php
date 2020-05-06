<?php

namespace App\Traits\Permission;

/* Models */
use App\Models\Permission;
use App\Models\PositionPermission;

use DB;

trait PermissionCollection
{
    public function __construct()
    {
        $this->PermissionModel = Permission::class;
        $this->PermissionTable = getTable($this->PermissionModel);
    }

    public function GetPermissionDetails($Permissions)
    {
        $PermissionID = $Permissions->pluck('id');


        if ($this->_Request->ArrQuery->position_id) {
          $PositionPermissions = PositionPermission::where('position_id', $this->_Request->ArrQuery->position_id)->get();
          $this->PermissionIds = [];
          foreach ($PositionPermissions->pluck('permission_id') as $key => $value) {
            $this->PermissionIds[$value] = true;
          }
        }
        $Permissions->map(function($Permission) {
            if ($this->_Request->ArrQuery->position_id) {
              if (isset($this->PermissionIds[$Permission->id])) {
                $Permission->checked = true;
              } else {
                $Permission->checked = false;
              }
            }
            return $Permission;
        });
        return $Permissions;
    }

}
