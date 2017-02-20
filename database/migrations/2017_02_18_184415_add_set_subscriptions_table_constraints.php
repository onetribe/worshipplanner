<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSetSubscriptionsTableConstraints extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('set_subscriptions', function (Blueprint $table) {

            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');

            $table->foreign('set_id')
                ->references('id')
                ->on('sets')
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
        Schema::table('set_subscriptions', function (Blueprint $table) {
            $table->dropForeign('set_subscriptions_user_id_foreign');
            $table->dropForeign('set_subscriptions_set_id_foreign');
        });
    }
}
