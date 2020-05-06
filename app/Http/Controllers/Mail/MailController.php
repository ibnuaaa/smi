<?php

namespace App\Http\Controllers\Mail;

use App\Models\Mail;
use App\Models\User;
use App\Models\MailTo;
use App\Models\MailDetail;
use App\Models\MailCopyTo;
use App\Models\MailApproval;
use App\Models\Position;
use App\Models\MailTemplate;
use App\Models\MailPrinciple;
use App\Models\MailDocument;
use App\Models\Storage as StorageDB;
use App\Models\ConfigNumbering;
use App\Models\ApiLog;
use App\Models\MailLogPositionUser;

use App\Traits\Browse;
use App\Traits\Numbering;
use App\Traits\NotificationTemplateTraits;

use Illuminate\Http\Response;
use Illuminate\Http\Request;
use App\Support\Response\Json;
use Illuminate\Support\Facades\Hash;
use App\Support\Generate\Hash as GenerateKey;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

use App\Models\Notification;
use App\Models\NotificationUser;

use Barryvdh\DomPDF\Facade as PDF;

use App\Traits\Config;

use CURLFile;
use App\Traits\Artillery;

class MailController extends Controller
{
    use Artillery;
    use Browse;
    use Numbering;
    use NotificationTemplateTraits;
    use Config;

    protected $search = [
        'id',
        'content',
        'updated_at',
        'created_at'
    ];
    public function get(Request $request)
    {
        $Mail = Mail::where(function ($query) use($request) {
            if (isset($request->ArrQuery->id)) {
                if ($request->ArrQuery->id === 'my') {
                    $query->where('id', $request->user()->id);
                } else {
                    $query->where('id', $request->ArrQuery->id);
                }
            }
            if (isset($request->ArrQuery->search)) {
               $search = '%' . $request->ArrQuery->search . '%';
               $query->where(function ($query) use($search) {
                   foreach ($this->search as $key => $value) {
                       $query->orWhere($value, 'like', $search);
                   }
               });
           }
        });
        $Browse = $this->Browse($request, $Mail, function ($data) use($request) {
            if (isset($request->ArrQuery->for) && ($request->ArrQuery->for === 'select')) {
                return $data->map(function($Mail) {
                    return [ 'value' => $Mail->id, 'label' => $Mail->name ];
                });
            } else {
                $data->map(function($Mail) {
                    if (isset($Mail->point->balance)) {
                        $Mail->point->balance = (double)$Mail->point->balance;
                    }
                    return $Mail;
                });
            }
            return $data;
        });
        Json::set('data', $Browse);
        return response()->json(Json::get(), 200);
    }

    public function Insert(Request $request)
    {

        $Model = $request->Payload->all()['Model'];

        $Model->Mail->mail_number = $Model->Mail->mail_number_prefix . '//' . $Model->Mail->mail_number_suffix;
        $Model->Mail->save();

        foreach ($Model->Approval as $key => $value) {
            $MailApproval = new MailApproval();
            $MailApproval->mail_id = $Model->Mail->id;


            $type = $value->type;

            // Jika approval nya 1 maka dia adalah signer (2 = signer, 1 = checker)
            if (count($Model->Approval) == 1) $type = 2;
            $MailApproval->type = $type;


            $MailApproval->position_id = $value->position_id;
            $MailApproval->order_id = ($key + 1);

            // Approval pertama selalu receive
            $status = ($key === 0 ? 1 : 0);

            // Checker Pertama akan mendapatkan mail untuk melakukan pengecekan
            $MailApproval->status = $status;
            $MailApproval->save();

            if ($key === 0) {
                $notification_id = $this->createNotif($Model->Mail->id, 'NEW_MAIL', $Model->Mail->mail_template_id);
                $this->sendNotifUser($notification_id, $value->position_id);
            }

        }

        foreach ($Model->MailTo as $key => $value) {
            $MailTo = new MailTo();
            $MailTo->mail_id = $Model->Mail->id;
            $MailTo->status ='0';
            $MailTo->type ='1';
            $MailTo->destination_position_id = $value->position_id;
            $MailTo->save();
        }

        foreach ($Model->MailCopyTo as $key => $value) {
            $MailCopyTo = new MailCopyTo();
            $MailCopyTo->mail_id = $Model->Mail->id;
            $MailCopyTo->status ='0';
            $MailCopyTo->position_id = $value->position_id;
            $MailCopyTo->save();
        }

        foreach ($Model->MailDetail as $key => $MailDetailData) {
            $MailDetail = new MailDetail();
            $MailDetail->mail_id = $Model->Mail->id;
            $MailDetail->key = $MailDetailData->key;
            $MailDetail->value = $MailDetailData->value;
            $MailDetail->save();
        }

        foreach ($Model->MailPrinciple as $key => $MailPrincipleData) {
            $MailPrinciple = new MailPrinciple();
            $MailPrinciple->mail_id = $Model->Mail->id;
            $MailPrinciple->principle = $MailPrincipleData->principle;
            $MailPrinciple->save();
        }


        // SAVE DEFAULT Suffix Numbering
        $ConfigNumbering = ConfigNumbering::where('type', 'POSITION-' . $this->_Request->input('source_position_id'))->first();
        if (empty($ConfigNumbering) || !empty($ConfigNumbering->config_numbering_id))
        {
            $ConfigNumbering = $this->addNewConfigNumbering('POSITION-' . $Model->Mail->source_position_id);
        }

        $type = $ConfigNumbering->type;
        $position_arr = explode('-', $type);
        $position_id = '';
        if (!empty($position_arr[1])) $position_id = $position_arr[1];

        $Position = Position::find($position_id);

        if (!empty($Position)) {
            $Position->config_numbering_id = $ConfigNumbering->id;
            $Position->mail_number_suffix_code = $Model->Mail->mail_number_suffix;
            $Position->save();
        }


        Json::set('data', $this->SyncData($request, $Model->Mail->id));
        return response()->json(Json::get(), 201);
    }

    public function InsertUploadSuratMasuk(Request $request)
    {
        $Model = $request->Payload->all()['Model'];

        if (!empty($Model->action) && $Model->action == 'kirim') {
            $Model->Mail->sent_at = date('Y-m-d H:i:S');
            $Model->Mail->status = 2;
        } else {
            $Model->Mail->status = 0;
        }

        $Model->Mail->save();

        foreach ($Model->MailTo as $key => $value) {
            $MailTo = new MailTo();
            $MailTo->mail_id = $Model->Mail->id;
            $MailTo->status ='0';
            $MailTo->type ='1';
            $MailTo->destination_position_id = $value->position_id;
            $MailTo->save();
        }

        Json::set('data', $this->SyncData($request, $Model->Mail->id));
        return response()->json(Json::get(), 201);
    }

    public function Update(Request $request)
    {
        $Model = $request->Payload->all()['Model'];

        $OldMailApproval = MailApproval::where("mail_id", $Model->Mail->id)->get();
        $OldMailApprovalId = array();
        foreach ($OldMailApproval as $key => $value) {
            $OldMailApprovalId[$value->id] = 1;
        }

        $OldMailTo = MailTo::where("mail_id", $Model->Mail->id)->get();
        $OldMailToId = array();
        foreach ($OldMailTo as $key => $value) {
            $OldMailToId[$value->id] = 1;
        }

        $OldMailCopyTo = MailCopyTo::where("mail_id", $Model->Mail->id)->get();
        $OldMailCopyToId = array();
        foreach ($OldMailCopyTo as $key => $value) {
            $OldMailCopyToId[$value->id] = 1;
        }

        $OldMailPrinciple = MailPrinciple::where("mail_id", $Model->Mail->id)->get();
        $OldMailPrincipleId = array();
        foreach ($OldMailPrinciple as $key => $value) {
            $OldMailPrincipleId[$value->id] = 1;
        }


        if ($Model->Mail->mail_template_id == '9' && $Model->action == 'kirim') {
            $Model->Mail->status = 2;
        }

        $Model->Mail->save();

        if (!empty($Model->Approval)) {
            foreach ($Model->Approval as $key => $value) {

                if(!empty($value->id) && !empty($OldMailApprovalId[$value->id])) unset($OldMailApprovalId[$value->id]);

                if(!empty($value->id)) $MailApproval = MailApproval::find($value->id);
                else $MailApproval = new MailApproval();

                if($MailApproval) {
                    $MailApproval->mail_id = $Model->Mail->id;
                    $MailApproval->type = $value->type;
                    $MailApproval->position_id = $value->position_id;
                    $MailApproval->order_id = ($key + 1);

                    // Checker Pertama akan mendapatkan mail untuk melakukan pengecekan
                    if ($key == 0 && $MailApproval->status == 6 && $Model->action == 'kirim') {
                        $MailApproval->status = 1;
                    }

                    $MailApproval->save();
                }
            }
        }

        foreach ($Model->MailTo as $key => $value) {
            if(!empty($value->id) && !empty($OldMailToId[$value->id]))  unset($OldMailToId[$value->id]);

            if(!empty($value->id)) $MailTo = MailTo::find($value->id);
            else $MailTo = new MailTo();

            if($MailTo) {
                $MailTo->mail_id = $Model->Mail->id;
                // $MailTo->status ='0';
                $MailTo->destination_position_id = $value->position_id;
                $MailTo->save();
            }
        }

        if (!empty($Model->MailCopyTo)) {
            foreach ($Model->MailCopyTo as $key => $value) {
                if(!empty($value->id) && !empty($OldMailCopyToId[$value->id]))  unset($OldMailCopyToId[$value->id]);

                if(!empty($value->id)) $MailCopyTo = MailCopyTo::find($value->id);
                else $MailCopyTo = new MailCopyTo();

                if($MailCopyTo) {
                    $MailCopyTo->mail_id = $Model->Mail->id;
                    // $MailCopyTo->status ='0';
                    $MailCopyTo->position_id = $value->position_id;
                    $MailCopyTo->save();
                }
            }
        }

        if (!empty($Model->MailPrinciple)) {
            foreach ($Model->MailPrinciple as $key => $value) {
                if(!empty($value->id) && !empty($OldMailPrincipleId[$value->id]))  unset($OldMailPrincipleId[$value->id]);

                if(!empty($value->id)) $MailPrinciple = MailPrinciple::find($value->id);
                else $MailPrinciple = new MailPrinciple();

                if($MailPrinciple) {
                    $MailPrinciple->mail_id = $Model->Mail->id;
                    $MailPrinciple->principle = $value->principle;
                    $MailPrinciple->save();
                }
            }
        }

        foreach ($OldMailApprovalId as $key => $value) {
            $deleteOldData = MailApproval::find($key);
            if($deleteOldData) $deleteOldData->delete();
        }

        foreach ($OldMailToId as $key => $value) {
            $deleteOldData = MailTo::find($key);
            if($deleteOldData) $deleteOldData->delete();
        }

        foreach ($OldMailCopyToId as $key => $value) {
            $deleteOldData = MailCopyTo::find($key);
            if($deleteOldData) $deleteOldData->delete();
        }

        foreach ($OldMailPrincipleId as $key => $value) {
            $deleteOldData = MailPrinciple::find($key);
            if($deleteOldData) $deleteOldData->delete();
        }

        // if ($Model->Mail->mail_template_id == '1') {
        //     $this->createLampiran($Model, $request);
        // }

        Json::set('data', $this->SyncData($request, $Model->Mail->id));
        return response()->json(Json::get(), 202);
    }

    public function ReadMailApproval(Request $request, $mail_id)
    {
        $MailApproval = MailApproval::where('mail_id', $mail_id)
            ->where('position_id', Auth::user()->position_id)
            ->whereIn('status', [1,4])
            ->first();
        if($MailApproval) {
            if($MailApproval->status == 1){
                $MailApproval->status = '2';

                $this->notificationRead($mail_id);

            } else if($MailApproval->status == 4) {
                $MailApproval->status = '5';

                $this->notificationRead($mail_id);

            }
            $MailApproval->save();

        }


        Json::set('data', $this->SyncData($request, $mail_id));
        return response()->json(Json::get(), 202);
    }

    public function ReadMailTo(Request $request, $mail_id)
    {
        $MailTo = MailTo::where('mail_id', $mail_id)
            ->where('destination_position_id', Auth::user()->position_id)
            ->whereIn('status', [0])
            ->first();
        if($MailTo) {
            if($MailTo->status === 0){
                $MailTo->status = '1';

                $this->notificationRead($mail_id);
            }
            $MailTo->save();

        }

        Json::set('data', $this->SyncData($request, $mail_id));
        return response()->json(Json::get(), 202);
    }


    public function notificationRead($mail_id) {
        $Mail = Mail::where('id', $mail_id)->first();
        $notification_id = $this->createNotif($mail_id, 'READ', $Mail->mail_template_id);

        // untuk pembuat surat
        if ($Mail->created_user_id != Auth::user()->id) {
            $this->sendNotifUser($notification_id, '', $Mail->created_user_id);
        }
        // checker & signer surat yang sudah mengapprove
        $MailApproval = MailApproval::where('mail_id', $Mail->id)->where('status', '3')->get();
        foreach ($MailApproval as $key => $value) {
            $this->sendNotifUser($notification_id, $value->position_id);
        }
    }

    public function Delete(Request $request)
    {
        $Model = $request->Payload->all()['Model'];
        $Model->Mail->delete();
        return response()->json(Json::get(), 202);
    }

    public function Approve(Request $request)
    {

        // // GET CURRENT POSITION
        $CurrentPosition = Position::where('id', Auth::user()->position_id)->first();


        $Config = $this->Config();

        $Model = $request->Payload->all()['Model'];

        $MailTemplate = MailTemplate::where('id', $Model->Mail->mail_template_id)->first();


        // JIKA SURAT MENGGUNAKAN ESIGN
        // dan action == 'approve'
        // hal ini untuk surat yang di re approve ke esign nggak mengakses data ulang

        $action = '';
        if (!empty($request->input('action'))) $action = $request->input('action');

        if($action != 'resubmitesign') {
            if ($Model->MailApproval->type == '2') {
                $Model->Mail->mail_date = date('Y-m-d H:i:s');
            }

            $Model->Mail->save();



            // Kirim notif ke semua user yang berhubungan dengan surat yang sudah approve surat
            // notif nya berisi : "Surat sudah disetujui" atau "Surat Dikirim"
            $notification_type = 'APPROVED';
            if ($Model->MailApproval->type == '2') {
                $notification_type = 'SENT';
            }

            $notification_id = $this->createNotif($Model->Mail->id, $notification_type, $Model->Mail->mail_template_id);

            // pembuat surat
            $this->sendNotifUser($notification_id, '', $Model->Mail->created_user_id);

            // checker & signer surat yang sudah mengapprove
            $MailApproval = MailApproval::where('mail_id', $Model->Mail->id)->where('status', '3')->get();
            foreach ($MailApproval as $key => $value) {
                $this->sendNotifUser($notification_id, $value->position_id);
            }






            $Model->MailApproval->status = '3';
            $Model->MailApproval->approved_at = date('Y-m-d H:i:s');
            $Model->MailApproval->save();
            // 0.Pending. 1.receive 2.read, 3.approve, 4.reject

            //SENT
            if ($Model->Mail && $Model->MailApproval) {
                // JIKA di approve oleh signer (2) maka status mail menjadi terkirim (2)
                if ($Model->MailApproval->type == '2') {

                    $MailTo = MailTo::where("mail_id", $Model->Mail->id)->get();

                    if(!empty($MailTo)) {

                        // NOTIF BUAT PENERIMA SURAT

                        $notification_id = $this->createNotif($Model->Mail->id, 'RECEIVED', $Model->Mail->mail_template_id);

                        foreach ($MailTo as $key => $value) {
                            $this->sendNotifUser($notification_id, $value->destination_position_id);
                        }
                    }

                    // JIKA Signer mengapprove maka nomor surat tergenerate
                    $number = $this->getTransactionNumber('POSITION-'.$Model->Mail->source_position_id);
                    $mail_number = $number['value'];

                    $Model->Mail->mail_number_infix = $mail_number;
                    $Model->Mail->mail_number = $Model->Mail->mail_number_prefix . '/' . $mail_number . '/' . $Model->Mail->mail_number_suffix;
                    $Model->Mail->save();

                }
            }



            if (!empty($Model->NextMailApproval)) {
                $Model->NextMailApproval->status = '1';
                $Model->NextMailApproval->save();

                // Notifikasi Permintaaan approval
                $notification_id = $this->createNotif($Model->Mail->id, 'REQUEST', $Model->Mail->mail_template_id);

                $this->sendNotifUser($notification_id, $Model->NextMailApproval->position_id);
            }
        }









        // GET DATA FOR PDF
        $QueryRoute = QueryRoute($request);
        $QueryRoute->ArrQuery->id = $Model->Mail->id;
        $QueryRoute->ArrQuery->set = 'first';
        $QueryRoute->ArrQuery->{'with.total'} = 'true';
        $MailBrowseController = new MailBrowseController($QueryRoute);
        $data = $MailBrowseController->get($QueryRoute);



        $ParseData = [
            'mail_id' => $Model->Mail->id,
            'data' => $data->original['data']['records'],
            'maker_user_id' => '',
            'config' => $Config,
            'is_preview' => 'n'
        ];


        $data_mail = $data->original['data']['records'];


        //SENT
        if ($Model->Mail && $Model->MailApproval) {

            // JIKA di approve oleh signer (2) maka status mail menjadi terkirim (2) dan tertandatangani
            if ($Model->MailApproval->type == '2') {






                if($action == 'approve') {
                    $MailLogPositionUser = new MailLogPositionUser();
                    $MailLogPositionUser->table = 'mail';
                    $MailLogPositionUser->column = 'signer_id';
                    $MailLogPositionUser->master_id = $Model->Mail->id;
                    $MailLogPositionUser->position_name = $data_mail->signer->position->shortname;
                    $MailLogPositionUser->user_name = $data_mail->signer->position->user_without_position->name;
                    $MailLogPositionUser->user_golongan = $data_mail->signer->position->user_without_position->golongan;
                    $MailLogPositionUser->save();

                    $MailLogPositionUser = new MailLogPositionUser();
                    $MailLogPositionUser->table = 'mail';
                    $MailLogPositionUser->column = 'source_position_id';
                    $MailLogPositionUser->master_id = $Model->Mail->id;
                    $MailLogPositionUser->position_name = $data_mail->source_position->shortname;
                    $MailLogPositionUser->save();

                    foreach ($data_mail->approval as $key => $value) {
                        $MailLogPositionUser = new MailLogPositionUser();
                        $MailLogPositionUser->table = 'mail_approval';
                        $MailLogPositionUser->column = 'position_id';
                        $MailLogPositionUser->master_id = $value->id;
                        $MailLogPositionUser->position_name = $value->position->shortname;
                        $MailLogPositionUser->user_name = $value->position->user_without_position->name;
                        $MailLogPositionUser->user_golongan = $value->position->user_without_position->golongan;
                        $MailLogPositionUser->save();
                    }

                    foreach ($data_mail->mail_destination as $key => $value) {
                        $MailLogPositionUser = new MailLogPositionUser();
                        $MailLogPositionUser->table = 'mail_destination';
                        $MailLogPositionUser->column = 'position_id';
                        $MailLogPositionUser->master_id = $value->id;
                        $MailLogPositionUser->position_name = $value->position->shortname;
                        $MailLogPositionUser->user_name = $value->position->user_without_position->name;
                        $MailLogPositionUser->user_golongan = $value->position->user_without_position->golongan;
                        $MailLogPositionUser->save();
                    }
                }










                if(!empty(env('ESIGN_USE')) && env('ESIGN_USE') == 'Y') {
                    $location = 'lampiran_' . $Model->Mail->id . '/'.strtolower($MailTemplate->mail_code).'-'.$Model->Mail->id.'.pdf';
                    $pdf = PDF::loadView('app.pdf.surat.' . strtolower($MailTemplate->mail_code), $ParseData);
                    $pdf->setPaper('A4', 'portrait');
                    Storage::put($location, $pdf->output());

                    $cFileLocation = realpath('../') . '/storage/app/' . $location;
                    $cFileLocation = str_replace('\\', '/', $cFileLocation);

                    // ESIGN
                    $token = $Config['esign_token'];

                    $start_api = time();
                    $end_api = time();

                    try {
                        $passphrase = '';
                        if (!empty($request->input('passphrase'))) $passphrase = $request->input('passphrase');
                        $nik = '';
                        if (!empty($request->input('nik'))) {
                            $nik = $request->input('nik');

                            $User = User::where('id', Auth::user()->id)->first();
                            $User->nik = $nik;
                            $User->save();
                        }

                        $User = User::where('id', Auth::user()->id)->first();



                        $CURLOPT_URL = $Config['esign_url'] . 'api/sign/ds?nik='. $User->nik .'&passphrase=' .$passphrase. '&id_dokumen=' . $MailTemplate->esign_code;
                        // $CURLOPT_URL = 'http://esign-kemendagri.bit.co.id/api/sign/ds?nik=1111222233337777&passphrase=Qwerty!123&id_dokumen=2';


                        $start_api = time();
                        $curl = curl_init();
                        curl_setopt_array($curl, array(
                            CURLOPT_URL => $CURLOPT_URL,
                            CURLOPT_RETURNTRANSFER => true,
                            CURLOPT_ENCODING => "",
                            CURLOPT_MAXREDIRS => 10,
                            CURLOPT_TIMEOUT => 0,
                            CURLOPT_FOLLOWLOCATION => true,
                            // CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                            CURLOPT_POST => 1,
                            CURLOPT_POSTFIELDS => array('file'=> new CURLFILE($cFileLocation)),
                            CURLOPT_HTTPHEADER => array(
                            "Authorization: Bearer " . $token
                            ),
                        ));
                        $response = curl_exec($curl);
                        curl_close($curl);
                        $end_api = time();
                        $status = 200;
                    } catch (\Exception $e) {
                        $response = 'internal_server_error';
                        $status = 500;
                    }

                    $ApiLog = new ApiLog();
                    $ApiLog->status_code = $status;
                    $ApiLog->results = $response;
                    $ApiLog->duration = $end_api - $start_api;
                    $ApiLog->save();

                    if ($status == 200) {
                        $decode = json_decode($response);

                        if (!empty($decode->data->file_path)) {
                            $Model->Mail->signed_pdf_path = $decode->data->file_path;
                            $Model->Mail->save();
                        }
                    }
                }




            }
        }

        $data = ['type' => 'notification', 'text' => 'refresh'];
        $this->Broadcast($data);

        Json::set('data', $this->SyncData($request, $Model->Mail->id));
        return response()->json(Json::get(), 202);
    }

    public function RequestMailNumber(Request $request)
    {
        $Model = $request->Payload->all()['Model'];
        $Model->Mail->mail_number_status = '1';
        $Model->Mail->save();

        Json::set('data', $this->SyncData($request, $Model->Mail->id));
        return response()->json(Json::get(), 202);
    }

    public function CancelRequestMailNumber(Request $request)
    {
        $Model = $request->Payload->all()['Model'];
        $Model->Mail->mail_number_status = '0';
        $Model->Mail->save();

        Json::set('data', $this->SyncData($request, $Model->Mail->id));
        return response()->json(Json::get(), 202);
    }



    public function Dispose(Request $request)
    {
        $Model = $request->Payload->all()['Model'];

        // Create Mail
        $Model->Mail->save();

        $MailTemplate = MailTemplate::where('id', $Model->Mail->mail_template_id)->first();
        $CurrentPosition = Position::where('id', Auth::user()->position_id)->first();

        foreach ($Model->MailDetail as $key => $MailDetailData) {
            $MailDetail = new MailDetail();
            $MailDetail->mail_id = $Model->Mail->id;
            $MailDetail->key = $MailDetailData->key;
            $MailDetail->value = $MailDetailData->value;
            $MailDetail->save();
        }

        // // Create Disposition
        $Model->MailDisposition->mail_id = $Model->Mail->id;
        $Model->MailDisposition->save();

        // NOTIFICATION
        $notification_id = $this->createNotif('', 'DISPOSED', $Model->Mail->mail_template_id, $Model->MailDisposition->id);

        foreach ($Model->MailDispositionDestination as $key => $value) {
            $agenda_number = $this->getTransactionNumber('AGENDA-' . $value);

            $MailTo = new MailTo();
            $MailTo->mail_id = $Model->Mail->id;
            $MailTo->destination_position_id = $value;
            $MailTo->agenda_number = $agenda_number['value'];
            $MailTo->status = 0; // Secara default masih belum terbaca
            $MailTo->type = 2; // 2 berarti disposisi
            $MailTo->save();

            // NOTIFICATION
            $this->sendNotifUser($notification_id, $value);
        }

        $data = ['type' => 'notification', 'text' => 'refresh'];
        $this->Broadcast($data);

        Json::set('data', ['id' => $Model->MailDisposition->id]);
        return response()->json(Json::get(), 202);
    }

    public function Reject(Request $request)
    {
        $Model = $request->Payload->all()['Model'];
        $Model->Mail->save();

        $Model->MailApproval->status = '6';
        $Model->MailApproval->rejected_at = date('Y-m-d H:i:s');
        $Model->MailApproval->save();
        // 0.Pending. 1.receive 2.read, 3.approve, 4.receive reject, 5. read reject , 6. reject

        $CurrentPosition = Position::where('id', Auth::user()->position_id)->first();
        $MailTemplate = MailTemplate::where('id', $Model->Mail->mail_template_id)->first();

        if (!empty($Model->NextMailApproval)) {
            $Model->NextMailApproval->status = '4';
            $Model->NextMailApproval->save();

            // NOTIFICATION
            $notification_id = $this->createNotif($Model->Mail->id, 'REJECTED-TO-APPROVER', $Model->Mail->mail_template_id);
            $this->sendNotifUser($notification_id, $Model->NextMailApproval->position_id);

            $this->sendNotifUser($notification_id, '', $Model->Mail->created_user_id);

        } else {

            $CreatedUser = User::where('id', $Model->Mail->created_user_id)->first();

            // NOTIFICATION
            $notification_id = $this->createNotif($Model->Mail->id, 'REJECTED-TO-MAKER', $Model->Mail->mail_template_id);
            $this->sendNotifUser($notification_id, $CreatedUser->position_id);
        }

        $data = ['type' => 'notification', 'text' => 'refresh'];
        $this->Broadcast($data);

        Json::set('data', $this->SyncData($request, $Model->Mail->id));
        return response()->json(Json::get(), 202);
    }

    public function MakerSend(Request $request)
    {
        $Model = $request->Payload->all()['Model'];
        $Model->Mail->save();

        if(!empty($Model->NextMailApproval)) {
            $Model->NextMailApproval->status = 1;
            $Model->NextMailApproval->save();

            $CurrentPosition = Position::where('id', Auth::user()->position_id)->first();
            $MailTemplate = MailTemplate::where('id', $Model->Mail->mail_template_id)->first();

            // NOTIFICATIOn
            $notification_id = $this->createNotif($Model->Mail->id, 'RE-SEND', $Model->Mail->mail_template_id);
            $this->sendNotifUser($notification_id, $Model->NextMailApproval->position_id);
        }

        Json::set('data', $this->SyncData($request, $Model->Mail->id));
        return response()->json(Json::get(), 202);
    }

    public function SyncData($request, $id)
    {
        $QueryRoute = QueryRoute($request);
        $QueryRoute->ArrQuery->set = 'first';
        $QueryRoute->ArrQuery->id = $id;
        $data = $this->get($QueryRoute);
        return $data->original['data']['records'];
    }

    public function clearMailtransaction () {
        Mail::query()->delete();
        MailTo::query()->delete();
        MailDetail::query()->delete();
        MailCopyTo::query()->delete();
        MailApproval::query()->delete();
        MailPrinciple::query()->delete();
        MailDocument::query()->delete();
        MailLogPositionUser::query()->delete();
        Notification::query()->delete();
        Notificationuser::query()->delete();

        Json::set('data', 'OK');
        return response()->json(Json::get(), 200);
    }

    public function createLampiran($Model, Request $request) {
        // CEK STORAGE
        $StorageDB = StorageDB::where('name', 'lampiran_peserta_undangan['.$Model->Mail->id.'].pdf')->first();

        $isIssetDocument = false;
        if (!empty($StorageDB->id))
        {
            // CEK STORAGE
            // $StorageDB = StorageDB::where('name', 'lampiran_peserta_undangan['.$Model->Mail->id.'].pdf')->first();
            if (!empty($StorageDB->id))
            {
                // CEK STORAGE
                $MailDocument = MailDocument::where('object', 'lampiran')
                    ->where('object_id', $Model->Mail->id)
                    ->where('storage_id', $StorageDB->id)
                    ->first();

                if (!empty($MailDocument->id))
                {
                    $isIssetDocument = true;
                }
            }
        }

        if(!$isIssetDocument) {
            $KeyName = GenerateKey::Random('', 64);
        } else {
            $KeyName = $StorageDB->key;
        }

        $ParseData['mail_destination'] = MailTo::where('mail_id', $Model->Mail->id)->with('position')->get();
        $ParseData['mail'] = $Model->Mail;
        $pdf = PDF::loadView('app.pdf.surat.lampiran_surat', $ParseData);
        $pdf->setPaper('A4', 'portrait');
        Storage::put('lampiran_' . $Model->Mail->id . '/'.$KeyName.'.pdf', $pdf->output());


        // INSERT
        if (!$isIssetDocument) {
            // SAVE STORAGE
            $StorageDB = new StorageDB();
            $StorageDB->type = 'file';
            $StorageDB->name = 'lampiran_peserta_undangan['.$Model->Mail->id.'].pdf';
            $StorageDB->original_name = $KeyName.'.pdf';
            $StorageDB->key = $KeyName;
            $StorageDB->user_id = Auth::user()->id;
            $StorageDB->extension = 'pdf';
            $StorageDB->size = 100;
            $StorageDB->mimetype = 'application/pdf';
            $StorageDB->save();

            // SAVE DOCUMENT
            $MailDocument = new MailDocument();
            $MailDocument->object_id = $Model->Mail->id;
            $MailDocument->object = 'lampiran';
            $MailDocument->storage_id = $StorageDB->id;
            $MailDocument->save();
        }
    }

    public function SaveMailNumber(Request $request) {
        $Model = $request->Payload->all()['Model'];
        $Model->Mail->mail_number_status = '3';
        $Model->Mail->mail_number_created_at = date('Y-m-d H:i:s');
        $Model->Mail->mail_number_created_by = Auth::user()->id;
        $Model->Mail->save();

        Json::set('data', $this->SyncData($request, $Model->Mail->id));
        return response()->json(Json::get(), 202);
    }
}
