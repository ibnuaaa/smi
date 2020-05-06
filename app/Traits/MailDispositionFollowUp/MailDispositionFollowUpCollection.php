<?php

namespace App\Traits\MailDispositionFollowUp;

/* Models */
use App\Models\MailDispositionFollowUp;

use DB;

trait MailDispositionFollowUpCollection
{
    public function __construct()
    {
        $this->MailDispositionFollowUpModel = MailDispositionFollowUp::class;
        $this->MailDispositionFollowUpTable = getTable($this->MailDispositionFollowUpModel);
    }

    public function GetMailDispositionFollowUpDetails($Dispositions)
    {
        $DispositionID = $Dispositions->pluck('id');

        $Dispositions->map(function($Disposition) {
            return $Disposition;
        });
        return $Dispositions;
    }

    public function getSelection($data, $arr = []) {

        $item = $data;
        unset($item['parents']);
        $arr[] = $item;

        if ($data['parents']) return $this->getSelection($data['parents'], $arr);
        else return $arr ;
    }



}
