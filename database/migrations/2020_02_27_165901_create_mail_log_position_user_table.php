<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMailLogPositionUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mail_log_position_user', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('table')->nullable()->default(NULL);
            $table->string('column')->nullable()->default(NULL);
            $table->string('master_id')->nullable()->default(NULL);
            $table->string('position_name')->nullable()->default(NULL);
            $table->string('user_name')->nullable()->default(NULL);
            $table->string('user_golongan')->nullable()->default(NULL);
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
        Schema::dropIfExists('mail_log_position_user');
    }
}
