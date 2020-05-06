<?php

namespace App\Http\Controllers\MailDispositionFollowUp;

use App\Models\MailDispositionFollowUp;

use App\Traits\Browse;
use App\Traits\MailDispositionFollowUp\MailDispositionFollowUpCollection;

use Carbon\Carbon;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use App\Support\Response\Json;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Auth;

class MailDispositionFollowUpBrowseController extends Controller
{
    use Browse, MailDispositionFollowUpCollection {
        MailDispositionFollowUpCollection::__construct as private __MailDispositionFollowUpCollectionConstruct;
    }

    protected $search = [
        'code',
        'name'
    ];

    public function __construct(Request $request)
    {
        if ($request) {
            $this->_Request = $request;
        }
        $this->__MailDispositionFollowUpCollectionConstruct();
    }

    public function get(Request $request)
    {
        $Now = Carbon::now();
        if (!isset($request->OriginalArrQuery->take)) {
            $request->ArrQuery->take = 5000;
        }

        $MailDispositionFollowUp = MailDispositionFollowUp::where(function ($query) use($request) {
            if (isset($request->ArrQuery->disposition_type)) {
                $query->where("$this->MailDispositionFollowUpTable.disposition_type", $request->ArrQuery->disposition_type);
            }
       })
       ->select(
            // MailDispositionFollowUp
            "$this->MailDispositionFollowUpTable.id as mail.id",
            "$this->MailDispositionFollowUpTable.code as mail_disposition_follow_up.code",
            "$this->MailDispositionFollowUpTable.name as mail_disposition_follow_up.name"
       );

       $Browse = $this->Browse($request, $MailDispositionFollowUp, function ($data) use($request) {
           $data = $this->Manipulate($data);
           return $data;
       });
       Json::set('data', $Browse);
       return response()->json(Json::get(), 200);
    }

    private function Manipulate($records)
    {
        return $records->map(function ($item) {
            foreach ($item->getAttributes() as $key => $value) {
                $this->Group($item, $key, 'mail_disposition_follow_up.', $item);
            }
            return $item;
        });
    }
}
