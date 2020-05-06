<?php

namespace App\Http\Middleware\User;

use App\Models\User;

use Closure;
use Validator;
use Illuminate\Support\Facades\Storage;
use App\Http\Middleware\BaseMiddleware;

class Password extends BaseMiddleware
{
    private function Initiate($request)
    {
        $this->Model->User = User::find($this->_Request->input('id'));
        if ($this->Model->User) {
            $this->Model->User->password = $this->_Request->input('password');
        }
    }

    private function Validation()
    {
        $validator = Validator::make($this->_Request->all(), [
            'id' => 'required',
            'password' => 'required|min:6|max:255|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/'
        ]);
        if (!$this->Model->User) {
            $this->Json::set('exception.code', 'NotFoundUser');
            $this->Json::set('exception.message', trans('validation.'.$this->Json::get('exception.code')));
            return false;
        }
        if ($validator->fails()) {
            $this->Json::set('errors', $validator->errors());
            return false;
        }

        return true;
    }

    public function handle($request, Closure $next)
    {
        $this->Initiate($request);
        if ($this->Validation()) {
            $this->Payload->put('Model', $this->Model);
            $this->_Request->merge(['Payload' => $this->Payload]);
            return $next($this->_Request);
        } else {
            return response()->json($this->Json::get(), $this->HttpCode);
        }
    }
}
