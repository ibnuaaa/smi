<?php

namespace App\Http\Controllers\ConfigNumbering;

use App\Models\ConfigNumbering;

use App\Traits\Browse;
use App\Traits\ConfigNumbering\ConfigNumberingCollection;

use Carbon\Carbon;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use App\Support\Response\Json;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Auth;

class ConfigNumberingBrowseController extends Controller
{
    use Browse, ConfigNumberingCollection {
        ConfigNumberingCollection::__construct as private __ConfigNumberingCollectionConstruct;
    }

    protected $search = [
        'type'
    ];

    public function __construct(Request $request)
    {
        if ($request) {
            $this->_Request = $request;
        }
        $this->__ConfigNumberingCollectionConstruct();
    }

    public function get(Request $request)
    {
        $Now = Carbon::now();
        if (!isset($request->OriginalArrQuery->take)) {
            $request->ArrQuery->take = 5000;
        }

        $ConfigNumbering = ConfigNumbering::where(function ($query) use($request) {
            if (isset($request->ArrQuery->id)) {
                $query->where("$this->ConfigNumberingTable.id", $request->ArrQuery->id);
            }
        })
        ->select(
            // ConfigNumbering
            "$this->ConfigNumberingTable.id as config_numbering.id",
            "$this->ConfigNumberingTable.type as config_numbering.type",
            "$this->ConfigNumberingTable.length as config_numbering.length",
            "$this->ConfigNumberingTable.last_value as config_numbering.last_value",
            "$this->ConfigNumberingTable.description as config_numbering.description"
        );

       $Browse = $this->Browse($request, $ConfigNumbering, function ($data) use($request) {
           $data = $this->Manipulate($data);
           return $data;
       });
       Json::set('data', $Browse);
       return response()->json(Json::get(), 200);
    }

    private function Manipulate($records)
    {
        return $records->map(function ($item) {
            foreach ($item->getAttributes() as $key => $value) {
                $this->Group($item, $key, 'config_numbering.', $item);
            }
            return $item;
        });
    }
}
