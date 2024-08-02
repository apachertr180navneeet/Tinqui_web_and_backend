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
             $table->string('auction_period')->after('preferred_payment')->nullable();
            $table->string('product_creation_date')->after('auction_period')->comment('Unix timestamp in milliseconds');
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
        });
    }
};
