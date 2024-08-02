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
        Schema::create('bid_notifications', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('bid_id');
            $table->tinyInteger('auto_release_48_hours_item_received')->default(0)->nullable();
            $table->tinyInteger('reminder_after_7_days_item_shipped')->default(0)->nullable();
            $table->tinyInteger('autocomplete_bid_after_10_days')->default(0)->nullable(); 
            $table->tinyInteger('auto_cancel_after_48_hours')->default(0)->nullable();
            $table->timestamps();

            $table->foreign('bid_id')
              ->references('id')->on('bid_details')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bid_notifications');
    }
};
