<?php

namespace App\Models;

use Webpatser\Uuid\Uuid;

use Illuminate\Database\Eloquent\Model;

class MailCopyTo extends Model
{
    protected $table = 'mail_copy_to';

    public function position()
    {
        return $this->hasOne(Position::class, 'id', 'position_id')
        ->with('user_without_position');
    }
}
