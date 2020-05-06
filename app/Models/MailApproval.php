<?php

namespace App\Models;

use Webpatser\Uuid\Uuid;

use Illuminate\Database\Eloquent\Model;

class MailApproval extends Model
{
    protected $table = 'mail_approval';

    public function position()
    {
        return $this->hasOne(Position::class, 'id', 'position_id')->with('user_without_position');
    }

    public function history_approval()
    {
        return $this->hasOne(MailLogPositionUser::class, 'master_id', 'id')
                    ->where('table', 'mail_approval')
                    ->where('column', 'position_id');
    }
}
