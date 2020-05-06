<?php

namespace App\Traits\Message;

/* Models */
use App\Models\Reply;
use App\Models\ReplyMessage;

use DB;

trait ReplyCollection
{
    public function __construct()
    {
        $this->ReplyMessageModel = ReplyMessage::class;
        $this->ReplyMessageTable = getTable($this->ReplyMessageModel);

        $this->ReplyModel = Reply::class;
        $this->ReplyTable = getTable($this->ReplyModel);
    }

    public function GetReplyDetails($Replies)
    {
        $ReplyID = $Replies->pluck('id');

        $Replies->map(function($Reply) {
            return $Reply;
        });
        return $Replies;
    }

}
