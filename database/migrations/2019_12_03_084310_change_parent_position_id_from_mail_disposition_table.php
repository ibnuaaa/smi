<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeParentPositionIdFromMailDispositionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('mail_disposition', function (Blueprint $table) {
            $table->dropColumn('parent_disposition_id');
            $table->integer('master_mail_id')->nullable()->default(NULL)->after('parent_disposition_id');
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
