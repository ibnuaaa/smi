<?php

namespace App\Http\Controllers\CMS\SuratMasuk;

use App\Http\Controllers\Mail\MailBrowseController;
use App\Http\Controllers\MailApproval\MailApprovalBrowseController;
use App\Http\Controllers\Mail\MailController;
use App\Http\Controllers\MailTemplate\MailTemplateBrowseController;
use Illuminate\Database\Eloquent\ModelNotFoundException;

use App\Http\Controllers\MailDisposition\MailDispositionBrowseController;
use App\Http\Controllers\Position\PositionBrowseController;


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
use Barryvdh\DomPDF\Facade as PDF;

use App\Traits\Config;

class SuratMasukController extends Controller
{
    use Config;

    public function Home(Request $request)
    {
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
            ->where('for', 'surat_masuk')
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
            'placeholder_search' => "No Surat, Perihal, Isi Surat",
            'filter_search' => $filter_search,
            'pageNow' => ___TableGetCurrentPage($request, $TableKey),
            'paginate' => ___TablePaginate((int)$Mail['total'], (int)$Mail['query']->take, ___TableGetCurrentPage($request, $TableKey)),
            'selected' => $selected,
            'options' => $options,
            'heads' => [
                (object)['name' => 'tgl masuk', 'label' => 'TGL MASUK'],
                (object)['name' => 'no', 'label' => 'NO'],
                (object)['name' => 'dari', 'label' => 'DARI'],
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


        $ParseData = [
            'data' => $DataTable,
            'result_total' => isset($DataTable['total']) ? $DataTable['total'] : 0
        ];
        return view('app.surat_masuk.home.index', $ParseData);
    }

    public function Preview(Request $request, $id, $mail_type = '')
    {

        $QueryRoute = QueryRoute($request);
        $QueryRoute->ArrQuery->mail_id = $id;
        $MailController = new MailController($QueryRoute);
        $MailController->ReadMailApproval($QueryRoute, $id);
        $MailController->ReadMailTo($QueryRoute, $id);

        // GET DATA
        $QueryRoute = QueryRoute($request);
        $QueryRoute->ArrQuery->id = $id;
        $QueryRoute->ArrQuery->set = 'first';
        $QueryRoute->ArrQuery->{'with.total'} = 'true';
        $MailBrowseController = new MailBrowseController($QueryRoute);
        $data = $MailBrowseController->get($QueryRoute);



        $LastMailNumberByPosition = MailBrowseController::FetchBrowse($request)
            ->where('source_position_id', $data->original['data']['records']->source_position_id)
            ->where('not_null', 'mail_number_infix')
            ->get('first');

        $last_mail_number = ((int) $LastMailNumberByPosition['records']->mail_number_infix) + 1;
        $last_mail_number = str_pad($last_mail_number, '4', '0', STR_PAD_LEFT);

        $is_show_approval_button = false;
        if(!empty($data->original['data']['records']->approval->toArray()) && count($data->original['data']['records']->approval->toArray()) > 0)
        {
            foreach ($data->original['data']['records']->approval->toArray() as $key => $value)
            {
                if($value['position_id'] == Auth::user()->position_id && in_array($value['status'], [1,2,4,5])) {
                    $is_show_approval_button = true;
                }
            }
        }

        $CurrentPosition = PositionBrowseController::FetchBrowse($request)
                ->where('id', Auth::user()->position_id)
                ->get('first');

        $is_surat_masuk = ($mail_type == 'surat_masuk');
        $is_surat_keluar = ($mail_type == 'surat_keluar');
        $is_approval = ($mail_type == 'approval');
        $is_disposition = ($mail_type == 'disposition' && ($CurrentPosition['records']->eselon_id < 4 || $CurrentPosition['records']->eselon_id == ''));
        $is_approval_numbering = ($mail_type == 'approval_numbering');

        // Sementara ada logic disini nanti dipindah
        // harusnya ngga disini
        $MailDetail = $data->original['data']['records'];
        $mail_detail = [];
        foreach ($MailDetail->mail_detail as $key => $value) {
            $mail_detail[$value->key] = $value->value;
        }

        $Config = $this->Config();

        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'http://satellite-'.env('APP_DOMAIN').'/qrcode/'.$data->original['data']['records']->mail_hash_code,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_USERAGENT => 'Mozilla/5.0 (Windows NT 6.2; WOW64; rv:17.0) Gecko/20100101 Firefox/17.0',
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1
        ));
        $response_curl = curl_exec($curl);

        curl_close($curl);

        $ParseData = [
            'mail_id' => $id,
            'data' => $data->original['data']['records'],
            'is_show_approval_button' => $is_show_approval_button,
            'is_surat_masuk' => $is_surat_masuk,
            'is_surat_keluar' => $is_surat_keluar,
            'is_approval' => $is_approval,
            'is_disposition' => $is_disposition,
            'is_approval_numbering' => $is_approval_numbering,
            'api_url' => 'satellite-'.env('APP_DOMAIN'),
            'maker_user_id' => Auth::user()->id,
            'mail_detail' => $mail_detail,
            'config' => $Config,
            'is_preview' => 'y',
            'eselon_id' => $CurrentPosition['records']->eselon_id,
            'last_mail_number' => $last_mail_number
        ];

        $MailTemplate = MailTemplateBrowseController::FetchBrowse($request)
            ->where('id', $data->original['data']['records']->mail_template_id)
            ->get('first');

        return view('app.preview.' . strtolower($MailTemplate['records']->mail_code), $ParseData);
    }

    public function MailImportDetail(Request $request, $id)
    {
        $QueryRoute = QueryRoute($request);
        $QueryRoute->ArrQuery->mail_id = $id;
        $MailController = new MailController($QueryRoute);
        $MailController->ReadMailApproval($QueryRoute, $id);
        $MailController->ReadMailTo($QueryRoute, $id);

        // GET DATA
        $QueryRoute = QueryRoute($request);
        $QueryRoute->ArrQuery->id = $id;
        $QueryRoute->ArrQuery->set = 'first';
        $QueryRoute->ArrQuery->{'with.total'} = 'true';
        $MailBrowseController = new MailBrowseController($QueryRoute);
        $data = $MailBrowseController->get($QueryRoute);

        $MailDisposition = MailDispositionBrowseController::FetchBrowse($request)
            ->where('master_mail_id', $id)
            ->get('first');


        $is_show_approval_button = false;
        if(!empty($data->original['data']['records']->approval->toArray()) && count($data->original['data']['records']->approval->toArray()) > 0)
        {
            foreach ($data->original['data']['records']->approval->toArray() as $key => $value)
            {
                if($value['position_id'] == Auth::user()->position_id && in_array($value['status'], [1,2,4,5])) {
                    $is_show_approval_button = true;
                }
            }
        }

        $CurrentPosition = PositionBrowseController::FetchBrowse($request)
                ->where('id', Auth::user()->position_id)
                ->get('first');

        // $is_surat_masuk = ($mail_type == 'surat_masuk');
        // $is_surat_keluar = ($mail_type == 'surat_keluar');
        // $is_approval = ($mail_type == 'approval');
        // $is_disposition = ($mail_type == 'disposition');

        // Sementara ada logic disini nanti dipindah
        // harusnya ngga disini
        $MailDetail = $data->original['data']['records'];
        $mail_detail = [];
        foreach ($MailDetail->mail_detail as $key => $value) {
            $mail_detail[$value->key] = $value->value;
        }

        $ParseData = [
            'mail_id' => $id,
            'data' => $data->original['data']['records'],
            'mail_detail' => $mail_detail,
            'disposition' => $MailDisposition['records'],
            'eselon_id' => $CurrentPosition['records']->eselon_id
        ];

        $MailTemplate = MailTemplateBrowseController::FetchBrowse($request)
            ->where('id', $data->original['data']['records']->mail_template_id)
            ->get('first');

        return view('app.preview.mail_import_detail', $ParseData);
    }


    public function DownloadPdfFromQr(Request $request, $key)
    {
        $id = 11;

        $Mail = MailBrowseController::FetchBrowse($request)
            ->where('mail_hash_code', $key)
            ->get('first');

        return $this->DownloadPdf($request, $Mail['records']->id);
    }

    public function DownloadPdf(Request $request, $id)
    {
        // GET DATA
        $QueryRoute = QueryRoute($request);
        $QueryRoute->ArrQuery->id = $id;
        $QueryRoute->ArrQuery->set = 'first';
        $QueryRoute->ArrQuery->{'with.total'} = 'true';
        $MailBrowseController = new MailBrowseController($QueryRoute);
        $data = $MailBrowseController->get($QueryRoute);

        $MailTemplate = MailTemplateBrowseController::FetchBrowse($request)
            ->where('id', $data->original['data']['records']->mail_template_id)
            ->get('first');

        $Config = $this->Config();

        $ParseData = [
            'mail_id' => $id,
            'data' => $data->original['data']['records'],
            'maker_user_id' => '',
            'config' => $Config,
            'is_preview' => 'n'
        ];

        $pdf = PDF::loadView('app.pdf.surat.' . strtolower($MailTemplate['records']->mail_code), $ParseData);
        $pdf->setPaper('A4', 'portrait');
        return $pdf->stream();
    }

    public function DebugPdf(Request $request, $id)
    {
        // GET DATA
        $QueryRoute = QueryRoute($request);
        $QueryRoute->ArrQuery->id = $id;
        $QueryRoute->ArrQuery->set = 'first';
        $QueryRoute->ArrQuery->{'with.total'} = 'true';
        $MailBrowseController = new MailBrowseController($QueryRoute);
        $data = $MailBrowseController->get($QueryRoute);

        $MailTemplate = MailTemplateBrowseController::FetchBrowse($request)
            ->where('id', $data->original['data']['records']->mail_template_id)
            ->get('first');

        $Config = $this->Config();

        $ParseData = [
            'mail_id' => $id,
            'data' => $data->original['data']['records'],
            'maker_user_id' => '',
            'config' => $Config,
            'is_preview' => 'n'
        ];

        return view('app.pdf.surat.' . strtolower($MailTemplate['records']->mail_code), $ParseData);
    }


    public function DownloadPdfSample(Request $request)
    {
        $pdf = PDF::loadView('app.pdf.surat.sample', []);
        $pdf->setPaper('A4', 'portrait');
        return $pdf->stream();
    }
}
