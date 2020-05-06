<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddEselonIdToPositionsFromApiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('positions_from_api', function (Blueprint $table) {
            //
            $table->string('eselon_id')->nullable()->default(null)->after('kunker_parent');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('positions_from_api', function (Blueprint $table) {
            //
        });
    }
}
