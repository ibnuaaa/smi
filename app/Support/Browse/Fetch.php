<?php

namespace App\Support\Browse;

use Closure;

class Fetch
{
    public $FetchController;
    public $QueryRoute;

    public function __construct($Instance, $request)
    {
        $this->QueryRoute = QueryRoute($request);
        $this->FetchController = new $Instance($this->QueryRoute);
    }

    public function equal($key, $val)
    {
        return $this->where($key, $val);
    }

    public function where($key, $val)
    {
        $this->QueryRoute->ArrQuery->{$key} = $val;
        return $this;
    }

    public function middleware($handle = null)
    {
        if ($handle instanceof Closure) {
            return call_user_func_array($handle, [ $this ]);
        }
        return $this;
    }

    public function get($set = 'fetch', $withResponse = false)
    {
        if ($set === 'count') {
            $this->QueryRoute->ArrQuery->{'with.total'} = true;
        }
        $this->QueryRoute->ArrQuery->set = $set;
        $response = $this->FetchController->get($this->QueryRoute);
        if ($withResponse) {
            return $response;
        }
        return $response->original['data'];
    }
}
