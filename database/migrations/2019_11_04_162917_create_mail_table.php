<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mail', function (Blueprint $table) {
            $table->increments('id');
            $table->datetime('mail_date')->nullable()->default(NULL);
            $table->datetime('receive_date')->nullable()->default(NULL);
            $table->string('mail_number')->nullable()->default(NULL);
            $table->text('content')->nullable()->default(NULL);
            $table->integer('mail_template_id')->nullable()->default(NULL);
            $table->integer('created_user_id')->nullable()->default(NULL);
            $table->integer('status_approval')->nullable()->default(NULL); // 1. checker 2.signer 3.approved
            $table->integer('status')->nullable()->default(NULL); //0. draft, 1.need_approval , 2. terkirim, 3.terbaca 9.cancel
            $table->integer('privacy_type')->nullable()->default(NULL); // 1. sangat segera 2.segera 3.biasa 4.penting 5.rahasia
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
        Schema::dropIfExists('mail');
    }
}
