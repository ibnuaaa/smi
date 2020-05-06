<?php

namespace App\Http\Middleware\Upload;

use Closure;
use App\Http\Middleware\BaseMiddleware;

class File extends BaseMiddleware
{

    private function Initiate()
    {
        $this->File = $this->_Request->file('file');
    }

    private function Validation()
    {
        if (!$this->Validator::Require($this->File)) {
            $this->Json::set('response.code', 400);
            $this->Json::set('exception.code', 'EmptyFile');
            $this->Json::set('exception.message', trans('Equinox::Validation.'.$this->Json::get('exception.code')));
            return false;
        }
        return true;
    }

    public function handle($request, Closure $next)
    {
        $this->Initiate();
        if($this->Validation()) {
            $this->Payload->put('File', $this->File);
            $this->_Request->merge(['Payload' => $this->Payload]);
            return $next($this->_Request);
        } else {
            return response()->json($this->Json::get(), $this->Json::get('response.code'));
        }
    }
}
