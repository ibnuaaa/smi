<?php

namespace App\Http\Controllers\CMS\Disposisi;

use App\Http\Controllers\Mail\MailBrowseController;
use App\Http\Controllers\MailDisposition\MailDispositionBrowseController;
use App\Http\Controllers\MailDispositionFollowUp\MailDispositionFollowUpBrowseController;
use App\Http\Controllers\Position\PositionBrowseController;
use App\Http\Controllers\Mail\MailController;
use App\Http\Controllers\MailDispositionReply\MailDispositionReplyBrowseController;

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

use Barryvdh\DomPDF\Facade as PDF;
use App\Traits\Config;

class DisposisiController extends Controller
{
    use Config;

    public function Home(Request $request)
    {
        $TableKey = 'user-table';

        if (isset($request['user-table-show'])) {
            $selected = $request['user-table-show'];
        }
        else {
            $selected = 10;
        }
        $options = array(5,10,15,20);
        $Mail = MailBrowseController::FetchBrowse($request)
            ->where('with.total', 'true')
            ->where('for', 'disposition')
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
            'paginate' => ___TablePaginate((int)$Mail['total'], (int)$Mail['query']->take, ___TableGetCurrentPage($request, $TableKey)),
            'selected' => $selected,
            'options' => $options,
            'heads' => [
                (object)['name' => 'tgl disposisi', 'label' => 'TANGGAL'],
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


        $ParseData = [
            'data' => $DataTable,
            'result_total' => isset($DataTable['total']) ? $DataTable['total'] : 0
        ];
        return view('app.disposition.home.index', $ParseData);
    }

    public function New(Request $request, $id)
    {
        $ChildPosition = PositionBrowseController::FetchBrowse($request)
            ->where('parent_id', Auth::user()->position_id)
            ->where('take', 10000)
            ->get('fetch');

        $child_ids = [];
        foreach ($ChildPosition['records'] as $key => $value) {
            $child_ids[] = $value->id;
        }

        // BUAT STAFF
        $StaffPosition = PositionBrowseController::FetchBrowse($request)
            ->where('parent_id_in', $child_ids)
            ->where('take', 10000)
            ->get('fetch');

        $staff = $StaffPosition['records']->groupBy('parent_id');

        $Mail = MailBrowseController::FetchBrowse($request)
            ->where('id', $id)
            ->get('first');

        $CurrentPosition = PositionBrowseController::FetchBrowse($request)
            ->where('id', Auth::user()->position_id)
            ->get('first');

        if ($CurrentPosition['records']->code == 'SEKJEN') {
            $EqualPosition = PositionBrowseController::FetchBrowse($request)
                ->where('parent_id', $CurrentPosition['records']->parent_id)
                ->where('take', '1000')
                ->get('fetch');
        }

        $ParentMail = MailBrowseController::FetchBrowse($request)
            ->where('id', $Mail['records']->parent_mail_id)
            ->get('first');


        $master_mail_id = $id;

        $MailDisposition = MailDispositionBrowseController::FetchBrowse($request)
            ->where('mail_id', $id)
            ->get('first');


        if (!empty($MailDisposition['records']->master_mail_id)) $master_mail_id = $MailDisposition['records']->master_mail_id;

        $MasterMail = MailBrowseController::FetchBrowse($request)
            ->where('id', $master_mail_id)
            ->get('first');

        // ESELON 1 SEKJEN
        $disposition_type = '';
        if ($CurrentPosition['records']->eselon_id == '1' && $CurrentPosition['records']->code == 'SEKJEN')
        {
            // 2A
            $disposition_type = 'sekjen-ke-eselon-2';
            $view = 'app.disposition.eselon_1_sekjen.new.index';
        }
        else if ($CurrentPosition['records']->eselon_id == '1')
        {
            // 2B
            $disposition_type = 'non-sekjen-ke-eselon-2';
            $view = 'app.disposition.eselon_1_non_sekjen.new.index';
        }
        else if ($CurrentPosition['records']->eselon_id == '2')
        {
            // 3
            $disposition_type = 'eselon-2-ke-eselon-3';
            $view = 'app.disposition.eselon_2.new.index';
        }
        else if ($CurrentPosition['records']->eselon_id == '3')
        {
            // 4
            $disposition_type = 'menteri-ke-eselon-3';
            $view = 'app.disposition.eselon_3.new.index';
        } else {
            // Menteri
            $disposition_type = 'menteri-ke-eselon-1';
            $view = 'app.disposition.menteri.new.index';
        }

        $MailDispositionFollowUp = MailDispositionFollowUpBrowseController::FetchBrowse($request)
            ->where('disposition_type', $disposition_type)
            ->equal('take', "all")
            ->get('fetch');

        $ParseData = [
            'child_positions' => $ChildPosition['records'],
            'mail' => $Mail['records'],
            'parent_mail' => $ParentMail['records'],
            'master_mail' => $MasterMail['records'],
            'id' => $id,
            'staff' => $staff,
            'disposition_follow_up' => $MailDispositionFollowUp['records']
        ];

        if ($CurrentPosition['records']->code == 'SEKJEN') {
            $ParseData['equal_positions'] = $EqualPosition['records'];
        }

        return view($view, $ParseData);
    }


    public function Detail(Request $request, $disposition_id)
    {
        $MailDisposition = MailDispositionBrowseController::FetchBrowse($request)
            ->where('id', $disposition_id)
            ->get('first');

        $mail_id = $MailDisposition['records']->mail_id;
        $QueryRoute = QueryRoute($request);
        $QueryRoute->ArrQuery->mail_id = $mail_id;
        $MailController = new MailController($QueryRoute);
        $MailController->ReadMailTo($QueryRoute, $mail_id);

        $ChildPosition = PositionBrowseController::FetchBrowse($request)
            ->where('parent_id', $MailDisposition['records']->disposition_position)
            ->where('take', 10000)
            ->get('fetch');

        // BUAT STAFF
        $child_ids = [];
        foreach ($ChildPosition['records'] as $key => $value) {
            $child_ids[] = $value->id;
        }

        $StaffPosition = PositionBrowseController::FetchBrowse($request)
            ->where('parent_id_in', $child_ids)
            ->where('take', 10000)
            ->get('fetch');

        $staff = $StaffPosition['records']->groupBy('parent_id');

        $Mail = MailBrowseController::FetchBrowse($request)
            ->where('id', $MailDisposition['records']->mail_id)
            ->get('first');

        $ParentMail = MailBrowseController::FetchBrowse($request)
            ->where('id', $MailDisposition['records']->parent_mail_id)
            ->get('first');

        $CurrentPosition = PositionBrowseController::FetchBrowse($request)
            ->where('id', $Mail['records']->source_position_id)
            ->get('first');


        $MyPosition = PositionBrowseController::FetchBrowse($request)
            ->where('id', Auth::user()->position_id)
            ->get('first');

        // MASTER MAIL DISPOSITION
        $MasterMail = MailBrowseController::FetchBrowse($request)
            ->where('id', $MailDisposition['records']->master_mail_id)
            ->get('first');


        // mail_disposition_reply
        $MailDispositionReply = MailDispositionReplyBrowseController::FetchBrowse($request)
            ->where('disposition_id', $disposition_id)
            ->get('fetch');


        $MailDispositionReplyMail = MailBrowseController::FetchBrowse($request)
            ->where('for', 'mail_disposition_replies')
            ->where('disposition_id', $disposition_id)
            ->get('fetch');

        $selected_position_id = [];
        foreach ($Mail['records']->disposition_destination as $key => $val) {
            if (!empty($val->position->id)) $selected_position_id[] = $val->position->id;
        }

        // Sementara ada logic disini nanti dipindah
        // harusnya ngga disini
        $mail_detail = [];
        $follow_up_tambahan = [];
        foreach ($Mail['records']->mail_detail as $key => $value) {
            if(substr($value->key, 0, 18) == 'follow_up_tambahan') {
                $follow_up_tambahan[] = $value->value;
            } else  {
                $mail_detail[$value->key] = $value->value;
            }
        }

        $title = '';
        // ESELON 1 SEKJEN
        if ($CurrentPosition['records']->eselon_id == '1' && $CurrentPosition['records']->code == 'SEKJEN')
        {
            // 2A
            $disposition_type = 'sekjen-ke-eselon-2';
            $title = 'Eselon 1 Sekjen Ke Eselon 2';
        }
        else if ($CurrentPosition['records']->eselon_id == '1')
        {
            // 2B
            $disposition_type = 'non-sekjen-ke-eselon-2';
            $title = 'Eselon 1 Non Sekjen Ke Eselon 2';
        }
        else if ($CurrentPosition['records']->eselon_id == '2')
        {
            // 3
            $disposition_type = 'eselon-2-ke-eselon-3';
            $title = 'Eselon 2 Ke Eselon 3';
        }
        else if ($CurrentPosition['records']->eselon_id == '3')
        {
            // 4
            $disposition_type = 'none';
            $title = 'Eselon 3 Ke Eselon 4 & Staff';
        } else
        {
            // Menteri
            $disposition_type = 'menteri-ke-eselon-1';
            $title = 'Menteri Ke Eselon 1';
        }

        $view = 'app.disposition.detail.index';

        $MailDispositionFollowUp = MailDispositionFollowUpBrowseController::FetchBrowse($request)
            ->where('disposition_type', $disposition_type)
            ->equal('take', "all")
            ->get('fetch');

        $Config = $this->Config();

        // MailDisposition['records']->master_mail_id

        // GET DATA
        $QueryRoute = QueryRoute($request);
        $QueryRoute->ArrQuery->id = $MailDisposition['records']->master_mail_id;
        $QueryRoute->ArrQuery->set = 'first';
        $QueryRoute->ArrQuery->{'with.total'} = 'true';
        $MailBrowseController = new MailBrowseController($QueryRoute);
        $data = $MailBrowseController->get($QueryRoute);

        return view($view, [
            'child_positions' => $ChildPosition['records'],
            'disposition' => $MailDisposition['records'],
            'mail' => $Mail['records'],
            'mail_detail' => $mail_detail,
            'parent_mail' => $ParentMail['records'],
            'master_mail' => $MasterMail['records'],
            'id' => $disposition_id,
            'is_preview' => 'y',
            'eselon_id' => $MyPosition['records']->eselon_id,
            'title' => $title,
            'mail_disposition_reply' => $MailDispositionReply['records'],
            'disposition_id' => $disposition_id,
            'mail_disposition_reply_mail' => $MailDispositionReplyMail['records'],

            // buat surat
            'config' => $Config,
            'staff' => $staff,
            'selected_position_id' => $selected_position_id,
            'data' => $data->original['data']['records'],
            'mail_id' => $MailDisposition['records']->master_mail_id,
            'is_for_disposition' => 'y',
            'disposition_follow_up' => $MailDispositionFollowUp['records'],
            'follow_up_tambahan' => $follow_up_tambahan
        ]);
    }

    public function DownloadPdf(Request $request, $disposition_id)
    {
        $MailDisposition = MailDispositionBrowseController::FetchBrowse($request)
            ->where('id', $disposition_id)
            ->get('first');


        $ChildPosition = PositionBrowseController::FetchBrowse($request)
            ->where('parent_id', $MailDisposition['records']->disposition_position)
            ->where('take', 10000)
            ->get('fetch');

        $child_ids = [];
        foreach ($ChildPosition['records'] as $key => $value) {
            $child_ids[] = $value->id;
        }

        // BUAT STAFF
        $StaffPosition = PositionBrowseController::FetchBrowse($request)
            ->where('parent_id_in', $child_ids)
            ->where('take', 10000)
            ->get('fetch');

        $staff = $StaffPosition['records']->groupBy('parent_id');

        $Mail = MailBrowseController::FetchBrowse($request)
            ->where('id', $MailDisposition['records']->mail_id)
            ->get('first');

        $ParentMail = MailBrowseController::FetchBrowse($request)
            ->where('id', $Mail['records']->parent_mail_id)
            ->get('first');

        $CurrentPosition = PositionBrowseController::FetchBrowse($request)
            ->where('id', $Mail['records']->source_position_id)
            ->get('first');

        // MASTER MAIL DISPOSITIOn
        $MasterMail = MailBrowseController::FetchBrowse($request)
            ->where('id', $MailDisposition['records']->master_mail_id)
            ->get('first');

        // Sementara ada logic disini nanti dipindah
        // harusnya ngga disini
        $mail_detail = [];
        foreach ($Mail['records']->mail_detail as $key => $value) {
            $mail_detail[$value->key] = $value->value;
        }



        $eselon_2_header_name = '';
        $eselon_3_header_name = '';
        $eselon_1_header_name = '';


        $disposition_type = '';
        // ESELON 1 SEKJEN
        if ($CurrentPosition['records']->eselon_id == '1' && $CurrentPosition['records']->code == 'SEKJEN')
        {
            // 2A
            $view = 'app.pdf.disposition.eselon_1_sekjen.index';
            $disposition_type = 'sekjen-ke-eselon-2';
        }
        else if ($CurrentPosition['records']->eselon_id == '1')
        {
            // 2B
            $view = 'app.pdf.disposition.eselon_1_non_sekjen.index';
            $disposition_type = 'non-sekjen-ke-eselon-2';
        }
        else if ($CurrentPosition['records']->eselon_id == '2')
        {

            $eselon_2_header_name = $this->headerName($CurrentPosition['records']->shortname);

            $ParentPositionFromCurrentMail = PositionBrowseController::FetchBrowse($request)
                ->where('id', $CurrentPosition['records']->parent_id)
                ->get('first');

            $eselon_1_header_name = $this->headerName($ParentPositionFromCurrentMail['records']->shortname);

            // 3
            $view = 'app.pdf.disposition.eselon_2.index';
            $disposition_type = 'eselon-2-ke-eselon-3';
        }
        else if ($CurrentPosition['records']->eselon_id == '3')
        {

            $eselon_3_header_name = $this->headerName($CurrentPosition['records']->shortname);

            $ParentPositionFromCurrentMail = PositionBrowseController::FetchBrowse($request)
                ->where('id', $CurrentPosition['records']->parent_id)
                ->get('first');

            $eselon_2_header_name = $this->headerName($ParentPositionFromCurrentMail['records']->shortname);

            // 4
            $view = 'app.pdf.disposition.eselon_3.index';
            $disposition_type = 'menteri-ke-eselon-3';
        }
        else
        {
            // menteri
            $view = 'app.pdf.disposition.menteri.index';
            $disposition_type = 'menteri-ke-eselon-1';
        }

        $MailDispositionFollowUp = MailDispositionFollowUpBrowseController::FetchBrowse($request)
            ->where('disposition_type', $disposition_type)
            ->equal('take', "all")
            ->get('fetch');

        $selected_position_id = [];
        foreach ($Mail['records']->disposition_destination as $key => $val) {
            if(!empty($val->position->id)) $selected_position_id[] = $val->position->id;
        }



        $in_position_ids = [];
        foreach ($ChildPosition['records'] as $key => $val) {
            $in_position_ids[] = $val->id;
            if (!empty($staff[$val->id])) {
                foreach ($staff[$val->id] as $key2 => $val2) {
                    $in_position_ids[] = $val2->id;
                }
            }
        }


        $ParseData = [
            'child_positions' => $ChildPosition['records'],
            'mail' => $Mail['records'],
            'disposition' => $MailDisposition['records'],
            'master_mail' => $MasterMail['records'],
            'mail_detail' => $mail_detail,
            'staff' => $staff,
            'parent_mail' => $ParentMail['records'],
            'id' => $MailDisposition['records']->mail_id,
            'selected_position_id' => $selected_position_id,
            'disposition_follow_up' => $MailDispositionFollowUp['records'],
            'in_position_ids' => $in_position_ids,
            'eselon_1_header_name' => $eselon_1_header_name,
            'eselon_2_header_name' => $eselon_2_header_name,
            'eselon_3_header_name' => $eselon_3_header_name
        ];



        $pdf = PDF::loadView($view, $ParseData);
        $pdf->setPaper('A4', 'portrait');
        return $pdf->stream();
    }


    public function headerName($position_name) {
        $position_name = strtoupper($position_name);
        $position_name = str_replace('KEPALA', '', $position_name);
        $position_name = str_replace('SEKRETARIS', 'SEKRETARIAT', $position_name);

        return $position_name;
    }
}
