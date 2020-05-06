<?php

namespace App\Http\Middleware\Information;

use App\Models\Information;

use Illuminate\Support\Facades\Hash;
use Closure;
use Validator;
use Illuminate\Support\Facades\Storage;
use App\Http\Middleware\BaseMiddleware;

class Update extends BaseMiddleware
{
    private function Initiate($request)
    {
        $this->Model->Information = Information::where('id', $this->Id)->first();
        if ($this->Model->Information) {
            $this->Model->Information->title = $this->_Request->input('title');
            $this->Model->Information->content = $this->_Request->input('content');
        }
    }

    private function Validation()
    {
        $validator = Validator::make($this->_Request->all(), [
            'title' => 'required',
            'content' => 'required'
        ]);
        if (!$this->Model->Information) {
            $this->Json::set('exception.code', 'NotFoundInformation');
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
