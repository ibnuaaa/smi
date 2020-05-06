<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeNamePositionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('users_from_api', function ($table) {
            $table->string('njab', 2000)->change();
        });
        Schema::table('positions_from_api', function ($table) {
            $table->string('nama', 2000)->change();
        });
        Schema::table('positions', function ($table) {
            $table->string('name', 2000)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
