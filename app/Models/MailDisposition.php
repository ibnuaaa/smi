<?php

namespace App\Models;

use Webpatser\Uuid\Uuid;

use Illuminate\Database\Eloquent\Model;

class MailDisposition extends Model
{
    protected $table = 'mail_disposition';

    public function position()
    {
        return $this->hasOne(Position::class, 'id', 'disposition_position')->with('user_without_position');
    }

    public function history()
    {
        return $this->hasMany(MailDisposition::class, 'master_mail_id', 'mail.master_mail_id')
            ->with('mail_to')
            ->with('mail_to_me');
    }

    public function mail_to()
    {
        return $this->hasMany(MailTo::class, 'mail_id', 'mail_id')->with('position_with_user_without_position');
    }

    public function disposition_by()
    {
        return $this->hasOne(Position::class, 'id', 'disposition_position')->with('user_without_position');
    }

    public function mail_to_me()
    {
        return $this->hasOne(MailTo::class, 'mail_id', 'mail_id')
                    ->where('destination_position_id', MyAccount()->position_id)
                    ->with('position_with_user_without_position');
    }

}
