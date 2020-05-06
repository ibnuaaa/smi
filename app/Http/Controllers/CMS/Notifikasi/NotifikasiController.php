<?php

namespace App\Http\Controllers\CMS\Notifikasi;

use App\Http\Controllers\Notification\NotificationBrowseController;
use App\Http\Controllers\Notification\NotificationController;


use Illuminate\Database\Eloquent\ModelNotFoundException;

use DB;
use Carbon\Carbon;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use App\Support\Response\Json;
use Illuminate\Support\Facades\Hash;
use App\Support\Generate\Hash as KeyGenerator;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;

class NotifikasiController extends Controller
{
    public function Home(Request $request)
    {

        $QueryRoute2 = QueryRoute($request);
        $NotificationController = new NotificationController($QueryRoute2);
        $NotificationController->ReadNotification($QueryRoute2);


        $TableKey = 'user-table';

        if (isset($request['user-table-show'])) {
            $selected = $request['user-table-show'];
        }
        else {
            $selected = 10;
        }
        $options = array(5,10,15,20);
        $Notification = NotificationBrowseController::FetchBrowse($request)
            ->where('with.total', 'true')
            ->middleware(function($fetch) use($request, $TableKey) {
                $fetch->equal('skip', ___TableGetSkip($request, $TableKey, $fetch->QueryRoute->ArrQuery->take));
                return $fetch;
            })
            ->get('fetch');

        if (isset($request['user-table-show'])) {
            $selected = $request['user-table-show'];
        }
        else {
            $selected = 10;
        }

        $Take = ___TableGetTake($request, $TableKey);
        $DataTable = [
            'key' => $TableKey,
            'pageNow' => ___TableGetCurrentPage($request, $TableKey),
            'paginate' => ___TablePaginate((int)$Notification['total'], (int)$Notification['query']->take, ___TableGetCurrentPage($request, $TableKey)),
            'selected' => $selected,
            'options' => $options,
            'heads' => [
                (object)['name' => 'TANGGAL', 'label' => 'TANGGAL'],
                (object)['name' => 'DESCRIPTION', 'label' => 'DESCRIPTION']            ],
            'records' => []
        ];

        if ($Notification['records']) {
            $DataTable['records'] = $Notification['records'];
            $DataTable['total'] = $Notification['total'];
            $DataTable['show'] = $Notification['show'];

            $DataTable['totalpage'] = (int)(ceil($DataTable['total'] / $selected)) ;
            $DataTable['startentries'] = (($DataTable['pageNow'] - 1 ) * $selected) + 1;
            $DataTable['endentries'] = $DataTable['startentries'] + ($selected - 1);
            if ($DataTable['endentries'] > $DataTable['total']){
                $DataTable['endentries'] = $DataTable['total'];
            }
            if ($DataTable['pageNow'] > $DataTable['totalpage']){
                $DataTable['pageNow'] = $DataTable['totalpage'];
            }
        }


        $ParseData = [
            'data' => $DataTable,
            'result_total' => isset($DataTable['total']) ? $DataTable['total'] : 0
        ];
        return view('app.notifikasi.home.index', $ParseData);
    }
}
