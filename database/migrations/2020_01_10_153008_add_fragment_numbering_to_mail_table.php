<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFragmentNumberingToMailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('mail', function (Blueprint $table) {
            $table->string('mail_number_prefix')->nullable()->default(null)->after('mail_number');
            $table->string('mail_number_infix')->nullable()->default(null)->after('mail_number_prefix');
            $table->string('mail_number_suffix')->nullable()->default(null)->after('mail_number_infix');
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
