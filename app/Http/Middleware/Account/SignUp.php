<?php

namespace App\Http\Middleware\Account;

use App\Models\User;
use App\Models\Member;

use Closure;
use Validator;
use Illuminate\Support\Facades\Storage;
use App\Http\Middleware\BaseMiddleware;

class SignUp extends BaseMiddleware
{
    private function Initiate()
    {
        $this->Model->User = new User();
        $this->Model->Member = new Member();

        $this->Model->User->name = $this->_Request->input('name');
        $this->Model->User->name = $this->_Request->input('name');
        $this->Model->User->username = $this->_Request->input('username');
        $this->Model->User->email = $this->_Request->input('email');
        $this->Model->Member->phone_number = $this->_Request->input('phone_number');
        $this->Model->User->password = $this->_Request->input('password');
    }

    private function Validation()
    {
        $validator = Validator::make($this->_Request->all(), [
            'name' => 'required|max:255',
            'username' => 'required|unique:users|max:255',
            'email' => 'required|unique:users|max:255',
            'phone_number' => 'required|unique:members|max:20',
            'password' => 'required|min:6|max:255|regex:/^(?=.*[a-z])(?=.*\d).+$/'
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
