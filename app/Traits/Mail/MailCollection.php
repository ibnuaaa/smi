<?php

namespace App\Traits\Mail;

/* Models */
use App\Models\Mail;
use App\Models\MailTo;
use App\Models\MailDisposition;
use App\Models\MailApproval;
use App\Models\User;
use App\Models\Position;

use DB;

trait MailCollection
{
    public function __construct()
    {
        $this->MailModel = Mail::class;
        $this->MailTable = getTable($this->MailModel);

        $this->UserModel = User::class;
        $this->UserTable = getTable($this->UserModel);

        $this->MailApprovalModel = MailApproval::class;
        $this->MailApprovalTable = getTable($this->MailApprovalModel);

        $this->MailToModel = MailTo::class;
        $this->MailToTable = getTable($this->MailToModel);

        $this->MailDispositionModel = MailDisposition::class;
        $this->MailDispositionTable = getTable($this->MailDispositionModel);

        $this->PositionModel = Position::class;
        $this->PositionTable = getTable($this->PositionModel);
    }

    public function GetMailDetails($Mails)
    {
        $MailID = $Mails->pluck('id');

        $Mails->map(function($Mail) {
            return $Mail;
        });
        return $Mails;
    }

}
