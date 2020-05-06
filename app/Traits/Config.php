<?php

namespace App\Traits;

use App\Models\Config as ConfigDB;

trait Config
{
    public function Config()
    {
        $ConfigDB = ConfigDB::get();
        $res = [
            'email' => '',
            'phone_number' => '',
            'address' => '',
            'website' => ''
        ];
        foreach ($ConfigDB as $key => $value) {
            $res[$value->key] = $value->value;
        }

        return $res;
    }
}
