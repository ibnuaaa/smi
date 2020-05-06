<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Http\Middleware\BaseMiddleware;
use Illuminate\Contracts\Auth\Factory as Auth;

class Authenticate extends BaseMiddleware
{
    /**
     * The authentication guard factory instance.
     *
     * @var \Illuminate\Contracts\Auth\Factory
     */
    protected $auth;

    /**
     * Create a new middleware instance.
     *
     * @param  \Illuminate\Contracts\Auth\Factory  $auth
     * @return void
     */
    public function __construct(Auth $auth, Request $request)
    {
        parent::__construct($request);
        $this->auth = $auth;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if ($this->auth->guard($guard)->guest()) {
            $this->Json::set('exception.message', 'Unauthorized.');
            return response()->json($this->Json::get(), 401);
        }
        $Me = (object)['account' => $request->user(), 'type' => 'user'];
        $this->_Request->merge(['Me' => $Me]);
        return $next($request);
    }
}
