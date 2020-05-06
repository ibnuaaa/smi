<?php

namespace App\Models;

use Webpatser\Uuid\Uuid;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MailTo extends Model
{
    use SoftDeletes;
    protected $table = 'mail_to';

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'destination_user_id')->with('position');
    }

    public function position()
    {
        return $this->hasOne(Position::class, 'id', 'destination_position_id')
        ->with('user_without_position')
        ->with('user');
    }

    public function position_with_user_without_position()
    {
        return $this->hasOne(Position::class, 'id', 'destination_position_id')
        ->with('user_without_position');
    }

    public function history_destination()
    {
        return $this->hasOne(MailLogPositionUser::class, 'master_id', 'id')
                    ->where('table', 'mail_destination')
                    ->where('column', 'position_id');
    }
}
