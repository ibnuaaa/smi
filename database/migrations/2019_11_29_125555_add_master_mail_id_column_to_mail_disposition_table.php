<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMasterMailIdColumnToMailDispositionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('mail_disposition', function (Blueprint $table) {
            //
            $table->integer('parent_mail_id')->nullable()->default(NULL)->after('disposition_date');
            $table->integer('parent_disposition_id')->nullable()->default(NULL)->after('parent_mail_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('mail_disposition', function (Blueprint $table) {
            //
        });
    }
}
