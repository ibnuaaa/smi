<?php

namespace App\Http\Controllers\CMS\AuditTrail;

use App\Http\Controllers\LogActivity\LogActivityBrowseController;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Traits\Config;

use DB;
use Carbon\Carbon;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use App\Support\Response\Json;
use Illuminate\Support\Facades\Hash;
use App\Support\Generate\Hash as KeyGenerator;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Auth;

class AuditTrailController extends Controller
{
    use Config;

    public function Home(Request $request)
    {
        $TableKey = 'audit-trail-table';

        $filter_search = $request->input($TableKey . '-filter_search');

        if (isset($request['audit-trail-table-show'])) {
            $selected = $request['audit-trail-table-show'];
        }
        else {
            $selected = 10;
        }
        $options = array(5,10,15,20);
        $LogActivity = LogActivityBrowseController::FetchBrowse($request)
            ->where('orderBy.blast_audit-trails.created_at', 'desc')
            ->where('with.total', 'true');

        if (isset($filter_search)) {
            $LogActivity = $LogActivity->where('search', $filter_search);
        }

        $LogActivity = $LogActivity->middleware(function($fetch) use($request, $TableKey) {
                $fetch->equal('skip', ___TableGetSkip($request, $TableKey, $fetch->QueryRoute->ArrQuery->take));
                return $fetch;
            })
            ->get('fetch');

        $Take = ___TableGetTake($request, $TableKey);
        $DataTable = [
            'key' => $TableKey,
            'filter_search' => $filter_search,
            'placeholder_search' => "",
            'pageNow' => ___TableGetCurrentPage($request, $TableKey),
            'paginate' => ___TablePaginate((int)$LogActivity['total'], (int)$LogActivity['query']->take, ___TableGetCurrentPage($request, $TableKey)),
            'selected' => $selected,
            'options' => $options,
            'heads' => [
                (object)['name' => 'Waktu', 'label' => 'Waktu'],
                (object)['name' => 'ID', 'label' => 'ID'],
                (object)['name' => 'Modul', 'label' => 'Modul'],
                (object)['name' => 'Aktifitas', 'label' => 'Aktifitas'],
                (object)['name' => 'IP', 'label' => 'Alamat IP'],
                (object)['name' => 'Browser', 'label' => 'Browser'],
            ],
            'records' => []
        ];

        if ($LogActivity['records']) {
            $DataTable['records'] = $LogActivity['records'];
            $DataTable['total'] = $LogActivity['total'];
            $DataTable['show'] = $LogActivity['show'];
        }

        $Config = $this->Config();

        $ParseData = [
            'data' => $DataTable,
            'result_total' => isset($DataTable['total']) ? $DataTable['total'] : 0,
            'config' => $Config
        ];
        return view('app.audit_trail.home.index', $ParseData);
    }

    public function X(Request $request){
        return view('app.audit_trail.x.index');
    }


    public function LogData(Request $request, $id){

        $LogActivity = LogActivityBrowseController::FetchBrowse($request)
            ->where('id', $id)
            ->get('first');

        $data = $LogActivity['records']->data;

        if($data) cetak(json_decode($data));

        die();

    }
}
