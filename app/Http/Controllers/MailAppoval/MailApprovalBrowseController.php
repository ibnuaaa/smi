<?php

namespace App\Http\Controllers\MailApproval;

use App\Models\MailApproval;

use App\Traits\Browse;
use App\Traits\MailApproval\MailApprovalCollection;

use Carbon\Carbon;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use App\Support\Response\Json;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;
use DB;

use Illuminate\Support\Facades\Auth;

class MailApprovalBrowseController extends Controller
{
    use Browse, MailApprovalCollection {
        MailApprovalCollection::__construct as private __MailApprovalCollectionConstruct;
    }

    protected $search = [];

    public function __construct(Request $request)
    {
        if ($request) {
            $this->_Request = $request;
        }
        $this->__MailApprovalCollectionConstruct();
    }

    public function get(Request $request)
    {
        if (isset($request->ArrQuery->view) && $request->ArrQuery->view === 'tree') {
            $Browse = MailApproval::tree();
        } else  {
            $Now = Carbon::now();

            $MailApproval = MailApproval::where(function ($query) use($request) {
                if (isset($request->ArrQuery->id)) {
                    $query->where("$this->MailApprovalTable.id", $request->ArrQuery->id);
                }

                if (isset($request->ArrQuery->for) && $request->ArrQuery->for == 'approval') {
                    $query->whereNotIn("d.status", [0]);
                    $query->where("d.user_id", Auth::user()->id);
                }

                if (isset($request->ArrQuery->for) && $request->ArrQuery->for == 'surat_masuk') {
                    $query->where("$this->MailApprovalTable.status", '>=', '2');
                    $query->where("d.destination_user_id", Auth::user()->id);
                }
           })
           ->leftJoin($this->UserTable . ' as a', "a.id", "$this->MailApprovalTable.mail_to")
           ->leftJoin($this->UserTable . ' as b', "b.id", "$this->MailApprovalTable.copy_mail_to")
           ->leftJoin($this->UserTable . ' as c', "c.id", "$this->MailApprovalTable.created_user_id")
           ->leftJoin($this->PositionTable . ' as e', "e.id", "c.position_id")
           ->select(
                // MailApproval
                "$this->MailApprovalTable.id as mail.id",
                "$this->MailApprovalTable.mail_to as mail.mail_to",
                DB::raw("DATE_FORMAT(mail_date, '%d %M %Y') as mail_mail_date"),
                "$this->MailApprovalTable.receive_date as mail.receive_date",
                "$this->MailApprovalTable.approved_at as mail.approved_at",
                "$this->MailApprovalTable.rejected_at as mail.rejected_at",
                "$this->MailApprovalTable.mail_number as mail.mail_number",
                "$this->MailApprovalTable.content as mail.content",
                "$this->MailApprovalTable.mail_template_id as mail.mail_template_id",
                "$this->MailApprovalTable.created_user_id as mail.created_user_id",
                "$this->MailApprovalTable.status_approval as mail.status_approval",
                "$this->MailApprovalTable.status as mail.status",
                "$this->MailApprovalTable.privacy_type as mail.privacy_type",
                "$this->MailApprovalTable.copy_mail_to as mail.copy_mail_to",
                "$this->MailApprovalTable.about as mail.about",
                "$this->MailApprovalTable.updated_at as mail.updated_at",
                "$this->MailApprovalTable.created_at as mail.created_at",

                //mail_to
                "a.name as user_mail_to_name",

                //copy_mail_to
                "b.name as user_copy_mail_to_name",

                //created_user_id
                "c.name as user_created_user_id_name",
                "c.username as user_created_user_id_username",
                "c.golongan as golongan_created_user_id_username",

                //jabatan
                "e.name as position_created_user_id_name"

           )
           ->with('approval')
           ->with('mail_destination');

            if (isset($request->ArrQuery->for) && $request->ArrQuery->for == 'approval') {
                $MailApproval->leftJoin($this->MailApprovalApprovalTable . ' as d', "d.mail_id", "$this->MailApprovalTable.id");
            }

            if (isset($request->ArrQuery->for) && $request->ArrQuery->for == 'surat_masuk') {
                $MailApproval->leftJoin($this->MailApprovalToTable . ' as d', "d.mail_id", "$this->MailApprovalTable.id");
            }

           $Browse = $this->Browse($request, $MailApproval, function ($data) use($request) {
               $data = $this->Manipulate($data);
               if (isset($request->ArrQuery->for) && ($request->ArrQuery->for === 'select')) {
                   return $data->map(function($MailApproval) {
                       return [ 'value' => $MailApproval->id, 'label' => $MailApproval->name ];
                   });
               } else {
                   $data = $this->GetMailApprovalDetails($data);
               }
               return $data;
           });
        }
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
