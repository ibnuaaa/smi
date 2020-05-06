<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMailApprovalTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mail_approval', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('mail_id');
            $table->integer('type'); //1.checker, 2.signer
            $table->integer('order_id');
            $table->integer('position_id');
            $table->integer('user_id');
            $table->text('notes')->nullable()->default(NULL);
            $table->integer('status'); // 0.Pending. 1.receive 2.read, 3.approve, 4.reject
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
        Schema::dropIfExists('mail_approval');
    }
}
