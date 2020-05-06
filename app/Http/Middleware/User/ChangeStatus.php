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

class ChangeStatus extends BaseMiddleware
{
    private function Initiate($request)
    {
        $this->Model->User = User::where('id', $this->_Request->input('user_id'))->first();
        if ($this->Model->User) {
            $this->Model->User->status = $this->_Request->input('status');
        }
    }

    private function Validation()
    {
        $validator = Validator::make($this->_Request->all(), [
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
