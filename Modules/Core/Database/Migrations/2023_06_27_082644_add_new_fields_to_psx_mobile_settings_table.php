<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasColumn('mobile_settings', 'show_apple_login')) {
            Schema::table('mobile_settings', function (Blueprint $table) {
                $table->boolean('show_apple_login')->nullable()->after('show_google_login');
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('mobile_settings', function (Blueprint $table) {
            $table->dropColumn('show_apple_login');
        });
    }
};

