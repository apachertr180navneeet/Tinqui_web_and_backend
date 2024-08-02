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
        // Check if the table exists before altering it
        if (Schema::hasTable('vendor_modules')) {
            Schema::table('vendor_modules', function (Blueprint $table) {
                if (!Schema::hasColumn('vendor_modules', 'id')) {
                    $table->string('id', 30)->primary();
                }
            });
        }

        // Check if the table exists before altering it
        if (Schema::hasTable('vendor_menus')) {
            Schema::table('vendor_menus', function (Blueprint $table) {
                $table->string('module_id', 30)->change();
            });
        }

        // Check if the table exists before altering it
        if (Schema::hasTable('vendor_sub_menus')) {
            Schema::table('vendor_sub_menus', function (Blueprint $table) {
                $table->string('module_id', 30)->change();
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
        // Rollback changes in reverse order
        if (Schema::hasTable('vendor_modules')) {
            Schema::table('vendor_modules', function (Blueprint $table) {
                $table->dropPrimary(['id']);
                $table->dropColumn('id'); // or you might want to change column type if reverting
            });
        }

        if (Schema::hasTable('vendor_menus')) {
            Schema::table('vendor_menus', function (Blueprint $table) {
                $table->string('module_id', 255)->change(); // revert to original length if needed
            });
        }

        if (Schema::hasTable('vendor_sub_menus')) {
            Schema::table('vendor_sub_menus', function (Blueprint $table) {
                $table->string('module_id', 255)->change(); // revert to original length if needed
            });
        }
    }
};
