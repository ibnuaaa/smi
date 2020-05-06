<?php

namespace App\Http\Controllers\CMS\MailClassification;

use App\Http\Controllers\MailNumberClassification\MailNumberClassificationBrowseController;

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

class MailClassificationController extends Controller
{
    public function Home(Request $request)
    {
        $TableKey = 'mail_classification-table';

        $filter_search = $request->input($TableKey . '-filter_search');

        if (isset($request['mail_classification-table-show'])) {
            $selected = $request['mail_classification-table-show'];
        }
        else {
            $selected = 10;
        }
        $options = array(5,10,15,20);
        $MailNumberClassification = MailNumberClassificationBrowseController::FetchBrowse($request)
            ->where('orderBy.blast_mail_classifications.created_at', 'desc')
            ->where('with.total', 'true');

        if (isset($filter_search)) {
            $MailNumberClassification = $MailNumberClassification->where('search', $filter_search);
        }

        $MailNumberClassification = $MailNumberClassification->middleware(function($fetch) use($request, $TableKey) {
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
            'paginate' => ___TablePaginate((int)$MailNumberClassification['total'], (int)$MailNumberClassification['query']->take, ___TableGetCurrentPage($request, $TableKey)),
            'selected' => $selected,
            'options' => $options,
            'heads' => [
                (object)['name' => 'id', 'label' => 'ID'],
                (object)['name' => 'code', 'label' => 'Code'],
                (object)['name' => 'name', 'label' => 'Name'],
                (object)['name' => 'created_at', 'label' => 'Created At'],
                (object)['name' => 'action', 'label' => 'ACTION']
            ],
            'records' => []
        ];

        if ($MailNumberClassification['records']) {
            $DataTable['records'] = $MailNumberClassification['records'];
            $DataTable['total'] = $MailNumberClassification['total'];
            $DataTable['show'] = $MailNumberClassification['show'];
        }

        $ParseData = [
            'data' => $DataTable,
            'result_total' => isset($DataTable['total']) ? $DataTable['total'] : 0
        ];
        return view('app.mail_classification.home.index', $ParseData);
    }

    public function New(Request $request)
    {
        return view('app.mail_classification.new.index', [
            'select' => [],
        ]);
    }

    public function Detail(Request $request, $id)
    {
        $QueryRoute = QueryRoute($request);
        $QueryRoute->ArrQuery->id = $id;
        $QueryRoute->ArrQuery->set = 'first';
        $QueryRoute->ArrQuery->{'with.total'} = 'true';
        $MailNumberClassificationBrowseController = new MailNumberClassificationBrowseController($QueryRoute);
        $data = $MailNumberClassificationBrowseController->get($QueryRoute);

        return view('app.mail_classification.detail.index', [ 'data' => $data->original['data']['records'] ]);
    }

    public function Edit(Request $request, $id)
    {
        $MailNumberClassification = MailNumberClassificationBrowseController::FetchBrowse($request)
            ->equal('id', $id)->get('first');


        if (!isset($MailNumberClassification['records']->id)) {
            throw new ModelNotFoundException('Not Found Batch');
        }
        return view('app.mail_classification.edit.index', [
            'select' => [],
            'data' => $MailNumberClassification['records']
        ]);
    }

}
