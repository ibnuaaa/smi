<?php

namespace App\Http\Controllers\MailDispositionReply;

use App\Models\MailDispositionReply;

use App\Traits\Browse;

use Illuminate\Http\Response;
use Illuminate\Http\Request;
use App\Support\Response\Json;
use Illuminate\Support\Facades\Hash;
use App\Support\Generate\Hash as KeyGenerator;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;

class MailDispositionReplyController extends Controller
{
    use Browse;

    protected $search = [];
    public function get(Request $request)
    {
        $MailDispositionReply = MailDispositionReply::where(function ($query) use($request) {
            if (isset($request->ArrQuery->id)) {
                $query->where('id', $request->ArrQuery->id);
            }
        });
        $Browse = $this->Browse($request, $MailDispositionReply, function ($data) use($request) {
            $data->map(function($MailDispositionReply) {
                return $MailDispositionReply;
            });
            return $data;
        });
        Json::set('data', $Browse);
        return response()->json(Json::get(), 200);
    }


    public function Insert(Request $request)
    {
        $Model = $request->Payload->all()['Model'];
        $Model->MailDispositionReply->master_mail_id = $Model->MailDispositionReply->master_mail_id;
        $Model->MailDispositionReply->messages = $Model->MailDispositionReply->messages;
        $Model->MailDispositionReply->created_user_id = MyAccount()->id;
        $Model->MailDispositionReply->save();

        Json::set('data', $this->SyncData($request, $Model->MailDispositionReply->id));
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



}
