<?php

namespace App\Http\Controllers\MailTemplate;

use App\Models\MailTemplate;

use App\Traits\Browse;
use App\Traits\MailTemplate\MailTemplateCollection;

use Carbon\Carbon;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use App\Support\Response\Json;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;
use DB;

use Illuminate\Support\Facades\Auth;

class MailTemplateBrowseController extends Controller
{
    use Browse, MailTemplateCollection {
        MailTemplateCollection::__construct as private __MailTemplateCollectionConstruct;
    }

    protected $search = [];

    public function __construct(Request $request)
    {
        if ($request) {
            $this->_Request = $request;
        }
        $this->__MailTemplateCollectionConstruct();
    }

    public function get(Request $request)
    {
        $Now = Carbon::now();
        $MailTemplate = MailTemplate::where(function ($query) use($request) {
            if (isset($request->ArrQuery->id)) {
                $query->where("$this->MailTemplateTable.id", $request->ArrQuery->id);
            }

            if (!empty($request->ArrQuery->mail_type)) {
                $query->where("$this->MailTemplateTable.mail_type", $request->ArrQuery->mail_type);
            }
        })
        ->select(
            "$this->MailTemplateTable.id as mail_template.id",
            "$this->MailTemplateTable.name as mail_template.name",
            "$this->MailTemplateTable.content as mail_template.content",
            "$this->MailTemplateTable.mail_type as mail_template.mail_type",
            "$this->MailTemplateTable.mail_code as mail_template.mail_code",
            "$this->MailTemplateTable.esign_code as mail_template.esign_code"
        );

        $Browse = $this->Browse($request, $MailTemplate, function ($data) use($request) {
           $data = $this->Manipulate($data);
           if (isset($request->ArrQuery->for) && ($request->ArrQuery->for === 'select')) {
               return $data->map(function($MailTemplate) {
                   return [ 'value' => $MailTemplate->id, 'label' => $MailTemplate->name ];
               });
           } else {
               $data = $this->GetMailTemplateDetails($data);
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
                $this->Group($item, $key, 'mail_template.', $item);
            }
            return $item;
        });
    }
}
