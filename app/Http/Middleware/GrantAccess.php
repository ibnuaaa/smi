<?php

namespace App\Http\Middleware;

use Closure;
use Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Http\Middleware\BaseMiddleware;

class GrantAccess extends BaseMiddleware
{
    private function Initiate()
    {
        if ($this->Permission) {
            $this->granted = false;
            try {
                $this->granted = getPermissions($this->Permission)['checked'];
              } catch (\Exception $e) {
            }
        }
    }

    private function Validation()
    {
        if ($this->Permission) {
            if (!$this->granted) {
              abort(403, 'Permission denied');
              return false;
            }
        }
        return true;
    }

    public function handle($request, Closure $next, $permission)
    {
        $this->Permission = $permission;
        $this->Initiate();
        if ($this->Validation()) {
            return $next($this->_Request);
        } else {
            return response()->json($this->Json::get(), $this->HttpCode);
        }
    }
}
