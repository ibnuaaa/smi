<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersFromApiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users_from_api', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nip')->nullable()->default(NULL);
            $table->string('nama')->nullable()->default(NULL);
            $table->string('ktlahir')->nullable()->default(NULL);
            $table->string('tlahir')->nullable()->default(NULL);
            $table->string('pangkat')->nullable()->default(NULL);
            $table->string('golongan')->nullable()->default(NULL);
            $table->string('tmtpang')->nullable()->default(NULL);
            $table->string('njab')->nullable()->default(NULL);
            $table->string('tmtjab')->nullable()->default(NULL);
            $table->string('agama')->nullable()->default(NULL);
            $table->string('foto')->nullable()->default(NULL);
            $table->string('komponen')->nullable()->default(NULL);
            $table->timestamp('updated_at')->default(\DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));
            $table->timestamp('created_at')->nullable();
            $table->timestamp('deleted_at')->nullable()->default(NULL);
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
