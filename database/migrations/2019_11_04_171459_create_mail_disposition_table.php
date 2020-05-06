<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMailDispositionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mail_disposition', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('mail_id');
            $table->datetime('disposition_date')->nullable()->default(NULL);
            $table->datetime('disposition_position')->nullable()->default(NULL);
            $table->datetime('disposition_user')->nullable()->default(NULL);
            $table->text('disposition_answer')->nullable()->default(NULL);
            $table->text('notes')->nullable()->default(NULL);
            $table->integer('status'); //1.unread 2.read
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
        Schema::dropIfExists('mail_disposition');
    }
}
