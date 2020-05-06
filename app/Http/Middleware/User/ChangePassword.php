<?php

namespace App\Http\Middleware\User;

use App\Models\User;
use App\Models\Position;
use App\Models\Blast\Category;

use Illuminate\Support\Facades\Hash;
use Closure;
use Validator;
use Illuminate\Support\Facades\Storage;
use App\Http\Middleware\BaseMiddleware;

use Illuminate\Support\Facades\Auth;

class ChangePassword extends BaseMiddleware
{
    private function Initiate($request)
    {
        $this->Model->User = User::where('id', Auth::user()->id)->first();
        $this->password = $this->_Request->input('password');

    }

    private function Validation()
    {
        $validator = Validator::make($this->_Request->all(), [
            'password' => 'min:4|max:255|regex:/^(?=.*[a-z])(?=.*\d).+$/',
            'new_password' => 'min:4|max:255|regex:/^(?=.*[a-z])(?=.*\d).+$/',
            'new_password_confirmation' => 'min:4|max:255|regex:/^(?=.*[a-z])(?=.*\d).+$/'
        ]);
        if (!$this->Model->User) {
            $this->Json::set('exception.code', 'NotFoundUser');
            $this->Json::set('exception.message', trans('validation.'.$this->Json::get('exception.code')));
            return false;
        }

        if (!Hash::check($this->password, $this->Model->User->password)) {
            $this->Json::set('exception.code', 'OldPasswordDidNotMatch');
            $this->Json::set('exception.message', trans('validation.'.$this->Json::get('exception.code')));
            return false;
        }


        if ($this->_Request->input('new_password') !=  $this->_Request->input('new_password_confirmation')) {
            $this->Json::set('exception.code', 'NotSameConfrmationPassword');
            $this->Json::set('exception.message', trans('validation.'.$this->Json::get('exception.code')));
            return false;
        }

        if ($validator->fails()) {
            $this->Json::set('errors', $validator->errors());
            return false;
        }
        if ($this->_Request->input('project_id') && !$this->Model->Position) {
            $this->Json::set('exception.code', 'NotFoundPosition');
            $this->Json::set('exception.message', trans('validation.'.$this->Json::get('exception.code')));
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
