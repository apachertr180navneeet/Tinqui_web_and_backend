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
            $table->tinyInteger('is_auction_item')->default(0)->after('phone')->nullable();
            $table->json('auction_ids')->after('is_auction_item')->nullable();
            $table->double('auction_price',10,2)->after('auction_ids')->nullable();
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
             $table->dropColumn(['is_auction_item']);
               $table->dropColumn(['auction_ids']);
                 $table->dropColumn(['auction_price']);
        });
    }
};
