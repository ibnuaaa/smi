<?php

namespace App\Http\Controllers\CMS\Information;

use App\Http\Controllers\Information\InformationBrowseController;

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

class InformationController extends Controller
{
    public function Home(Request $request)
    {
        $TableKey = 'information-table';

        $filter_search = $request->input($TableKey . '-filter_search');

        if (isset($request['information-table-show'])) {
            $selected = $request['information-table-show'];
        }
        else {
            $selected = 10;
        }
        $options = array(5,10,15,20);
        $Information = InformationBrowseController::FetchBrowse($request)
            ->where('orderBy.blast_informations.created_at', 'desc')
            ->where('with.total', 'true');

        if (isset($filter_search)) {
            $Information = $Information->where('search', $filter_search);
        }

        $Information = $Information->middleware(function($fetch) use($request, $TableKey) {
                $fetch->equal('skip', ___TableGetSkip($request, $TableKey, $fetch->QueryRoute->ArrQuery->take));
                return $fetch;
            })
            ->get('fetch');

        $Take = ___TableGetTake($request, $TableKey);
        $DataTable = [
            'key' => $TableKey,
            'filter_search' => $filter_search,
            'placeholder_search' => "Judul, Desk",
            'pageNow' => ___TableGetCurrentPage($request, $TableKey),
            'paginate' => ___TablePaginate((int)$Information['total'], (int)$Information['query']->take, ___TableGetCurrentPage($request, $TableKey)),
            'selected' => $selected,
            'options' => $options,
            'heads' => [
                (object)['name' => 'id', 'label' => 'ID'],
                (object)['name' => 'title', 'label' => 'Title'],
                (object)['name' => 'content', 'label' => 'Content'],
                (object)['name' => 'created_at', 'label' => 'Created At'],
                (object)['name' => 'action', 'label' => 'ACTION']
            ],
            'records' => []
        ];

        if ($Information['records']) {
            $DataTable['records'] = $Information['records'];
            $DataTable['total'] = $Information['total'];
            $DataTable['show'] = $Information['show'];
        }

        $ParseData = [
            'data' => $DataTable,
            'result_total' => isset($DataTable['total']) ? $DataTable['total'] : 0
        ];
        return view('app.information.home.index', $ParseData);
    }

    public function New(Request $request)
    {
        return view('app.information.new.index', [
            'select' => [],
        ]);
    }

    public function Detail(Request $request, $id)
    {
        $QueryRoute = QueryRoute($request);
        $QueryRoute->ArrQuery->id = $id;
        $QueryRoute->ArrQuery->set = 'first';
        $QueryRoute->ArrQuery->{'with.total'} = 'true';
        $InformationBrowseController = new InformationBrowseController($QueryRoute);
        $data = $InformationBrowseController->get($QueryRoute);

        return view('app.information.detail.index', [ 'data' => $data->original['data']['records'] ]);
    }

    public function Edit(Request $request, $id)
    {
        $Information = InformationBrowseController::FetchBrowse($request)
            ->equal('id', $id)->get('first');


        if (!isset($Information['records']->id)) {
            throw new ModelNotFoundException('Not Found Batch');
        }
        return view('app.information.edit.index', [
            'select' => [],
            'data' => $Information['records']
        ]);
    }

}
