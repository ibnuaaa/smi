<?php

namespace App\Http\Middleware;

use App\Models\Log;

use Closure;
use Validator;
use Illuminate\Support\Facades\Storage;
use App\Http\Middleware\BaseMiddleware;

use Illuminate\Support\Facades\Auth;

class LogActivity extends BaseMiddleware
{
    private function Initiate()
    {

    }

    private function Validation()
    {
        return true;
    }

    public function handle($request, Closure $next, $Activity = null)
    {
        $activity = explode('.', $Activity);

        $req = $request->input();

        $datas = [];
        foreach ($req as $key => $value) {
            if ($key != 'Me') $datas[$key] = $value;
        }

        $Log = new Log();
        if (!empty(Auth::user()['id'])) $Log->user_id = Auth::user()['id'];
        $Log->modul = $activity[0];
        $Log->activity = $activity[1];
        $Log->ip_client = $request->ip();
        $Log->browser = $request->header('User-Agent');
        $Log->data = json_encode($datas);
        $Log->save();

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
