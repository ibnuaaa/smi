<?php

namespace App\Http\Controllers\MailNumberClassification;

use App\Models\MailNumberClassification;

use App\Traits\Browse;
use App\Traits\MailNumberClassification\MailNumberClassificationCollection;

use Carbon\Carbon;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use App\Support\Response\Json;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Auth;

use DB;

class MailNumberClassificationBrowseController extends Controller
{
    use Browse, MailNumberClassificationCollection {
        MailNumberClassificationCollection::__construct as private __MailNumberClassificationCollectionConstruct;
    }

    protected $search = [
        'code',
        'name'
    ];

    public function __construct(Request $request)
    {
        if ($request) {
            $this->_Request = $request;
        }
        $this->__MailNumberClassificationCollectionConstruct();
    }

    public function get(Request $request)
    {
        $Now = Carbon::now();
        if (!isset($request->OriginalArrQuery->take)) {
            $request->ArrQuery->take = 5000;
        }

        $MailNumberClassification = MailNumberClassification::where(function ($query) use($request) {
            if (isset($request->ArrQuery->id)) {
                $query->where("$this->MailNumberClassificationTable.id", $request->ArrQuery->id);
            }

            if (isset($request->ArrQuery->code)) {
                $query->where("$this->MailNumberClassificationTable.code", $request->ArrQuery->code);
            }

            if (!empty($request->get('q'))) {
                $query->where(function ($query) use($request) {
                    $query->where("$this->MailNumberClassificationTable.code", 'like', '%'.$request->get('q').'%');
                    $query->orWhere("$this->MailNumberClassificationTable.name", 'like', '%'.$request->get('q').'%');
                });
            }

            if (!empty($request->ArrQuery->search)) {
                $query->where(function ($query) use($request) {
                    $query->where("$this->MailNumberClassificationTable.code", 'like', '%'.$request->ArrQuery->search.'%');
                    $query->orWhere("$this->MailNumberClassificationTable.name", 'like', '%'.$request->ArrQuery->search.'%');
                });
            }
        })
        ->select(
            // MailNumberClassification
            "$this->MailNumberClassificationTable.id as information.id",
            "$this->MailNumberClassificationTable.code as information.code",
            "$this->MailNumberClassificationTable.name as information.name",
            DB::raw("concat('[' , code , '] ' , name) as code_name")
        );

       $Browse = $this->Browse($request, $MailNumberClassification, function ($data) use($request) {
            if (isset($request->ArrQuery->for) && ($request->ArrQuery->for === 'select')) {
                return $data->map(function($MailNumberClassification) {
                    return [ 'value' => $MailNumberClassification->id, 'label' => $MailNumberClassification->name .  " (" . $MailNumberClassification->name . ")" ];
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
