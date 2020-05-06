<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMailDispositionReplyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mail_disposition_reply', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('master_mail_id')->nullable()->default(NULL);
            $table->integer('created_user_id')->nullable()->default(NULL);
            $table->text('messages')->nullable()->default(NULL);
            $table->integer('reply_mail_id')->nullable()->default(NULL);
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->default(\DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));
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
        Schema::dropIfExists('mail_disposition_reply');
    }
}
