<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSongsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('songs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('team_id');
            $table->string('title');
            $table->string('alternative_title');
            $table->text('lyrics');
            $table->string('copyrights');
            $table->unsignedInteger('ccli')->nullable();
            $table->string('default_key', 4);
            $table->unsignedSmallInteger('default_tempo')->nullable();
            $table->string('youtube', 255);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('songs');
    }
}
