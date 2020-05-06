<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTujuanHalTembusanColumnToMailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('mail', function (Blueprint $table) {
            $table->integer('mail_to')->nullable()->default(NULL)->after('id');
            $table->integer('copy_mail_to')->nullable()->default(NULL)->after('privacy_type');
            $table->text('about')->nullable()->default(NULL)->after('copy_mail_to');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('mail', function (Blueprint $table) {
            //
        });
    }
}
