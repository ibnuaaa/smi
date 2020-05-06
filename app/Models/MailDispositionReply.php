<?php

namespace App\Models;

use Webpatser\Uuid\Uuid;

use Illuminate\Database\Eloquent\Model;

class MailDispositionReply extends Model
{
    protected $table = 'mail_disposition_reply';

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'mail_disposition_reply.created_user_id');
    }
}
