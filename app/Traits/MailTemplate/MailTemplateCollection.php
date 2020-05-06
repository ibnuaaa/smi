<?php

namespace App\Traits\MailTemplate;

/* Models */
use App\Models\MailTemplate;

use DB;

trait MailTemplateCollection
{
    public function __construct()
    {
        $this->MailTemplateModel = MailTemplate::class;
        $this->MailTemplateTable = getTable($this->MailTemplateModel);
    }

    public function GetMailTemplateDetails($MailTemplates)
    {
        $MailTemplateID = $MailTemplates->pluck('id');

        $MailTemplates->map(function($MailTemplate) {
            return $MailTemplate;
        });
        return $MailTemplates;
    }

}
