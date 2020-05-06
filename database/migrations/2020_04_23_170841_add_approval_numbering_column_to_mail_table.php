<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddApprovalNumberingColumnToMailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('mail', function (Blueprint $table) {
            $table->integer('mail_number_status')->nullable()->default(0)->after('mail_number_ext');
            $table->timestamp('mail_number_created_at')->nullable()->default(null)->after('mail_number_status');
            $table->integer('mail_number_created_by')->nullable()->default(null)->after('mail_number_created_at');
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
