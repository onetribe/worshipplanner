<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddBandSubscriptionsTableConstraints extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('band_subscriptions', function (Blueprint $table) {
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');

            $table->foreign('band_id')
                ->references('id')
                ->on('bands')
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
        Schema::table('band_subscriptions', function (Blueprint $table) {
            $table->dropForeign('band_subscriptions_user_id_foreign');
            $table->dropForeign('band_subscriptions_band_id_foreign');
        });
    }
}
