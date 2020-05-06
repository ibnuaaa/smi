<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddApprovedAtRejectAtColumnToMailApprovalTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('mail_approval', function (Blueprint $table) {
            $table->timestamp('approved_at')->nullable()->default(null)->after('reject_reason');
            $table->timestamp('rejected_at')->nullable()->default(null)->after('approved_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
    }
}
