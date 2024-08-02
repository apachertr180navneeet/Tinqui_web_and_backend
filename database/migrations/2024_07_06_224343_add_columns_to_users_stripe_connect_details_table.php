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
            $table->tinyInteger('charges_enabled')->default(0)->after('onboarding_status');
            $table->tinyInteger('payouts_enabled')->default(0)->after('charges_enabled')->comment('transfer money to bank or external source');
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
            $table->dropColumn(['charges_enabled','payouts_enabled']);
        });
    }
};
