<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddEmployeeKeysToEofficeUsersFromApiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users_from_api', function (Blueprint $table) {
            //
            $table->string('kuntp')->nullable()->default(null)->after('komponen');
            $table->string('kunkom')->nullable()->default(null)->after('kuntp');
            $table->string('kununit')->nullable()->default(null)->after('kunkom');
            $table->string('kunsk')->nullable()->default(null)->after('kununit');
            $table->string('kunssk')->nullable()->default(null)->after('kunsk');
            $table->string('kunker')->nullable()->default(null)->after('kunssk');
            $table->string('jnsjab')->nullable()->default(null)->after('kunker');
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
