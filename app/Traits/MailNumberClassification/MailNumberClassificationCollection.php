<?php

namespace App\Traits\MailNumberClassification;

/* Models */
use App\Models\MailNumberClassification;

use DB;

trait MailNumberClassificationCollection
{
    public function __construct()
    {
        $this->MailNumberClassificationModel = MailNumberClassification::class;
        $this->MailNumberClassificationTable = getTable($this->MailNumberClassificationModel);
    }

    public function GetMailNumberClassificationDetails($MailNumberClassifications)
    {
        $MailNumberClassificationID = $MailNumberClassifications->pluck('id');

        $MailNumberClassifications->map(function($MailNumberClassification) {
            return $MailNumberClassification;
        });
        return $MailNumberClassifications;
    }

}
