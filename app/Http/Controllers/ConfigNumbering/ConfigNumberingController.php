<?php

namespace App\Http\Controllers\ConfigNumbering;

use App\Models\ConfigNumbering;

use App\Traits\Browse;

use Illuminate\Http\Response;
use Illuminate\Http\Request;
use App\Support\Response\Json;
use Illuminate\Support\Facades\Hash;
use App\Support\Generate\Hash as KeyGenerator;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;

class ConfigNumberingController extends Controller
{
    use Browse;

    protected $search = [
        'id',
        'type'
    ];
    public function get(Request $request)
    {
        $ConfigNumbering = ConfigNumbering::where(function ($query) use($request) {
            if (isset($request->ArrQuery->id)) {
                $query->where('id', $request->ArrQuery->id);
            }
            if (isset($request->ArrQuery->search)) {
                $search = '%' . $request->ArrQuery->search . '%';
                $query->where(function ($query) use($search) {
                    foreach ($this->search as $key => $value) {
                        $query->orWhere($value, 'like', $search);
                    }
                });
            }
        });
        $Browse = $this->Browse($request, $ConfigNumbering, function ($data) use($request) {
            return $data;
        });
        Json::set('data', $Browse);
        return response()->json(Json::get(), 200);
    }

    public function Insert(Request $request)
    {
        $Model = $request->Payload->all()['Model'];
        $Model->ConfigNumbering->save();

        Json::set('data', $this->SyncData($request, $Model->ConfigNumbering->id));
        return response()->json(Json::get(), 201);
    }

    public function Update(Request $request)
    {
        $Model = $request->Payload->all()['Model'];
        $Model->ConfigNumbering->save();

        Json::set('data', $this->SyncData($request, $Model->ConfigNumbering->id));
        return response()->json(Json::get(), 202);
    }

    public function Delete(Request $request)
    {
        $Model = $request->Payload->all()['Model'];
        $Model->ConfigNumbering->delete();
        return response()->json(Json::get(), 202);
    }

    public function SyncData($request, $id)
    {
        $QueryRoute = QueryRoute($request);
        $QueryRoute->ArrQuery->set = 'first';
        $QueryRoute->ArrQuery->id = $id;
        $data = $this->get($QueryRoute);
        return $data->original['data']['records'];
    }
}
