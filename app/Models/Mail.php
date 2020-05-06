<?php

namespace App\Models;

use Webpatser\Uuid\Uuid;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\SoftDeletes;

class Mail extends Model
{
    use SoftDeletes;
    protected $table = 'mail';

    public function approval()
    {
        return $this->hasMany(MailApproval::class, 'mail_id', 'mail.id')
            ->with('position')
            ->with('history_approval');
    }

    public function principle()
    {
        return $this->hasMany(MailPrinciple::class, 'mail_id', 'mail.id');
    }

    public function mail_destination()
    {
        return $this->hasMany(MailTo::class, 'mail_id', 'mail.id')->with('position')->with('history_destination');
    }

    public function mail_detail()
    {
        return $this->hasMany(MailDetail::class, 'mail_id', 'mail.id');
    }

    public function mail_copy_to()
    {
        return $this->hasMany(MailCopyTo::class, 'mail_id', 'mail.id')->with('position');
    }

    public function disposition()
    {
        return $this->hasOne(MailDisposition::class, 'mail_id', 'mail.id')->with('position');
    }

    public function created_user()
    {
        return $this->hasOne(User::class, 'id', 'mail.created_user_id')->with('position');
    }

    public function disposition_destination()
    {
        return $this->hasMany(MailTo::class, 'mail_id', 'mail.id')->where('type', 2)->with('position');
    }

    public function source_position()
    {
        return $this->hasOne(Position::class, 'id', 'mail.source_position_id');
    }

    public function my_inbox() {

        $position_id = '';
        if ( !empty(Auth::user()->position_id)) $position_id = Auth::user()->position_id;

        return $this->hasOne(MailTo::class, 'mail_id', 'mail.id')
                    ->where('destination_position_id', $position_id);
    }

    public function my_approval() {

        $position_id = '';
        if ( !empty(Auth::user()->position_id)) $position_id = Auth::user()->position_id;

        return $this->hasOne(MailApproval::class, 'mail_id', 'mail.id')
                    ->where('position_id', $position_id);
    }

    public function signer() {
        return $this->hasOne(MailApproval::class, 'mail_id', 'mail.id')
                    ->where('type', 2)->with('position');
    }

    public function lampiran()
    {
        return $this->hasMany(MailDocument::class, 'object_id', 'mail.id')
                    ->where('object', 'lampiran')
                    ->with('storage');
    }


    public function history_signer()
    {
        return $this->hasOne(MailLogPositionUser::class, 'master_id', 'mail.id')
                    ->where('table', 'mail')
                    ->where('column', 'signer_id');
    }

    public function history_source_position()
    {
        return $this->hasOne(MailLogPositionUser::class, 'master_id', 'mail.id')
                    ->where('table', 'mail')
                    ->where('column', 'source_position_id');
    }

    public function template()
    {
        return $this->hasOne(MailTemplate::class, 'id', 'mail.mail_template_id');
    }
}
