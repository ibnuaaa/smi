<?php

namespace App\Http\Controllers\CMS\ConfigNumbering;

use App\Http\Controllers\ConfigNumbering\ConfigNumberingBrowseController;

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

use Illuminate\Support\Facades\Auth;

class ConfigNumberingController extends Controller
{
    public function Home(Request $request)
    {
        $TableKey = 'config_numbering-table';

        $filter_search = $request->input($TableKey . '-filter_search');

        if (isset($request['config_numbering-table-show'])) {
            $selected = $request['config_numbering-table-show'];
        }
        else {
            $selected = 10;
        }
        $options = array(5,10,15,20);
        $ConfigNumbering = ConfigNumberingBrowseController::FetchBrowse($request)
            ->where('with.total', 'true');

        if (isset($filter_search)) {
            $ConfigNumbering = $ConfigNumbering->where('search', $filter_search);
        }

        $ConfigNumbering = $ConfigNumbering->middleware(function($fetch) use($request, $TableKey) {
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
            'paginate' => ___TablePaginate((int)$ConfigNumbering['total'], (int)$ConfigNumbering['query']->take, ___TableGetCurrentPage($request, $TableKey)),
            'selected' => $selected,
            'options' => $options,
            'heads' => [
                (object)['name' => 'id', 'label' => 'ID'],
                (object)['name' => 'type', 'label' => 'Type'],
                (object)['name' => 'length', 'label' => 'Panjang Karakter'],
                (object)['name' => 'last_value', 'label' => 'Nomor Terakhir'],
                (object)['name' => 'description', 'label' => 'Deskripsi'],
                (object)['name' => 'action', 'label' => 'ACTION']
            ],
            'records' => []
        ];

        if ($ConfigNumbering['records']) {
            $DataTable['records'] = $ConfigNumbering['records'];
            $DataTable['total'] = $ConfigNumbering['total'];
            $DataTable['show'] = $ConfigNumbering['show'];
        }

        $ParseData = [
            'data' => $DataTable,
            'result_total' => isset($DataTable['total']) ? $DataTable['total'] : 0
        ];
        return view('app.config_numbering.home.index', $ParseData);
    }

    public function Edit(Request $request, $id)
    {
        $ConfigNumbering = ConfigNumberingBrowseController::FetchBrowse($request)
            ->equal('id', $id)->get('first');


        if (!isset($ConfigNumbering['records']->id)) {
            throw new ModelNotFoundException('Not Found Batch');
        }
        return view('app.config_numbering.edit.index', [
            'select' => [],
            'data' => $ConfigNumbering['records']
        ]);
    }

}
