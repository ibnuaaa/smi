<?php

namespace App\Http\Controllers\CMS\SuratInternal;

use DB;
use Carbon\Carbon;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use App\Support\Response\Json;
use Illuminate\Support\Facades\Hash;
use App\Support\Generate\Hash as KeyGenerator;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;

use App\Http\Controllers\MailTemplate\MailTemplateBrowseController;
use App\Http\Controllers\Mail\MailBrowseController;
use App\Http\Controllers\Position\PositionBrowseController;
use App\Http\Controllers\User\UserBrowseController;
use App\Http\Controllers\Category\CategoryBrowseController;
use App\Http\Controllers\MailNumberClassification\MailNumberClassificationBrowseController;


use Illuminate\Support\Facades\Auth;

class SuratInternalController extends Controller
{
    public function Index(Request $request)
    {
        $Position = PositionBrowseController::FetchBrowse($request)
            ->where('id', Auth::user()->position_id)->get();

        $MailTemplate = MailTemplateBrowseController::FetchBrowse($request)
            ->where('mail_type', 'S')
            ->get();

        return view('app.surat_internal.home.index', [
            'eselon_id' => !empty($Position['records']) ? $Position['records']->eselon_id : '',
            'mail_template' => $MailTemplate['records']
        ]);
    }


    public function NewSurat(Request $request, $mail_template_id)
    {
        return $this->NewSuratFoundation($request, $mail_template_id);
    }

    public function NewSuratBalasanDisposisi(Request $request, $mail_template_id, $disposition_id)
    {
        return $this->NewSuratFoundation($request, $mail_template_id, $disposition_id);
    }


    public function NewSuratFoundation(Request $request, $mail_template_id, $disposition_id = '')
    {
        $Position = PositionBrowseController::FetchBrowse($request)
            ->where('id', Auth::user()->position_id)->get();
        $eselon_id = !empty($Position['records']) ? $Position['records']->eselon_id : '';

        $Position = PositionBrowseController::FetchBrowse($request)
            ->where('id', Auth::user()->position_id)
            ->where('for', 'selection')->get();
        $eselon2 = 0;
        foreach ($Position as $key => $value) {
            if(!empty($value['eselon_id']) && $value['eselon_id'] == 2) {
                $eselon2 = $value['id'];
            }
        }

        $PositionSelect = $this->ManipulateFormSelect($request, $Position);

        $MailNumberClassification = MailNumberClassificationBrowseController::FetchBrowse($request)
            ->get();
        $MailNumberClassificationSelect = FormSelect($MailNumberClassification['records'], true, $value = 'code', $label = 'code_name');

        $MailTemplate = MailTemplateBrowseController::FetchBrowse($request)
            ->where('id', $mail_template_id)
            ->get('first');

        return view('app.surat_internal.surat_dinas.index', [
            'select' => [
                'source_positions' => $PositionSelect,
                'source_mail_number_classification' => $MailNumberClassificationSelect
            ],
            'eselon_id' => $eselon_id,
            'id' => '',
            'selected' => [
                'source_position_id' => $eselon2,
                'privacy_type' => '3'
            ],
            'disposition_id' => $disposition_id,
            'mail_template_id' => $mail_template_id,
            'mail_template' => $MailTemplate['records']
        ]);
    }

    public function Edit(Request $request, $id)
    {
        $Position = PositionBrowseController::FetchBrowse($request)
            ->where('id', Auth::user()->position_id)->get();
        $eselon_id = !empty($Position['records']) ? $Position['records']->eselon_id : '';

        $Position = PositionBrowseController::FetchBrowse($request)
            ->where('id', Auth::user()->position_id)
            ->where('for', 'selection')->get();
        $PositionSelect = $this->ManipulateFormSelect($request, $Position);

        $Position = PositionBrowseController::FetchBrowse($request)
            ->where('id', Auth::user()->position_id)
            ->where('for', 'selection')->get();

        $Mail = MailBrowseController::FetchBrowse($request)
            ->where('id', $id)
            ->where('for', 'selection')
            ->get('first');

        $MailTemplate = MailTemplateBrowseController::FetchBrowse($request)
            ->where('id', $Mail['records']->mail_template_id)
            ->get('first');

        $MailNumberClassification = MailNumberClassificationBrowseController::FetchBrowse($request)
            ->where('code', $Mail['records']->mail_number_prefix)
            ->get('first');

        return view('app.surat_internal.surat_dinas.index', [
            'mail' => $Mail['records'],
            'select' => [
                'source_positions' => $PositionSelect,
            ],
            'eselon_id' => $eselon_id,
            'selected' => [
                'source_position_id' => $Mail['records']->source_position_id,
                'mail_classification' => $MailNumberClassification['records']
            ],
            'id' => $id,
            'disposition_id' => '',
            'mail_template_id' => $MailTemplate['records']->id,
            'mail_template' => $MailTemplate['records']
        ]);
    }

    public function NotaDinas(Request $request)
    {
        return view('app.surat_internal.nota_dinas.index');
    }

    public function SuratDinasPreview(Request $request)
    {
        return view('app.surat_internal.surat_dinas_preview.index');
    }

    public function ManipulateFormSelect(Request $request, $Position) {

        $Position = array_reverse($Position);

        $position_ids = [];
        foreach ($Position as $key => $value) {
            $position_ids[] = $value['id'];
        }

        $User = UserBrowseController::FetchBrowse($request)
            ->where('position_ids', $position_ids)
            ->where('take', 1000)
            ->get('fetch');
        $Users = $User['records']->groupBy('position_id')->toArray();

        // GET ESELON 2 & 3
        $results = [];
        foreach ($Position as $key => $value)
        {
            if(in_array($value['eselon_id'], ['', 1,2,3])) {
                $data['value'] = $value['id'];
                $data['label'] = $value['name']. " (ESELON ".(!empty($value['eselon_id']) ? $value['eselon_id'] : '').") ";
                $data['dataset'] = "data-eselonid=".(!empty($value['eselon_id']) ? $value['eselon_id'] : '')."";

                if (!empty($Users[$value['id']]) && count($Users[$value['id']]) > 0) {
                    $data['label'] .= $Users[$value['id']][0]['name'];
                    $data['label'] .= " / NIP.".$Users[$value['id']][0]['username'];
                }

                $results[] = $data;
            }
        }

        return $results;
    }

}
