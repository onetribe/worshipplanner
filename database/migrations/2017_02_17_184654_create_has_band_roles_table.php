<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHasBandRolesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('has_band_roles', function (Blueprint $table) {
            $table->unsignedInteger('band_role_id');
            $table->unsignedInteger('has_band_role_id');
            $table->string('has_band_role_type');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('has_band_roles');
    }
}
