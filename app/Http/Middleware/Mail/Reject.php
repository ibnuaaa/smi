<?php

namespace App\Http\Middleware\Mail;

use App\Models\Mail;
use App\Models\MailApproval;

use Closure;
use Validator;
use Illuminate\Support\Facades\Storage;
use App\Http\Middleware\BaseMiddleware;

use Illuminate\Support\Facades\Auth;

class Reject extends BaseMiddleware
{
    private function Initiate()
    {
        $this->Model->Mail = Mail::find($this->_Request->input('mail_id'));

        $this->Model->MailApproval = MailApproval::
            where('mail_id', $this->_Request->input('mail_id'))
            ->where('position_id', Auth::user()->position_id)
            ->whereIn('status', [1,2,4,5])
            ->first();

        $this->Model->NextMailApproval = MailApproval::
            where('mail_id', $this->_Request->input('mail_id'))
            ->where('status', 3)
            ->orderBy('order_id', 'desc')
            ->first();

        $this->Model->MailApproval->reject_reason = $this->_Request->input('reject_reason');

        if (empty($this->Model->NextMailApproval)) {
            //JIKA semuanya sudah mereject, maka status suratnya nya reject
            $this->Model->Mail->status = 6;
        }
    }

    private function Validation()
    {
        $validator = Validator::make($this->_Request->all(), [
            'mail_id' => 'required',
            // 'reject_reason' => 'required'
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

        if (!$this->Model->MailApproval) {
            $this->Json::set('exception.code', 'NotFoundUserRejection');
            $this->Json::set('exception.message', trans('validation.'.$this->Json::get('exception.code')));
            return false;
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
