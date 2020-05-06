<?php

namespace App\Http\Controllers\Permission;

use App\Models\Permission;

use App\Traits\Browse;
use App\Traits\Permission\PermissionCollection;

use Carbon\Carbon;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use App\Support\Response\Json;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;

class PermissionBrowseController extends Controller
{
    use Browse, PermissionCollection {
        PermissionCollection::__construct as private __PermissionCollectionConstruct;
    }

    protected $search = [];

    public function __construct(Request $request)
    {
        if ($request) {
            $this->_Request = $request;
        }
        $this->__PermissionCollectionConstruct();
    }

    public function get(Request $request)
    {
        $Now = Carbon::now();

        $Permission = Permission::where(function ($query) use($request) {
            if (isset($request->ArrQuery->id)) {
                $query->where("$this->PermissionTable.id", $request->ArrQuery->id);
            }
            if (isset($request->ArrQuery->search)) {
                $query->where("$this->PermissionTable.name", 'like', '%'.$request->ArrQuery->search.'%');
            }
       })
       ->select(
            // Permission
            "$this->PermissionTable.id as position.id",
            "$this->PermissionTable.name as position.name",
            "$this->PermissionTable.label as position.label",
            "$this->PermissionTable.updated_at as position.updated_at",
            "$this->PermissionTable.created_at as position.created_at",
            "$this->PermissionTable.deleted_at as position.deleted_at"
       );

       $Browse = $this->Browse($request, $Permission, function ($data) use($request) {
           $data = $this->Manipulate($data);
           if (isset($request->ArrQuery->for) && ($request->ArrQuery->for === 'select')) {
               return $data->map(function($Permission) {
                   return [ 'value' => $Permission->id, 'label' => $Permission->name ];
               });
           } else {
               $data = $this->GetPermissionDetails($data);
           }
           return $data;
       });
       Json::set('data', $Browse);
       return response()->json(Json::get(), 200);
    }

    private function Manipulate($records)
    {
        return $records->map(function ($item) {
            foreach ($item->getAttributes() as $key => $value) {
                $this->Group($item, $key, 'position.', $item);
            }
            return $item;
        });
    }
}
