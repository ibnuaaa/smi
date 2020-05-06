<?php

namespace App\Http\Controllers\LogActivity;

use App\Models\LogActivity;

use App\Traits\Browse;
use App\Traits\LogActivity\LogActivityCollection;

use Carbon\Carbon;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use App\Support\Response\Json;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;
use DB;

use Illuminate\Support\Facades\Auth;

class LogActivityBrowseController extends Controller
{
    use Browse, LogActivityCollection {
        LogActivityCollection::__construct as private __LogActivityCollectionConstruct;
    }

    protected $search = [
        'modul',
        'activity',
        'ip_client',
        'browser',
        'data'
    ];

    public function __construct(Request $request)
    {
        if ($request) {
            $this->_Request = $request;
        }
        $this->__LogActivityCollectionConstruct();
    }

    public function get(Request $request)
    {
        $LogActivity = LogActivity::where(function ($query) use($request) {
            if (isset($request->ArrQuery->id)) {
                $query->where("$this->LogActivityTable.id", $request->ArrQuery->id);
                $request->ArrQuery->set = 'first';
            }

            if (isset($request->ArrQuery->search)) {
               $search = '%' . $request->ArrQuery->search . '%';
               $query->where(function ($query) use($search) {
                   foreach ($this->search as $key => $value) {
                       $query->orWhere($value, 'like', $search);
                   }
               });
            }

            $query->whereIn("$this->LogActivityTable.activity", array('Insert','Update','Delete'));

        })
        ->select(
            // LogActivity
            "$this->LogActivityTable.id as log_activity.id",
            "$this->LogActivityTable.user_id as log_activity.user_id",
            "$this->LogActivityTable.modul as log_activity.modul",
            "$this->LogActivityTable.activity as log_activity.activity",
            "$this->LogActivityTable.ip_client as log_activity.ip_client",
            "$this->LogActivityTable.browser as log_activity.browser",
            "$this->LogActivityTable.data as log_activity.data",
            "$this->LogActivityTable.updated_at as log_activity.updated_at",
            "$this->LogActivityTable.created_at as log_activity.created_at"
            // "a.username as log_activity.username"
        );
        // ->leftJoin($this->UserTable . ' as a', "a.id", "$this->LogActivityTable.user_id");

        $LogActivity->orderBy("$this->LogActivityTable.id", 'DESC');

        $Browse = $this->Browse($request, $LogActivity, function ($data) use($request) {
            $data = $this->Manipulate($data);
            $data = $this->GetLogActivityDetails($data);

            return $data;
        });

        Json::set('data', $Browse);
        return response()->json(Json::get(), 200);
    }

    private function Manipulate($records)
    {
        return $records->map(function ($item) {
            foreach ($item->getAttributes() as $key => $value) {
                $this->Group($item, $key, 'log_activity.', $item);
            }
            return $item;
        });
    }
}
