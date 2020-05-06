<?php

namespace App\Http\Middleware\Storage;

use App\Models\Storage as StorageDB;

use DB;
use Closure;
use Validator;

use App\Http\Middleware\BaseMiddleware;

class FetchTmp extends BaseMiddleware
{
    protected $file = null;

    private function Initiate()
    {
        $this->key = $this->_Request->key;
        $this->Model->Key = $this->_Request->key;
    }

    private function Validation()
    {
        return true;
    }

    public function handle($request, Closure $next)
    {
        $this->Initiate();
        if($this->Validation()) {
            $this->Payload->put('File', $this->file);
            $this->Payload->put('Model', $this->Model);
            $this->_Request->merge(['Payload' => $this->Payload]);
            return $next($this->_Request);
        } else {
            return response()->json($this->Json::get(), $this->HttpCode);
        }
    }
}
