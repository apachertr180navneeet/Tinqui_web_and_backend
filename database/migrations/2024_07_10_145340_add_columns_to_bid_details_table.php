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
        Schema::table('bid_details', function (Blueprint $table) {
            $table->enum('dispute_refund', ['yes','no'])->default('no')->after('dispute_images')->nullable();

        });
    }

    /** 
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('bid_details', function (Blueprint $table) {
            $table->dropColumn(['dispute_refund']);
        });
    }
};
