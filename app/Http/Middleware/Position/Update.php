<?php

namespace App\Http\Middleware\Position;

use App\Models\Position;

use Closure;
use Validator;
use Illuminate\Support\Facades\Storage;
use App\Http\Middleware\BaseMiddleware;

class Update extends BaseMiddleware
{
    private function Initiate()
    {
        $this->Model->Position = Position::find($this->Id);

        if ($this->Model->Position) {
            $this->Model->Position->name = $this->_Request->input('name');
            $this->Model->Position->signing_template = $this->_Request->input('signing_template');
            $this->Model->Position->shortname = $this->_Request->input('shortname');
            $this->Model->Position->mail_number_suffix_code = $this->_Request->input('mail_number_suffix_code');
            if($this->_Request->input('parent_id')) $this->Model->Position->parent_id = $this->_Request->input('parent_id');
        }
        $this->permissions = $this->_Request->input('permissions');
    }

    private function Validation()
    {
        $validator = Validator::make($this->_Request->all(), [
            'name' => 'required',
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
            $this->Payload->put('Permissions', $this->permissions);
            $this->_Request->merge(['Payload' => $this->Payload]);
            return $next($this->_Request);
        } else {
            return response()->json($this->Json::get(), $this->HttpCode);
        }
    }
}
