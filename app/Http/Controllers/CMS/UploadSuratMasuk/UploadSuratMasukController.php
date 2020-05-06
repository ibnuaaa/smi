<?php

namespace App\Http\Controllers\CMS\UploadSuratMasuk;

use DB;
use Carbon\Carbon;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use App\Support\Response\Json;
use Illuminate\Support\Facades\Hash;
use App\Support\Generate\Hash as KeyGenerator;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;

use App\Http\Controllers\Position\PositionBrowseController;

use App\Http\Controllers\Mail\MailBrowseController;

class UploadSuratMasukController extends Controller
{
    public function Index(Request $request)
    {
        $PositionQueryRoute = QueryRoute($request);
        $PositionQueryRoute->ArrQuery->status = 'active';
        $PositionQueryRoute->ArrQuery->set = 'fetch';
        $PositionQueryRoute->ArrQuery->{'with.total'} = 'true';
        $PositionBrowseController = new PositionBrowseController($PositionQueryRoute);
        $PositionData = $PositionBrowseController->get($PositionQueryRoute);
        $PositionSelect = FormSelect($PositionData->original['data']['records'], true);




        // GETTING LIS UPLOAD SURAT MASUK
        $TableKey = 'mail';

        $filter_search = $request->input($TableKey . '-filter_search');

        if (isset($request['user-table-show'])) {
            $selected = $request['user-table-show'];
        }
        else {
            $selected = 10;
        }
        $options = array(5,10,15,20);
        $Mail = MailBrowseController::FetchBrowse($request)
            ->where('for', 'surat_keluar')
            ->where('mail_template_id', '9')
            ->where('with.total', 'true');

        if (isset($filter_search)) {
            $Mail = $Mail->where('search', $filter_search);
        }

        $Mail = $Mail->middleware(function($fetch) use($request, $TableKey) {
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
            'filter_search' => $filter_search,
            'placeholder_search' => "No Surat, Perihal, Isi Surat",
            'pageNow' => ___TableGetCurrentPage($request, $TableKey),
            'paginate' => ___TablePaginate((int)$Mail['total'], (int)$Mail['query']->take, ___TableGetCurrentPage($request, $TableKey)),
            'selected' => $selected,
            'options' => $options,
            'heads' => [
                (object)['name' => 'tanggal', 'label' => 'TANGGAL'],
                (object)['name' => 'no', 'label' => 'NO'],
                (object)['name' => 'kepada', 'label' => 'KEPADA'],
                (object)['name' => 'hal', 'label' => 'HAL'],
                (object)['name' => 'status', 'label' => 'STATUS'],
                (object)['name' => 'action', 'label' => 'ACTION']
            ],
            'records' => []
        ];

        if ($Mail['records']) {
            $DataTable['records'] = $Mail['records'];
            $DataTable['total'] = $Mail['total'];
            $DataTable['show'] = $Mail['show'];

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


        return view('app.upload_surat_masuk.home.index', [
            'id' => '',
            'select' => ['positions' => $PositionSelect],
            'data' => $DataTable,
            'result_total' => isset($DataTable['total']) ? $DataTable['total'] : 0
        ]);
    }


    public function Edit(Request $request, $id)
    {
        $PositionQueryRoute = QueryRoute($request);
        $PositionQueryRoute->ArrQuery->status = 'active';
        $PositionQueryRoute->ArrQuery->set = 'fetch';
        $PositionQueryRoute->ArrQuery->{'with.total'} = 'true';
        $PositionBrowseController = new PositionBrowseController($PositionQueryRoute);
        $PositionData = $PositionBrowseController->get($PositionQueryRoute);
        $PositionSelect = FormSelect($PositionData->original['data']['records'], true);


        $QueryRoute = QueryRoute($request);
        $QueryRoute->ArrQuery->id = $id;
        $QueryRoute->ArrQuery->set = 'first';
        $QueryRoute->ArrQuery->{'with.total'} = 'true';
        $MailBrowseController = new MailBrowseController($QueryRoute);
        $data = $MailBrowseController->get($QueryRoute);

        $Mail = MailBrowseController::FetchBrowse($request)
            ->where('id', $id)
            ->where('for', 'selection')
            ->get('first');

        return view('app.upload_surat_masuk.home.index', [
            'id' => $id,
            'select' => ['positions' => $PositionSelect],
            'data' => $Mail['records']
        ]);
    }

    public function New(Request $request)
    {
        return view('app.upload_surat_masuk.new.index');
    }

    public function Detail(Request $request)
    {
        return view('app.upload_surat_masuk.detail.index');
    }
}
