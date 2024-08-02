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
            // Check if the columns do not exist before adding them
            if (!Schema::hasColumn('frontend_settings', 'frontend_meta_title')) {
                $table->string('frontend_meta_title')->after('copyright');
            }

            if (!Schema::hasColumn('frontend_settings', 'frontend_meta_description')) {
                $table->longText('frontend_meta_description')->after('frontend_meta_title');
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
            // Drop columns if they exist
            if (Schema::hasColumn('frontend_settings', 'frontend_meta_title')) {
                $table->dropColumn('frontend_meta_title');
            }

            if (Schema::hasColumn('frontend_settings', 'frontend_meta_description')) {
                $table->dropColumn('frontend_meta_description');
            }
        });
    }
};

