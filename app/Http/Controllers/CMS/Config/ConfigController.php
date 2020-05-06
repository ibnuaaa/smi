<?php

namespace App\Http\Controllers\CMS\Config;

use App\Http\Controllers\Config\ConfigBrowseController;

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

class ConfigController extends Controller
{
    public function Home(Request $request)
    {
        $TableKey = 'config-table';

        $filter_search = $request->input($TableKey . '-filter_search');

        if (isset($request['config-table-show'])) {
            $selected = $request['config-table-show'];
        }
        else {
            $selected = 10;
        }
        $options = array(5,10,15,20);
        $Config = ConfigBrowseController::FetchBrowse($request)
            ->where('orderBy.blast_configs.created_at', 'desc')
            ->where('with.total', 'true');

        if (isset($filter_search)) {
            $Config = $Config->where('search', $filter_search);
        }

        $Config = $Config->middleware(function($fetch) use($request, $TableKey) {
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
            'paginate' => ___TablePaginate((int)$Config['total'], (int)$Config['query']->take, ___TableGetCurrentPage($request, $TableKey)),
            'selected' => $selected,
            'options' => $options,
            'heads' => [
                (object)['name' => 'id', 'label' => 'ID'],
                (object)['name' => 'key', 'label' => 'Key'],
                (object)['name' => 'value', 'label' => 'Value'],
                (object)['name' => 'created_at', 'label' => 'Created At'],
                (object)['name' => 'action', 'label' => 'ACTION']
            ],
            'records' => []
        ];

        if ($Config['records']) {
            $DataTable['records'] = $Config['records'];
            $DataTable['total'] = $Config['total'];
            $DataTable['show'] = $Config['show'];
        }

        $ParseData = [
            'data' => $DataTable,
            'result_total' => isset($DataTable['total']) ? $DataTable['total'] : 0
        ];
        return view('app.config.home.index', $ParseData);
    }

    public function New(Request $request)
    {
        return view('app.config.new.index', [
            'select' => [],
        ]);
    }

    public function Detail(Request $request, $id)
    {
        $QueryRoute = QueryRoute($request);
        $QueryRoute->ArrQuery->id = $id;
        $QueryRoute->ArrQuery->set = 'first';
        $QueryRoute->ArrQuery->{'with.total'} = 'true';
        $ConfigBrowseController = new ConfigBrowseController($QueryRoute);
        $data = $ConfigBrowseController->get($QueryRoute);

        return view('app.config.detail.index', [ 'data' => $data->original['data']['records'] ]);
    }

    public function Edit(Request $request, $id)
    {
        $Config = ConfigBrowseController::FetchBrowse($request)
            ->equal('id', $id)->get('first');


        if (!isset($Config['records']->id)) {
            throw new ModelNotFoundException('Not Found Batch');
        }
        return view('app.config.edit.index', [
            'select' => [],
            'data' => $Config['records']
        ]);
    }

}
