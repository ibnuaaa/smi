<?php

namespace App\Http\Controllers\Permission;

use App\Models\Permission;

use App\Traits\Browse;
use App\Http\Controllers\Permission\PermissionBrowseController;

use Illuminate\Http\Response;
use Illuminate\Http\Request;
use App\Support\Response\Json;
use App\Http\Controllers\Controller;

class PermissionController extends Controller
{
    use Browse;

    public function Insert(Request $request)
    {
        $Model = $request->Payload->all()['Model'];
        $Model->Permission->save();

        Json::set('data', $this->SyncData($request, $Model->Permission->id));
        return response()->json(Json::get(), 201);
    }

    public function Update(Request $request)
    {
        $Model = $request->Payload->all()['Model'];
        $Model->Permission->save();

        Json::set('data', $this->SyncData($request, $Model->Permission->id));
        return response()->json(Json::get(), 202);
    }

    public function Delete(Request $request)
    {
        $Model = $request->Payload->all()['Model'];
        $Model->Permission->delete();
        return response()->json(Json::get(), 202);
    }

    public function SyncData($request, $id)
    {
        $QueryRoute = QueryRoute($request);
        $QueryRoute->ArrQuery->set = 'first';
        $QueryRoute->ArrQuery->id = $id;
        $PermissionBrowseController = new PermissionBrowseController($QueryRoute);
        $data = $PermissionBrowseController->get($QueryRoute);
        return $data->original['data']['records'];
    }
}
