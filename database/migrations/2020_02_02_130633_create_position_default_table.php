<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePositionDefaultTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('positions_default', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->nullable()->default(NULL);
            $table->string('kuntp')->nullable()->default(NULL);
            $table->string('kunkom')->nullable()->default(NULL);
            $table->string('kununit')->nullable()->default(NULL);
            $table->string('kunsk')->nullable()->default(NULL);
            $table->string('kunssk')->nullable()->default(NULL);
            $table->string('kunker')->nullable()->default(NULL);
            $table->string('jnsjab')->nullable()->default(NULL);
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
