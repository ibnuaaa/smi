<?php

namespace App\Http\Middleware\User;

use App\Models\User;
use App\Models\Position;

use Closure;
use Validator;
use Illuminate\Support\Facades\Storage;
use App\Http\Middleware\BaseMiddleware;

class Insert extends BaseMiddleware
{
    private function Initiate()
    {
        $this->Model->User = new User();

        $this->Model->User->name = $this->_Request->input('name');
        $this->Model->User->username = $this->_Request->input('username');
        $this->Model->User->email = $this->_Request->input('email');
        $this->Model->User->password = $this->_Request->input('password');
        $this->Model->User->position_id = $this->_Request->input('position_id');
        $this->Model->User->gender = $this->_Request->input('gender');
        $this->Model->User->satker = $this->_Request->input('satker');
        $this->Model->User->golongan = $this->_Request->input('golongan');
        $this->Model->User->jenis_user = $this->_Request->input('jenis_user');
        $this->Model->User->status = 'active';

        $this->Model->Position = Position::where('id', $this->Model->User->position_id)->first();
    }

    private function Validation()
    {
        $validator = Validator::make($this->_Request->all(), [
            'username' => 'required|unique:users|max:255',
            'name' => 'required|max:255',
            'email' => 'unique:users|max:255',
            'password' => 'required|min:6|max:255|regex:/^(?=.*[a-z])(?=.*\d).+$/',
            'position_id' => ['required'],
            'gender' => ['required', 'in:male,female'],
        ]);
        if ($validator->fails()) {
            $this->Json::set('errors', $validator->errors());
            return false;
        }
        if (!$this->Model->Position) {
            $this->Json::set('exception.code', 'NotFoundPosition');
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
