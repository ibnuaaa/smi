<?php

namespace App\Http\Controllers\MailDispositionReply;

use App\Models\MailDispositionReply;

use App\Traits\Browse;
use App\Traits\MailDispositionReply\MailDispositionReplyCollection;

use Carbon\Carbon;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use App\Support\Response\Json;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;
use DB;

use Illuminate\Support\Facades\Auth;

class MailDispositionReplyBrowseController extends Controller
{
    use Browse, MailDispositionReplyCollection {
        MailDispositionReplyCollection::__construct as private __MailDispositionReplyCollectionConstruct;
    }

    protected $search = [];

    public function __construct(Request $request)
    {
        if ($request) {
            $this->_Request = $request;
        }
        $this->__MailDispositionReplyCollectionConstruct();
    }

    public function get(Request $request)
    {
        $Now = Carbon::now();
        $MailDispositionReply = MailDispositionReply::where(function ($query) use($request) {
            if (isset($request->ArrQuery->id)) {
                $query->where("$this->MailDispositionReplyTable.id", $request->ArrQuery->id);
            }
            if (isset($request->ArrQuery->master_mail_id)) {
                $query->where("$this->MailDispositionReplyTable.master_mail_id", $request->ArrQuery->master_mail_id);
            }

            if (isset($request->ArrQuery->disposition_id)) {
                $query->where("$this->MailDispositionReplyTable.disposition_id", $request->ArrQuery->disposition_id);
            }
        })
        ->select(
            "$this->MailDispositionReplyTable.id as mail_disposition_reply.id",
            "$this->MailDispositionReplyTable.created_user_id as mail_disposition_reply.created_user_id",
            "$this->MailDispositionReplyTable.messages as mail_disposition_reply.messages",
            "$this->MailDispositionReplyTable.created_at as mail_disposition_reply.created_at"
        )
        ->with('user')
        ->orderBY('id', 'desc');

        $Browse = $this->Browse($request, $MailDispositionReply, function ($data) use($request) {
           $data = $this->Manipulate($data);
           if (isset($request->ArrQuery->for) && ($request->ArrQuery->for === 'select')) {
               return $data->map(function($MailDispositionReply) {
                   return [ 'value' => $MailDispositionReply->id, 'label' => $MailDispositionReply->name ];
               });
           } else {
               $data = $this->GetMailDispositionReplyDetails($data);
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
                $this->Group($item, $key, 'mail_disposition_reply.', $item);
            }
            return $item;
        });
    }
}
