<?php

namespace App\Http\Controllers\MailDisposition;

use App\Models\MailDisposition;

use App\Traits\Browse;
use App\Traits\MailDisposition\MailDispositionCollection;

use Carbon\Carbon;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use App\Support\Response\Json;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;
use DB;

use Illuminate\Support\Facades\Auth;

class MailDispositionBrowseController extends Controller
{
    use Browse, MailDispositionCollection {
        MailDispositionCollection::__construct as private __MailDispositionCollectionConstruct;
    }

    protected $search = [];

    public function __construct(Request $request)
    {
        if ($request) {
            $this->_Request = $request;
        }
        $this->__MailDispositionCollectionConstruct();
    }

    public function get(Request $request)
    {
        $Now = Carbon::now();

        $MailDisposition = MailDisposition::where(function ($query) use($request) {
            if (isset($request->ArrQuery->id)) {
                $query->where("$this->MailDispositionTable.id", $request->ArrQuery->id);
            }

            if (isset($request->ArrQuery->mail_id)) {
                $query->where("$this->MailDispositionTable.mail_id", $request->ArrQuery->mail_id);
            }

            if (isset($request->ArrQuery->master_mail_id)) {
                $query->where("$this->MailDispositionTable.master_mail_id", $request->ArrQuery->master_mail_id);
            }

        })
        ->select(
            // MailDisposition
            "$this->MailDispositionTable.id as mail.id",
            "$this->MailDispositionTable.mail_id as mail.mail_id",
            "$this->MailDispositionTable.parent_mail_id as mail.parent_mail_id",
            "$this->MailDispositionTable.master_mail_id as mail.master_mail_id",
            "$this->MailDispositionTable.disposition_position as mail.disposition_position"
        )
        ->with('history')
        ->with('disposition_by');

       $Browse = $this->Browse($request, $MailDisposition, function ($data) use($request) {
           $data = $this->Manipulate($data);
           if (isset($request->ArrQuery->for) && ($request->ArrQuery->for === 'select')) {
               return $data->map(function($MailDisposition) {
                   return [ 'value' => $MailDisposition->id, 'label' => $MailDisposition->name ];
               });
           } else {
               $data = $this->GetMailDispositionDetails($data);
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
