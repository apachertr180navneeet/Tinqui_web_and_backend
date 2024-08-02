<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users_stripe_connect_details', function (Blueprint $table) {
            $table->tinyInteger('transfers_enabled')->default(0)->after('payouts_enabled');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users_stripe_connect_details', function (Blueprint $table) {
             $table->dropColumn(['transfers_enabled']);
        });
    }
};
