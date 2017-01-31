<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSetSongsTableConstraints extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('set_songs', function (Blueprint $table) {
            
            $table->foreign('song_id')
                ->references('id')
                ->on('songs')
                ->onDelete('cascade');

            $table->foreign('set_id')
                ->references('id')
                ->on('sets')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('set_songs', function (Blueprint $table) {
            $table->dropForeign('set_songs_song_id_foreign');
            $table->dropForeign('set_songs_set_id_foreign');
        });
    }
}
