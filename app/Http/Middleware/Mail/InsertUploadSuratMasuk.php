<?php

namespace App\Http\Middleware\Mail;

use App\Models\Mail;

use Closure;
use Validator;
use Illuminate\Support\Facades\Storage;
use App\Http\Middleware\BaseMiddleware;
use Illuminate\Support\Facades\Auth;

class InsertUploadSuratMasuk extends BaseMiddleware
{
    private function Initiate()
    {
        $this->Model->Mail = new Mail();
        $this->Model->Mail->source_external = $this->_Request->input('source_external');
        $this->Model->Mail->mail_number_int = $this->_Request->input('mail_number_int');
        $this->Model->Mail->mail_number_ext = $this->_Request->input('mail_number_ext');
        $this->Model->Mail->mail_number = $this->_Request->input('mail_number');
        $this->Model->Mail->mail_date = $this->_Request->input('mail_date');
        $this->Model->Mail->receive_date = $this->_Request->input('receive_date');
        $this->Model->Mail->status_approval = 2;

        $this->Model->Mail->mail_template_id = 9;
        $this->Model->Mail->notes = $this->_Request->input('notes');
        $this->Model->Mail->about = $this->_Request->input('about');
        $this->Model->Mail->privacy_type = $this->_Request->input('privacy_type');
        $this->Model->Mail->created_user_id = Auth::user()->id;

        $this->Model->MailTo = json_decode($this->_Request->input('mail_to'));
        $this->Model->action = $this->_Request->input('action');
    }

    private function Validation()
    {
        $validator = Validator::make($this->_Request->all(), [
            'source_external' => 'required',
        ]);
        if ($validator->fails()) {
            $this->Json::set('errors', $validator->errors());
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
