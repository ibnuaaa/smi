<?php

namespace App\Http\Middleware\User;

use App\Models\User;

use Closure;
use Validator;
use Illuminate\Support\Facades\Storage;
use App\Http\Middleware\BaseMiddleware;



class ResetPassword extends BaseMiddleware
{
    private function Initiate()
    {
        $md5 =  md5(time());

        $this->Model->User = User::find($this->_Request->input('user_id'));
        $this->Model->User->password = substr($md5, 0,5);
    }

    private function Validation()
    {
        $validator = Validator::make($this->_Request->all(), [
            'user_id' => 'required'
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
