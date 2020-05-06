<?php

namespace App\Http\Middleware\Mail;

use App\Models\Mail;
use App\Models\MailApproval;

use Closure;
use Validator;
use Illuminate\Support\Facades\Storage;
use App\Http\Middleware\BaseMiddleware;

use Illuminate\Support\Facades\Auth;

class MakerSend extends BaseMiddleware
{
    private function Initiate()
    {
        $this->Model->Mail = Mail::find($this->_Request->input('mail_id'));

        if ($this->Model->Mail) {
            if (!empty($this->_Request->input('is_upload_surat_masuk')) && $this->_Request->input('is_upload_surat_masuk') == 'y') {
                $this->Model->Mail->status = 2;
                $this->Model->Mail->status_approval = 2;
            }
            else $this->Model->Mail->status = 1;
            $this->Model->Mail->creator_request_approval_at = date('Y-m-d H:i:s');

            $this->Model->NextMailApproval = MailApproval::
                where('mail_id', $this->_Request->input('mail_id'))
                ->where('status', 6)
                ->orderBy('order_id', 'asc')
                ->first();
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
