<?php

namespace App\Traits;

use App\Models\Branch;
use App\Models\BranchToConfigNumbering;
use App\Models\ConfigNumbering;

trait Numbering
{
    public function getTransactionNumber($type)
    {
        $ConfigNumbering = ConfigNumbering::where('type', $type)->first();
        if(!$ConfigNumbering) {
            $this->addNewConfigNumbering($type);
        }

        $ConfigNumbering = ConfigNumbering::where('type', $type)->first();
        $length = $ConfigNumbering->length;
        $lastValue = $ConfigNumbering->last_value;

        $last_value = $this->addTransactionNumber($type, $ConfigNumbering->last_value);

        $transactionNumber = str_pad((int) $last_value, (int)$length, '0', STR_PAD_LEFT);
        $transactionNumber = $transactionNumber;
        return [
            'success' => true,
            'value' => $transactionNumber
        ];
    }

    public function addTransactionNumber($type, $lastTransactionNumber)
    {
        $ConfigNumbering = ConfigNumbering::where('type', $type)->first();

        $currentYear = date('Y');

        $last_value = $ConfigNumbering->last_value + 1;
        if ($ConfigNumbering->year != $currentYear) {
            $last_value = 1;
        }

        $ConfigNumbering->last_value = $last_value;
        $ConfigNumbering->year = $currentYear;
        $ConfigNumbering->save();

        return $last_value;
    }

    public function addNewConfigNumbering($type) {
        $ConfigNumbering = new ConfigNumbering();
        $ConfigNumbering->type = $type;
        $ConfigNumbering->length = 4;
        $ConfigNumbering->save();

        return $ConfigNumbering;
    }
}
