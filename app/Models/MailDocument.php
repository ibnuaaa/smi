<?php

namespace App\Models;

use Webpatser\Uuid\Uuid;

use Illuminate\Database\Eloquent\Model;

class MailDocument extends Model
{
    protected $table = 'mail_document';

    public function storage() {
        return $this->hasOne(Storage::class, 'id', 'storage_id');
    }
}
