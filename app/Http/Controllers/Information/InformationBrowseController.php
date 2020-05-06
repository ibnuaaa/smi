<?php

namespace App\Http\Controllers\Information;

use App\Models\Information;

use App\Traits\Browse;
use App\Traits\Information\InformationCollection;

use Carbon\Carbon;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use App\Support\Response\Json;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Auth;

class InformationBrowseController extends Controller
{
    use Browse, InformationCollection {
        InformationCollection::__construct as private __InformationCollectionConstruct;
    }

    protected $search = [
        'title',
        'content'
    ];

    public function __construct(Request $request)
    {
        if ($request) {
            $this->_Request = $request;
        }
        $this->__InformationCollectionConstruct();
    }

    public function get(Request $request)
    {
        $Now = Carbon::now();
        if (!isset($request->OriginalArrQuery->take)) {
            $request->ArrQuery->take = 5000;
        }

        $Information = Information::where(function ($query) use($request) {
            if (isset($request->ArrQuery->id)) {
                $query->where("$this->InformationTable.id", $request->ArrQuery->id);
            }
       })
       ->select(
            // Information
            "$this->InformationTable.id as information.id",
            "$this->InformationTable.title as information.title",
            "$this->InformationTable.content as information.content"
       );

       $Browse = $this->Browse($request, $Information, function ($data) use($request) {
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
                $this->Group($item, $key, 'information.', $item);
            }
            return $item;
        });
    }
}
