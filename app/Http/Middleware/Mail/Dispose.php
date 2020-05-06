<?php

namespace App\Http\Middleware\Mail;

use App\Models\Mail;
use App\Models\MailDisposition;
use App\Models\MailApproval;

use Closure;
use Validator;
use Illuminate\Support\Facades\Storage;
use App\Http\Middleware\BaseMiddleware;

use Illuminate\Support\Facades\Auth;

class Dispose extends BaseMiddleware
{
    private function Initiate()
    {
        // CREATE MAIL
        $this->Model->Mail = new Mail();
        $this->Model->Mail->mail_template_id = 4;
        $this->Model->Mail->status_approval = 2;
        $this->Model->Mail->status = 2;
        $this->Model->Mail->mail_date = date('Y-m-d');
        $this->Model->Mail->source_position_id = Auth::user()->position_id;
        $this->Model->Mail->sent_at = date('Y-m-d H:');

        // MAIL DETAIL
        $this->Model->MailDetail = json_decode($this->_Request->input('mail_detail'));

        // CREATE DISPOSITION
        $this->Model->MailDisposition = new MailDisposition();

        // GET MAIL DISPOSITION
        $master_mail_id = $this->_Request->input('mail_id');
        $MailDisposition = MailDisposition::where('mail_id', $master_mail_id)->first();
        if ($MailDisposition) {
            $master_mail_id = $MailDisposition->master_mail_id;
        }

        $this->Model->MailDisposition->master_mail_id = $master_mail_id;
        $this->Model->MailDisposition->notes = $this->_Request->input('notes');
        $this->Model->MailDisposition->parent_mail_id = $this->_Request->input('mail_id');
        $this->Model->MailDisposition->disposition_date = date('Y-m-d H:i:s');
        $this->Model->MailDisposition->disposition_position = Auth::user()->position_id;

        //DISPOSITION DESTINATION
        $this->Model->MailDispositionDestination = json_decode($this->_Request->input('disposition_position'));
    }

    private function Validation()
    {
        $validator = Validator::make($this->_Request->all(), [
            'mail_id' => 'required'
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
