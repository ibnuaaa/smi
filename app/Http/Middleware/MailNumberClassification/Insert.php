<?php

namespace App\Http\Middleware\MailNumberClassification;

use App\Models\MailNumberClassification;

use Closure;
use Validator;
use Illuminate\Support\Facades\Storage;
use App\Http\Middleware\BaseMiddleware;

class Insert extends BaseMiddleware
{
    private function Initiate()
    {
        $this->Model->MailNumberClassification = new MailNumberClassification();

        $this->Model->MailNumberClassification->code = $this->_Request->input('code');
        $this->Model->MailNumberClassification->name = $this->_Request->input('name');
    }

    private function Validation()
    {
        $validator = Validator::make($this->_Request->all(), [
            'code' => 'required',
            'name' => 'required'
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
