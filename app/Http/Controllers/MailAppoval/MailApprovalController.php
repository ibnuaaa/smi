<?php

namespace App\Http\Controllers\Mail;

use App\Models\Mail;
use App\Models\MailTo;
use App\Models\MailApproval;

use App\Traits\Browse;

use Illuminate\Http\Response;
use Illuminate\Http\Request;
use App\Support\Response\Json;
use Illuminate\Support\Facades\Hash;
use App\Support\Generate\Hash as KeyGenerator;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;

class MailApprovalController extends Controller
{
    use Browse;

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
        $Model->Mail->save();

        foreach ($Model->Approval as $key => $value) {
            $MailApproval = new MailApproval();
            $MailApproval->mail_id = $Model->Mail->id;
            $MailApproval->type = $value->type;
            $MailApproval->user_id = $value->user_id;
            $MailApproval->order_id = ($key + 1);

            // Checker Pertama akan mendapatkan mail untuk melakukan pengecekan
            $MailApproval->status = ($key === 0 ? 1 : 0);

            $MailApproval->save();
        }

        foreach ($Model->MailTo as $key => $value) {
            $MailTo = new MailTo();
            $MailTo->mail_id = $Model->Mail->id;
            $MailTo->destination_user_id = $value->user_id;
            $MailTo->save();
        }

        Json::set('data', $this->SyncData($request, $Model->Mail->id));
        return response()->json(Json::get(), 201);
    }

    public function Update(Request $request)
    {
        $Model = $request->Payload->all()['Model'];
        $Model->Mail->save();

        Json::set('data', $this->SyncData($request, $Model->Mail->id));
        return response()->json(Json::get(), 202);
    }

    public function Read(Request $request)
    {
        $Model = $request->Payload->all()['Model'];
        $Model->Mail->save();

        Json::set('data', $this->SyncData($request, $Model->Mail->id));
        return response()->json(Json::get(), 202);
    }

    public function Delete(Request $request)
    {
        $Model = $request->Payload->all()['Model'];
        $Model->Mail->delete();
        return response()->json(Json::get(), 202);
    }

    public function Approve(Request $request)
    {
        $Model = $request->Payload->all()['Model'];

        $Model->Mail->save();

        $Model->MailApproval->status = '3';
        $Model->MailApproval->save();
        // 0.Pending. 1.receive 2.read, 3.approve, 4.reject

        if (!empty($Model->NextMailApproval)) {
            $Model->NextMailApproval->status = '1';
            $Model->NextMailApproval->save();
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
}
