<?php

namespace App\Http\Controllers\Config;

use App\Models\Config;

use App\Traits\Browse;
use App\Traits\Config\ConfigCollection;

use Carbon\Carbon;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use App\Support\Response\Json;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Auth;

use DB;

class ConfigBrowseController extends Controller
{
    use Browse, ConfigCollection {
        ConfigCollection::__construct as private __ConfigCollectionConstruct;
    }

    protected $search = [
        'key',
        'value'
    ];

    public function __construct(Request $request)
    {
        if ($request) {
            $this->_Request = $request;
        }
        $this->__ConfigCollectionConstruct();
    }

    public function get(Request $request)
    {
        $Now = Carbon::now();
        if (!isset($request->OriginalArrQuery->take)) {
            $request->ArrQuery->take = 5000;
        }

        $Config = Config::where(function ($query) use($request) {
            if (isset($request->ArrQuery->id)) {
                $query->where("$this->ConfigTable.id", $request->ArrQuery->id);
            }

            if (isset($request->ArrQuery->key)) {
                $query->where("$this->ConfigTable.key", $request->ArrQuery->key);
            }

            if (!empty($request->get('q'))) {
                $query->where(function ($query) use($request) {
                    $query->where("$this->ConfigTable.key", 'like', '%'.$request->get('q').'%');
                    $query->orWhere("$this->ConfigTable.value", 'like', '%'.$request->get('q').'%');
                });
            }

            if (!empty($request->ArrQuery->search)) {
                $query->where(function ($query) use($request) {
                    $query->where("$this->ConfigTable.key", 'like', '%'.$request->ArrQuery->search.'%');
                    $query->orWhere("$this->ConfigTable.value", 'like', '%'.$request->ArrQuery->search.'%');
                });
            }
        })
        ->select(
            // Config
            "$this->ConfigTable.id as information.id",
            "$this->ConfigTable.key as information.key",
            "$this->ConfigTable.value as information.value"
        );

       $Browse = $this->Browse($request, $Config, function ($data) use($request) {
            if (isset($request->ArrQuery->for) && ($request->ArrQuery->for === 'select')) {
                return $data->map(function($Config) {
                    return [ 'value' => $Config->id, 'label' => $Config->value .  " (" . $Config->value . ")" ];
                });
            } else {
                $data = $this->Manipulate($data);
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
                $this->Group($item, $key, 'information.', $item);
            }
            return $item;
        });
    }
}
