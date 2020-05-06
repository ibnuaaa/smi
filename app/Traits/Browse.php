<?php

namespace App\Traits;

use DB;
use App\Models\ModelSearch;
use App\Support\Browse\Fetch as FetchBrowse;

use Closure;

trait Browse
{
    protected $Search = null;
    protected $OrderBy = [];
    protected $tableName = null;
    protected $Count = null;
    protected $CountOver = false;

    public function Count($count, $over = false)
    {
        $this->Count = $count;
        $this->CountOver = $over;
        return $this;
    }

    public function Browse($request, $Model, $function = null)
    {
        $WithData = false;
        if (
            !isset($request->ArrQuery->set)
            || (isset($request->ArrQuery->set) && $request->ArrQuery->set !== 'count')
        ) {
            $WithData = true;
        }

        if (count($this->OrderBy) > 0) {
            foreach ($this->OrderBy as $key => $order) {
                if (isset($request->ArrQuery->{'orderBy.' . $order})) {
                    $orderName = $order;
                    $Model->orderBy($orderName, $request->ArrQuery->{'orderBy.' . $order});
                }
            }
        }
        if (isset($request->ArrQuery->take)) {
            if ($request->ArrQuery->take !== 'all') {
                $request->ArrQuery->take = (int) $request->ArrQuery->take;
            }
        }
        if (isset($request->ArrQuery->skip)) {
            $request->ArrQuery->skip = (int) $request->ArrQuery->skip;
        }

        if ($this->Search) {
            $In = [];
            $this->Search->take($request->ArrQuery->take)->skip($request->ArrQuery->skip);
            $In = $this->Search->get()->pluck('_id')->all();
        }

        $Array = [
            'query' => $request->ArrQuery
        ];
        if ($request->ArrQuery->{'with.total'}) {
            $ModelForCount = clone $Model;
            if ($this->CountOver) {
                // $count = $this->Count ? $this->Count : '*';
                // $ModelForCount = $ModelForCount->selectRaw('COUNT('.$count.') OVER() as aggregate');
            }
        }
        if ($this->Search) {
            $prefix = $this->TableName ? $this->TableName . '.' : '';
            $Model->whereIn($prefix . 'id', $In);
            $ModelForCount->whereIn($prefix . 'id', $In);
            if ($request->ArrQuery->take !== 'all') {
                $Model->take($request->ArrQuery->take);
            }
        } else {
            if ($request->ArrQuery->take !== 'all') {
                $Model->take($request->ArrQuery->take)->skip($request->ArrQuery->skip);
            }
        }
        if (config('app.debug')) {
            $ModelForSQL = clone $Model;
            $Array['debug'] = [
                'sql' => $ModelForSQL->toSql(),
                'bindings' => $ModelForSQL->getBindings()
            ];
        }

        if ($WithData) {
            $data = $Model->get();
        }

        if ($function instanceof Closure && $WithData) {
            $data = call_user_func_array($function, [ $data ]);
        }

        if ($request->ArrQuery->{'with.total'}) {
            $ModelForCount->getQuery()->orders = null;
            if ($this->CountOver) {
                $Array['total'] = DB::table(DB::raw("({$ModelForCount->toSql()}) as sub") )->mergeBindings($ModelForCount->toBase())->count();
            } else {
                $Array['total'] = $this->Count ? (int) $ModelForCount->count($this->Count) : (int) $ModelForCount->count();
            }
        }
        if ($WithData) {
            if ((isset($request->ArrQuery->set)) && $request->ArrQuery->set === 'first') {
                $Array['show'] = (int) isset($data[0]) ? 1 : 0;
                $Array['records'] = isset($data[0]) ? $data[0] : (object)[];
            } else {
                $Array['show'] = (int) $data->count();
                $Array['records'] = $data;
            }
        }
        return $Array;
    }

    public function ElasticSearch($tableName = '')
    {
        if ($tableName) {
            $this->TableName = $tableName;
        }
        $this->Search = app('es')->type(with(new ModelSearch)->getType());
        return $this;
    }

    public function search($body = [])
    {
        if ($this->Search) {
            $this->Search->body($body);
        }
        return $this;
    }

    public function Group(&$item, $key, $str, &$data)
    {
        if(substr($key, 0, strlen($str)) === $str) {
            if (is_object($item)) {
                $item->{substr($key, strlen($str))} = $data->{$key};
            } else {
                $item[substr($key, strlen($str))] = $data->{$key};
            }
            unset($data->{$key});
        }
    }

    public function OrderBy($orderlist)
    {
        if (isset($orderlist)) {
            $this->OrderBy = $orderlist;
        }
        return $this;
    }

    public function TableName($tableName)
    {
        if (isset($tableName)) {
            $this->tableName = $tableName;
        }
        return $this;
    }

    public static function FetchBrowse($request)
    {
        return new FetchBrowse(__CLASS__, $request);
    }
}
