<?php

namespace App\Traits\MailDisposition;

/* Models */
use App\Models\MailDisposition;

use DB;

trait MailDispositionCollection
{
    public function __construct()
    {
        $this->MailDispositionModel = MailDisposition::class;
        $this->MailDispositionTable = getTable($this->MailDispositionModel);
    }

    public function GetMailDispositionDetails($Dispositions)
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
