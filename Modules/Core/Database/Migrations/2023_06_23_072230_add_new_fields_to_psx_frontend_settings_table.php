<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('frontend_settings', function (Blueprint $table) {
            // Check if the column does not exist before adding it
            if (!Schema::hasColumn('frontend_settings', 'is_ads_on')) {
                $table->tinyInteger("is_ads_on")->default(0)->after('ad_slot');
            }

            // Check if the column does not exist before adding it
            if (!Schema::hasColumn('frontend_settings', 'firebase_config')) {
                $table->longText('firebase_config')->nullable()->after('is_ads_on');
            }
        });
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('frontend_settings', function (Blueprint $table) {

        });
    }
};
