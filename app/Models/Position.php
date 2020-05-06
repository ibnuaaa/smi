<?php

namespace App\Models;

use Webpatser\Uuid\Uuid;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Position extends Model
{
    use SoftDeletes;
    protected $table = 'positions';

    public function children()
    {
        return $this->hasMany(Position::class, 'parent_id', 'id')
                ->where('status', '=', 'active')
                ->orderBy('ordering', 'asc')
                ->with('users');
    }

    public static function tree()
    {
        return static::with(implode('.', array_fill(0, 100, 'children')))
                    ->where('parent_id', '=', NULL)
                    ->orderBy('ordering', 'asc')
                    ->get();
    }

    public function parent()
    {
        return $this->hasOne(Position::class, 'id', 'user.parent_id')
            ->with('user');
    }

    public function parents()
    {
        return $this->hasOne(Position::class, 'id', 'parent_id')
            ->with('parents');
    }

    public function user()
    {
        return $this->hasOne(User::class, 'position_id', 'id')->with('position');
    }

    public function users()
    {
        return $this->hasMany(User::class, 'position_id', 'id');
    }

    public function user_without_position()
    {
        return $this->hasOne(User::class, 'position_id', 'id');
    }


}
