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
            // Check if the column doesn't exist before adding it
            if (!Schema::hasColumn('frontend_settings', 'color_changed_code')) {
                $table->string('color_changed_code')->default('101')->after('price_format');
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
            // Drop the column if it exists
            if (Schema::hasColumn('frontend_settings', 'color_changed_code')) {
                $table->dropColumn('color_changed_code');
            }
        });
    }
};
