<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSongsTableConstraints extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('songs', function (Blueprint $table) {
            $table->foreign('team_id')
                ->references('id')
                ->on('teams')
                ->onDelete('cascade');

            $table->foreign('creator_id')
                ->references('id')
                ->on('users')
                ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('songs', function (Blueprint $table) {
            $table->dropForeign('songs_team_id_foreign');
            $table->dropForeign('songs_creator_id_foreign');
        });
    }
}
