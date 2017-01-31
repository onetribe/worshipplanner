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
            $table->string('alternative_title')->nullable();
            $table->text('lyrics');
            $table->string('copyrights')->nullable();
            $table->unsignedInteger('ccli')->nullable();
            $table->string('default_key', 4)->nullable();
            $table->unsignedSmallInteger('default_tempo')->nullable();
            $table->string('youtube', 255)->nullable();
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
