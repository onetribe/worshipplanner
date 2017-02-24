<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddUniqueBandUserToBandSubscriptions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('band_subscriptions', function (Blueprint $table) {
            $table->unique(['band_id', 'user_id'], 'band_subscriptions_user_band_unique');
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
            $table->dropUnique('band_subscriptions_user_band_unique');
        });
    }
}
