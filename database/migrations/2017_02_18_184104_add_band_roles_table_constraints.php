<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddBandRolesTableConstraints extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('band_roles', function (Blueprint $table) {
            $table->foreign('team_id')
                ->references('id')
                ->on('teams')
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
        Schema::table('band_roles', function (Blueprint $table) {
            $table->dropForeign('band_roles_team_id_foreign');
        });
    }
}
