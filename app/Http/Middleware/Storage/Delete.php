<?php

namespace App\Http\Middleware\Storage;

use DB;
use Closure;
use Validator;
use App\Http\Middleware\BaseMiddleware;

use App\Models\MailDocument;

class Delete extends BaseMiddleware
{
    protected $file = null;

    private function Initiate()
    {
        $this->Model->MailDocument = MailDocument::find($this->Id);
    }

    private function Validation()
    {
        if (!$this->Model->MailDocument) {
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
            $this->Payload->put('Model', $this->Model);
            $this->_Request->merge(['Payload' => $this->Payload]);
            return $next($this->_Request);
        } else {
            return response()->json($this->Json::get(), $this->HttpCode);
        }
    }
}
