<?php

namespace App\Http\Middleware\Position;

use App\Models\Position;

use Closure;
use Validator;
use Illuminate\Support\Facades\Storage;
use App\Http\Middleware\BaseMiddleware;

class Delete extends BaseMiddleware
{
    private function Initiate()
    {
        $this->Model->Position = Position::find($this->Id);
    }

    private function Validation()
    {
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
