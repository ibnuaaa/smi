<?php

namespace App\Http\Middleware\Mail;

use App\Models\Mail;
use App\Models\MailApproval;

use Closure;
use Validator;
use Illuminate\Support\Facades\Storage;
use App\Http\Middleware\BaseMiddleware;

use Illuminate\Support\Facades\Auth;

class CancelRequestMailNumber extends BaseMiddleware
{
    private function Initiate()
    {
        $this->Model->Mail = Mail::find($this->_Request->input('mail_id'));
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
