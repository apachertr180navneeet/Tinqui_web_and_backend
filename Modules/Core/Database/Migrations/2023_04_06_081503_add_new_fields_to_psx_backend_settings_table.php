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
        Schema::table('backend_settings', function (Blueprint $table) {
            // Check if the 'opacity' column exists
            if (Schema::hasColumn('backend_settings', 'opacity')) {
                $table->tinyInteger('is_google_map')->nullable()->default(1)->after('opacity');
                $table->tinyInteger('is_open_street_map')->nullable()->default(0)->after('is_google_map');
            } else {
                // Add columns at the end if 'opacity' does not exist
                $table->tinyInteger('is_google_map')->nullable()->default(1);
                $table->tinyInteger('is_open_street_map')->nullable()->default(0);
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
        Schema::table('backend_settings', function (Blueprint $table) {
            // Drop columns if they exist
            if (Schema::hasColumn('backend_settings', 'is_google_map')) {
                $table->dropColumn('is_google_map');
            }
            if (Schema::hasColumn('backend_settings', 'is_open_street_map')) {
                $table->dropColumn('is_open_street_map');
            }
        });
    }
};

