<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use App\Support\Response\Json;
use App\Support\Validation\InputValidation;

abstract class BaseMiddleware
{
    protected $_Request;
    protected $Model;
    protected $Payload;
    protected $Id = null;
    protected $Username = null;

    public function __construct(Request $request)
    {
        if (isset($request->route()[2]['id'])) {
            $this->Id = (int)$request->route()[2]['id'];
        }
        if (isset($request->route()[2]['uuid'])) {
            $this->Uuid = $request->route()[2]['uuid'];
        }
        if (isset($request->route()[2]['username'])) {
            $this->Username = $request->route()[2]['username'];
        }
        $this->Rules = [];
        $this->Changes = [];
        $this->Json = Json::class;
        $this->Validator = InputValidation::class;
        $this->HttpCode = 400;
        $this->Model = (object)[];
        $this->Payload = collect([]);
        $this->_Request = $request;
        $this->errors = collect([]);

        if ($request->user()) {
            $this->Me = $request->user();
        }
    }

    public function mergeRules($rules)
    {
        $this->Rules = array_merge($this->Rules, $rules);
    }

    public function mergeChanges($changes)
    {
        $this->Changes = array_merge($this->Changes, $changes);
        $this->Payload->put('Changes', $this->Changes);
    }

    public function setRequest($request)
    {
        $this->_Request = $request;
    }

    public function mergeRequest($key, $data = [])
    {
        return $this->_Request;
    }

    protected function transAttribute($key) {
        return trans('validation.attributes.' . $key);
    }

    public function is_updated($thing) {
        return isset($this->Payload->all()['Changes'][$thing]);
    }
}
