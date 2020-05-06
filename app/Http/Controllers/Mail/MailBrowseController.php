<?php

namespace App\Http\Controllers\Mail;

use App\Models\Mail;

use App\Traits\Browse;
use App\Traits\Mail\MailCollection;

use Carbon\Carbon;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use App\Support\Response\Json;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;
use DB;

use Illuminate\Support\Facades\Auth;

class MailBrowseController extends Controller
{
    use Browse, MailCollection {
        MailCollection::__construct as private __MailCollectionConstruct;
    }

    protected $search = [
        'content',
        'about',
        'mail_number',
        'mail_number_int',
        'mail_number_ext'
    ];

    public function __construct(Request $request)
    {
        if ($request) {
            $this->_Request = $request;
        }
        $this->__MailCollectionConstruct();
    }

    public function get(Request $request)
    {
        $Now = Carbon::now();


        $fields = array(

            // Mail
            "$this->MailTable.id as mail.id",
            "$this->MailTable.mail_hash_code as mail.mail_hash_code",
            "$this->MailTable.source_position_id as mail.source_position_id",
            "$this->MailTable.source_external as mail.source_external",
            "$this->MailTable.mail_to as mail.mail_to",
            DB::raw("DATE_FORMAT(mail_date, '%d %M %Y') as mail_mail_date"),

            "$this->MailTable.mail_date as mail.mail_date",
            "$this->MailTable.receive_date as mail.receive_date",

            DB::raw("DATE_FORMAT(mail_date, '%Y-%m-%d') as mail_date_date"),
            DB::raw("DATE_FORMAT(receive_date, '%Y-%m-%d') as receive_date_date"),

            "$this->MailTable.mail_number as mail.mail_number",
            "$this->MailTable.mail_number_prefix as mail.mail_number_prefix",
            "$this->MailTable.mail_number_suffix as mail.mail_number_suffix",
            "$this->MailTable.mail_number_infix as mail.mail_number_infix",
            "$this->MailTable.mail_number_int as mail.mail_number_int",
            "$this->MailTable.mail_number_ext as mail.mail_number_ext",
            "$this->MailTable.content as mail.content",
            "$this->MailTable.creator_request_approval_at as mail.creator_request_approval_at",
            "$this->MailTable.mail_template_id as mail.mail_template_id",
            "$this->MailTable.created_user_id as mail.created_user_id",
            "$this->MailTable.status_approval as mail.status_approval",
            "$this->MailTable.status as mail.status",
            "$this->MailTable.privacy_type as mail.privacy_type",
            "$this->MailTable.copy_mail_to as mail.copy_mail_to",
            "$this->MailTable.about as mail.about",
            "$this->MailTable.tembusan as mail.tembusan",
            "$this->MailTable.updated_at as mail.updated_at",
            "$this->MailTable.created_at as mail.created_at",
            "$this->MailTable.notes as mail.notes",
            "$this->MailTable.signed_pdf_path as mail.signed_pdf_path",
            "$this->MailTable.mail_number_status as mail.mail_number_status",
            "$this->MailTable.sent_at as mail.sent_at",

            DB::raw("DATE_FORMAT(sent_at, '%d %M %Y') as mail_sent_at_date"),
            DB::raw("DATE_FORMAT(sent_at, '%H:%i') as mail_sent_at_time"),

            //mail_to
            // "a.name as user_mail_to_name",

            //copy_mail_to
            "b.name as user_copy_mail_to_name",

            //created_user_id
            "c.name as user_created_user_id_name",
            "c.username as user_created_user_id_username",
            "c.golongan as golongan_created_user_id_username",

            //jabatan
            "e.name as position_created_user_id_name"
        );


        if (isset($request->ArrQuery->for) && $request->ArrQuery->for == 'approval') {
            $fields[] = "d.status as approval_status";
        }

        if (isset($request->ArrQuery->for) && $request->ArrQuery->for == 'surat_masuk') {
            $fields[] = "d.status as surat_masuk_status";
        }

        $Mail = Mail::where(function ($query) use($request) {
            if (isset($request->ArrQuery->id)) {
                $query->where("$this->MailTable.id", $request->ArrQuery->id);
            }

            if (isset($request->ArrQuery->for) && $request->ArrQuery->for == 'approval') {
                $query->whereIn("$this->MailTable.status", [1,2,5,6]);

                $query->where("d.position_id", Auth::user()->position_id);
                //is_unread
                if (isset($request->ArrQuery->is_unread) && $request->ArrQuery->is_unread == 'y') {
                    $query->whereIn("d.status", array('1'));
                } else {
                    $query->whereNotIn("d.status", [0]);
                }

                //is_unapproved
                if (isset($request->ArrQuery->is_unapproved) && $request->ArrQuery->is_unapproved == 'y') {
                    $query->whereIn("d.status", array('1', '2'));
                } else {
                    $query->whereNotIn("d.status", [0]);
                }
            }

            if (isset($request->ArrQuery->for) && $request->ArrQuery->for == 'surat_masuk') {
                $query->where("$this->MailTable.status", '>=', '2');
                $query->where("d.destination_position_id", Auth::user()->position_id);
                // $query->where("mailto.destination_position_id", Auth::user()->position_id);

                //is_unread
                if (isset($request->ArrQuery->is_unread) && $request->ArrQuery->is_unread == 'y') {
                    $query->whereIn("d.status", array('0'));
                }
            }

            if (isset($request->ArrQuery->for) && $request->ArrQuery->for == 'approval_numbering') {
                $query->where("$this->MailTable.mail_number_status", '>=', '1');

                if (isset($request->ArrQuery->mail_number_status) && $request->ArrQuery->mail_number_status == 'receive_read') {
                    $query->whereIn("$this->MailTable.mail_number_status", [1,2]);
                }
            }



            if (isset($request->ArrQuery->for) && $request->ArrQuery->for == 'surat_keluar') {
                $query->where("$this->MailTable.created_user_id", Auth::user()->id);
            }

            if (isset($request->ArrQuery->mail_template_id)) {
                $query->where("$this->MailTable.mail_template_id", $request->ArrQuery->mail_template_id);
            }

            if (isset($request->ArrQuery->for) && $request->ArrQuery->for == 'disposition') {
                $query->where("$this->MailDispositionTable.disposition_position", Auth::user()->position_id);
                // $query->where("mailto.destination_position_id", Auth::user()->position_id);
            }

            if (isset($request->ArrQuery->for) && $request->ArrQuery->for == 'mail_disposition_replies' && $request->ArrQuery->disposition_id) {
                $query->where("$this->MailTable.disposition_id", $request->ArrQuery->disposition_id);
            }

            if (isset($request->ArrQuery->mail_hash_code)) {
                $query->where("$this->MailTable.mail_hash_code", $request->ArrQuery->mail_hash_code);
            }

            if (isset($request->ArrQuery->not_null)) {
                $query->whereNotNull($request->ArrQuery->not_null);
            }

            if (isset($request->ArrQuery->search)) {
               $search = '%' . $request->ArrQuery->search . '%';
               $query->where(function ($query) use($search, $request) {
                    foreach ($this->search as $key => $value) {
                       $query->orWhere($value, 'like', $search);
                    }

                    if (isset($request->ArrQuery->for) && $request->ArrQuery->for == 'surat_masuk') {
                        $query->orWhere('f.name', 'like', $search);
                    }

                    if (isset($request->ArrQuery->for) && $request->ArrQuery->for == 'surat_keluar') {
                        $query->orWhere('a.name', 'like', $search);
                    }

               });
            }
        })


        // ->leftJoin($this->MailToTable . ' as mailto', "mailto.mail_id", "$this->MailTable.id")
        // ->leftJoin($this->PositionTable . ' as a', "a.id", "mailto.destination_position_id")

        ->leftJoin($this->UserTable . ' as b', "b.id", "$this->MailTable.copy_mail_to")
        ->leftJoin($this->UserTable . ' as c', "c.id", "$this->MailTable.created_user_id")
        ->leftJoin($this->PositionTable . ' as e', "e.id", "c.position_id")
        ->leftJoin($this->PositionTable . ' as f', "f.id", "$this->MailTable.source_position_id")
        ->select($fields)
        ->with('approval')
        ->with('principle')
        ->with('disposition')
        ->with('disposition_destination')
        ->with('source_position')
        ->with('mail_destination')
        ->with('mail_copy_to')
        ->with('signer')
        ->with('mail_detail')
        ->with('lampiran')
        ->with('my_inbox')
        ->with('my_approval')
        ->with('history_signer')
        ->with('history_source_position')
        ->with('created_user')
        ->with('template');

        if(!empty($request->get('sort'))) {
            if(!empty($request->get('sort_type'))) {
                if ($request->get('sort') == 'tanggal') $Mail->orderBy("$this->MailTable.mail_date", $request->get('sort_type'));
                else if ($request->get('sort') == 'no') $Mail->orderBy("$this->MailTable.mail_number", $request->get('sort_type'));
                else if ($request->get('sort') == 'hal') $Mail->orderBy("$this->MailTable.about", $request->get('sort_type'));
                else if ($request->get('sort') == 'status') $Mail->orderBy("$this->MailTable.status", $request->get('sort_type'));
            }
        } else {
            $Mail->orderBy("$this->MailTable.id", 'desc');
        }

        if (isset($request->ArrQuery->for) && $request->ArrQuery->for == 'approval') {
            $Mail->leftJoin($this->MailApprovalTable . ' as d', "d.mail_id", "$this->MailTable.id");
        }

        if (isset($request->ArrQuery->for) && $request->ArrQuery->for == 'surat_masuk') {
            $Mail->leftJoin($this->MailToTable . ' as d', "d.mail_id", "$this->MailTable.id");
        }

        if (isset($request->ArrQuery->for) && $request->ArrQuery->for == 'surat_keluar') {
            $Mail->leftJoin($this->MailToTable . ' as d', "d.mail_id", "$this->MailTable.id");
            $Mail->leftJoin($this->PositionTable . ' as a', "a.id", "d.destination_position_id");
        }

        if (isset($request->ArrQuery->for) && $request->ArrQuery->for == 'disposition') {
            $Mail->leftJoin($this->MailDispositionTable, "$this->MailDispositionTable.mail_id", "$this->MailTable.id");
        }

        $Browse = $this->Browse($request, $Mail, function ($data) use($request) {
           $data = $this->Manipulate($data);
           if (isset($request->ArrQuery->for) && ($request->ArrQuery->for === 'select')) {
               return $data->map(function($Mail) {
                   return [ 'value' => $Mail->id, 'label' => $Mail->name ];
               });
           } else {
               $data = $this->GetMailDetails($data);
           }
           return $data;
        });


       Json::set('data', $Browse);
       return response()->json(Json::get(), 200);
    }

    private function Manipulate($records)
    {
        return $records->map(function ($item) {
            foreach ($item->getAttributes() as $key => $value) {
                $this->Group($item, $key, 'mail.', $item);
            }
            return $item;
        });
    }
}
