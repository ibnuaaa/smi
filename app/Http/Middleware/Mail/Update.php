<?php

namespace App\Http\Middleware\Mail;

use App\Models\Mail;

use Closure;
use Validator;
use Illuminate\Support\Facades\Storage;
use App\Http\Middleware\BaseMiddleware;
use Illuminate\Support\Facades\Auth;

class Update extends BaseMiddleware
{
    private function Initiate()
    {
        $this->Model->Mail = Mail::find($this->Id);

        if ($this->Model->Mail) {
            if(!empty($this->_Request->input('source_external')))  $this->Model->Mail->source_external = $this->_Request->input('source_external');
            $this->Model->Mail->source_position_id = $this->_Request->input('source_position_id');

            $this->Model->Mail->mail_date = $this->_Request->input('mail_date') ? $this->_Request->input('mail_date') : date('Y-m-d');
            if (!empty($this->_Request->input('receive_date'))) $this->Model->Mail->receive_date = $this->_Request->input('receive_date');


            $this->Model->Mail->mail_number_prefix = $this->_Request->input('mail_number_prefix');
            $this->Model->Mail->mail_number_suffix = $this->_Request->input('mail_number_suffix');

            if(!empty($this->_Request->input('mail_number_ext'))) $this->Model->Mail->mail_number_ext = $this->_Request->input('mail_number_ext');
            if(!empty($this->_Request->input('mail_number_int'))) $this->Model->Mail->mail_number_int = $this->_Request->input('mail_number_int');

            $content = $this->_Request->input('content');
            $content = str_replace('<figure class="table">', '', $content);
            $content = str_replace('</figure>', '', $content);
            $content = str_replace('<p>', '', $content);
            $content = str_replace('</p>', '', $content);

            $this->Model->Mail->content = $content;
            $this->Model->Mail->status_approval = $this->_Request->input('status_approval');

            if (MyAccount()->id == $this->Model->Mail->created_user_id) {
                $this->Model->Mail->status = !empty($this->_Request->input('action')) && $this->_Request->input('action') == 'kirim' ? '1' : '0' ;
            }

            if (!empty($this->_Request->input('action')) && $this->_Request->input('action') == 'kirim') {
                $this->Model->Mail->creator_request_approval_at = date('Y-m-d H:i:s');
            }

            $this->Model->Mail->privacy_type = $this->_Request->input('privacy_type');
            $this->Model->Mail->tembusan = $this->_Request->input('tembusan');
            $this->Model->Mail->about = $this->_Request->input('about');
            $this->Model->Approval = json_decode($this->_Request->input('approval'));
            $this->Model->MailTo = json_decode($this->_Request->input('mail_to'));
            $this->Model->MailCopyTo = json_decode($this->_Request->input('mail_copy_to'));
            $this->Model->MailPrinciple = json_decode($this->_Request->input('mail_principle'));

            $this->Model->action = $this->_Request->input('action');
        }
    }


    private function Validation()
    {
        $validator = Validator::make($this->_Request->all(), [
            'mail_to' => 'required',
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
