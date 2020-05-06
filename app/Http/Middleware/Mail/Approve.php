<?php

namespace App\Http\Middleware\Mail;

use App\Models\Mail;
use App\Models\MailApproval;

use Closure;
use Validator;
use Illuminate\Support\Facades\Storage;
use App\Http\Middleware\BaseMiddleware;

use Illuminate\Support\Facades\Auth;

class Approve extends BaseMiddleware
{
    private function Initiate()
    {
        $this->Model->Mail = Mail::find($this->_Request->input('mail_id'));

        $this->Model->MailApproval = MailApproval::
            where('mail_id', $this->_Request->input('mail_id'))
            ->where('position_id', Auth::user()->position_id)
            // ->whereIn('status', [1,2,4,5])
            ->first();

        $this->Model->NextMailApproval = MailApproval::
            where('mail_id', $this->_Request->input('mail_id'))
            ->whereIn('status', [0,6])
            ->orderBy('order_id', 'asc')
            ->first();

        // yang valid adalah :
        // yang status nya 1
        // yang user_id nya sesuai dengan yang login

        if ($this->Model->Mail && $this->Model->MailApproval) {
            // 1. checker 2.signer 3.approved
            $this->Model->Mail->status_approval = $this->Model->MailApproval->type;

            // JIKA di approve oleh signer (2) maka status mail menjadi terkirim (2)
            if ($this->Model->MailApproval->type == '2') {
                $this->Model->Mail->status = 2;
                $this->Model->Mail->sent_at = date('Y-m-d H:i:s');
            }
        }
    }

    private function Validation()
    {
        $validator = Validator::make($this->_Request->all(), [
            'mail_id' => 'required',
        ]);
        if ($validator->fails()) {
            $this->Json::set('errors', $validator->errors());
            return false;
        }
        if (!$this->Model->Mail) {
            $this->Json::set('exception.code', 'NotFoundMail');
            $this->Json::set('exception.message', trans('validation.'.$this->Json::get('exception.code')));
            return false;
        }

        if ($this->_Request->input('action') == 'approve') {
            if (!$this->Model->MailApproval) {
                $this->Json::set('exception.code', 'NotFoundUserApproval');
                $this->Json::set('exception.message', trans('validation.'.$this->Json::get('exception.code')));
                return false;
            }
        }

        return true;
    }

    public function handle($request, Closure $next)
    {
        $this->Initiate();
        if ($this->Validation()) {
            $this->Payload->put('Model', $this->Model);
            $this->_Request->merge(['Payload' => $this->Payload]);
            return $next($this->_Request);
        } else {
            return response()->json($this->Json::get(), $this->HttpCode);
        }
    }
}
