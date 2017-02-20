<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sets', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('team_id');
            $table->string('title');
            $table->text('description');
            $table->dateTime('when');
            $table->unsignedInteger('service_id')->nullable();
            $table->unsignedInteger('creator_id')->nullable();
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
        Schema::dropIfExists('sets');
    }
}
