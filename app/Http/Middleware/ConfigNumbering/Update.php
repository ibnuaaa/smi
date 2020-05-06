<?php

namespace App\Http\Middleware\ConfigNumbering;

use App\Models\ConfigNumbering;

use Illuminate\Support\Facades\Hash;
use Closure;
use Validator;
use Illuminate\Support\Facades\Storage;
use App\Http\Middleware\BaseMiddleware;

class Update extends BaseMiddleware
{
    private function Initiate($request)
    {
        $this->Model->ConfigNumbering = ConfigNumbering::where('id', $this->Id)->first();
        if ($this->Model->ConfigNumbering) {
            $this->Model->ConfigNumbering->type = $this->_Request->input('type');
            $this->Model->ConfigNumbering->length = $this->_Request->input('length');
            $this->Model->ConfigNumbering->last_value = $this->_Request->input('last_value');
            $this->Model->ConfigNumbering->description = $this->_Request->input('description');
        }
    }

    private function Validation()
    {
        $validator = Validator::make($this->_Request->all(), [
            'type' => 'required',
            'length' => 'required',
            'last_value' => 'required'
        ]);
        if (!$this->Model->ConfigNumbering) {
            $this->Json::set('exception.code', 'NotFoundConfigNumbering');
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
