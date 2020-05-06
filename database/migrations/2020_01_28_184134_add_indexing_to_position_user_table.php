<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIndexingToPositionUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('positions_from_api', function (Blueprint $table) {
            $table->index('kuntp', 'idx_kuntp');
            $table->index('kunkom', 'idx_kunkom');
            $table->index('kununit', 'idx_kununit');
            $table->index('kunsk', 'idx_kunsk');
            $table->index('kunssk', 'idx_kunssk');
            $table->index('kunker', 'idx_kunker');
            $table->index('parent_id', 'idx_parent_id');
            $table->index('kunker_parent', 'idx_kunker_parent');
        });

        Schema::table('users_from_api', function (Blueprint $table) {
            $table->index('kuntp', 'idx_kuntp');
            $table->index('kunkom', 'idx_kunkom');
            $table->index('kununit', 'idx_kununit');
            $table->index('kunsk', 'idx_kunsk');
            $table->index('kunssk', 'idx_kunssk');
            $table->index('kunker', 'idx_kunker');

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
