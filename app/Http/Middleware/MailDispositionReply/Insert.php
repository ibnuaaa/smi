<?php

namespace App\Http\Middleware\MailDispositionReply;

use App\Models\MailDispositionReply;

use Closure;
use Validator;
use Illuminate\Support\Facades\Storage;
use App\Http\Middleware\BaseMiddleware;

class Insert extends BaseMiddleware
{
    private function Initiate()
    {
        $this->Model->MailDispositionReply = new MailDispositionReply();
        $this->Model->MailDispositionReply->master_mail_id = $this->_Request->input('master_mail_id');
        $this->Model->MailDispositionReply->messages = $this->_Request->input('messages');
        $this->Model->MailDispositionReply->disposition_id = $this->_Request->input('disposition_id');

    }

    private function Validation()
    {
        $validator = Validator::make($this->_Request->all(), [
            'master_mail_id' => 'required',
            'messages' => 'required'
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
