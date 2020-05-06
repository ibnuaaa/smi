<?php

namespace App\Http\Middleware\Config;

use App\Models\Config;

use Illuminate\Support\Facades\Hash;
use Closure;
use Validator;
use Illuminate\Support\Facades\Storage;
use App\Http\Middleware\BaseMiddleware;

class Update extends BaseMiddleware
{
    private function Initiate($request)
    {
        $this->Model->Config = Config::where('id', $this->Id)->first();
        if ($this->Model->Config) {
            $this->Model->Config->key = $this->_Request->input('key');
            $this->Model->Config->value = $this->_Request->input('value');
        }
    }

    private function Validation()
    {
        $validator = Validator::make($this->_Request->all(), [
            'key' => 'required',
            'value' => 'required'
        ]);
        if (!$this->Model->Config) {
            $this->Json::set('exception.key', 'NotFoundConfig');
            $this->Json::set('exception.message', trans('validation.'.$this->Json::get('exception.key')));
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
