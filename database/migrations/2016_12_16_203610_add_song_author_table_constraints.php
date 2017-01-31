<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSongAuthorTableConstraints extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('song_author', function (Blueprint $table) {
            $table->foreign('song_id')
                ->references('id')
                ->on('songs')
                ->onDelete('cascade');

            $table->foreign('author_id')
                ->references('id')
                ->on('authors')
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
        Schema::table('song_author', function (Blueprint $table) {
            $table->dropForeign('song_author_author_id_foreign');
            $table->dropForeign('song_author_song_id_foreign');
        });
    }
}
