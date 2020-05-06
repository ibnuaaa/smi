<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddDestinationPositionIdColumnToMailToTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('mail_to', function (Blueprint $table) {
            //
            $table->integer('destination_position_id')->nullable()->default(NULL)->after('mail_id');
            $table->integer('status')->nullable()->default(NULL)->after('destination_position_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('mail_to', function (Blueprint $table) {
            //
        });
    }
}
