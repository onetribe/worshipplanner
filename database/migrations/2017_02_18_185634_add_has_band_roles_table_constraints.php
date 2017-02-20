<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddHasBandRolesTableConstraints extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('has_band_roles', function (Blueprint $table) {
            $table->foreign('band_role_id')
                ->references('id')
                ->on('band_roles')
                ->onDelete('cascade');

            $table->unique(['band_role_id', 'has_band_role_id', 'has_band_role_type'], 'has_band_roles_unique');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('has_band_roles', function (Blueprint $table) {
            $table->dropForeign('has_band_roles_band_role_id_foreign');
            $table->dropUnique('has_band_roles_unique');
        });
    }
}
