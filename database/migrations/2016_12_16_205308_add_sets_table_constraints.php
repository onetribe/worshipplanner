<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSetsTableConstraints extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sets', function (Blueprint $table) {
            
            $table->foreign('team_id')
                ->references('id')
                ->on('teams')
                ->onDelete('cascade');
                
            $table->foreign('service_id')
                ->references('id')
                ->on('services')
                ->onDelete('set null');
                
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
        Schema::table('sets', function (Blueprint $table) {
            $table->dropForeign('sets_team_id_foreign');
            $table->dropForeign('sets_service_id_foreign');
            $table->dropForeign('sets_creator_id_foreign');
        });
    }
}
