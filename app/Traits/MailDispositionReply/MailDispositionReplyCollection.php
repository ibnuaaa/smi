<?php

namespace App\Traits\MailDispositionReply;

/* Models */
use App\Models\MailDispositionReply;

use DB;

trait MailDispositionReplyCollection
{
    public function __construct()
    {
        $this->MailDispositionReplyModel = MailDispositionReply::class;
        $this->MailDispositionReplyTable = getTable($this->MailDispositionReplyModel);
    }

    public function GetMailDispositionReplyDetails($MailDispositionReplies)
    {
        $MailDispositionReplyID = $MailDispositionReplies->pluck('id');

        $MailDispositionReplies->map(function($MailDispositionReply) {
            return $MailDispositionReply;
        });
        return $MailDispositionReplies;
    }

}
