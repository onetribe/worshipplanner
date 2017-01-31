<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSongTagsTableConstraints extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('song_tags', function (Blueprint $table) {
            
            $table->foreign('song_id')
                ->references('id')
                ->on('songs')
                ->onDelete('cascade');

            $table->foreign('tag_id')
                ->references('id')
                ->on('tags')
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
        Schema::table('song_tags', function (Blueprint $table) {
            $table->dropForeign('song_tags_song_id_foreign');
            $table->dropForeign('song_tags_tag_id_foreign');
        });
    }
}
