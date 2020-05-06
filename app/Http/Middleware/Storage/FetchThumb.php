<?php

namespace App\Http\Middleware\Storage;

use App\Models\Storage as StorageDB;

use DB;
use Closure;
use Validator;
use Illuminate\Support\Facades\Storage;
use App\Http\Middleware\BaseMiddleware;

class FetchThumb extends BaseMiddleware
{
    protected $file = null;

    private function Initiate()
    {
        $this->key = $this->_Request->key;
        $this->Model->Storage = StorageDB::where('thumbName', $this->_Request->key)->first();
    }

    private function Validation()
    {
        if (!$this->Model->Storage) {
            $this->Json::set('exception.code', 'NotFoundFile');
            $this->Json::set('exception.message', trans('validation.'.$this->Json::get('exception.code')));
            return false;
        }
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
