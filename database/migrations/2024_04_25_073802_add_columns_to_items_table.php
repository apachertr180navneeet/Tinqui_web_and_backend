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
         Schema::table('items', function (Blueprint $table) {
            $table->tinyInteger('is_warranty_item')->default(0)->after('auction_price')->nullable();
            $table->enum('preferred_payment', ['wallet', 'bank_transfer'])->default('wallet')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
         Schema::table('items', function (Blueprint $table) {
             $table->dropColumn(['is_warranty_item']);
               $table->dropColumn(['preferred_payment']);
        });
    }
};
