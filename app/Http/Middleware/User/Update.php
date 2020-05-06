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

class Update extends BaseMiddleware
{
    private function Initiate($request)
    {
        $this->Model->User = User::where('id', $this->Id)->first();
        $password = $this->_Request->input('password');
        if (Hash::needsRehash($this->_Request->input('password'))) {
            $password = app('hash')->make($password);
        }
        if ($this->Model->User) {
            !$this->_Request->input('username') || $this->Model->User->username = $this->_Request->input('username');
            !$this->_Request->input('nik') || $this->Model->User->nik = $this->_Request->input('nik');
            !$this->_Request->input('name') || $this->Model->User->name = $this->_Request->input('name');
            !$this->_Request->input('address') || $this->Model->User->address = $this->_Request->input('address');
            !$this->_Request->input('satker') || $this->Model->User->satker = $this->_Request->input('satker');
            !$this->_Request->input('golongan') || $this->Model->User->golongan = $this->_Request->input('golongan');
            !$this->_Request->input('jenis_user') || $this->Model->User->jenis_user = $this->_Request->input('jenis_user');
            !$this->_Request->input('position_id') || $this->Model->User->position_id = $this->_Request->input('position_id');

            !$this->_Request->input('status') || $this->Model->User->status = $this->_Request->input('status');
            if ($this->_Request->input('password')) {
                $this->Model->User->password = $password;
            }
            if ($this->_Request->input('position_id')) {
                $this->Model->Position = Position::where('id', $this->Model->User->position_id)->first();
            }

        }
    }

    private function Validation()
    {
        $validator = Validator::make($this->_Request->all(), [
            'username' => ['unique:users,username,'.$this->Id, 'max:255'],
            'email' => ['unique:users,email,'.$this->Id, 'max:255'],
            'password' => 'min:6|max:255|regex:/^(?=.*[a-z])(?=.*\d).+$/',
            'position_id' => [],
            'gender' => ['in:male,female'],
            'status' => ['in:active,inactive']
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
