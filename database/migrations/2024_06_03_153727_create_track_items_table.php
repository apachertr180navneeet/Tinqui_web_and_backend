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
        Schema::create('track_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('bid_id');
            $table->enum('item_status', ['pending','processing', 'accepted','declined', 'item_shipped','item_received','item_delivered','completed','refunded','cancelled']);
            $table->unsignedBigInteger('updated_by_id');
            $table->string('updated_by');
            $table->date('update_date');
            $table->string('status_notes')->nullable();
            $table->timestamps();

            $table->foreign('updated_by_id')
              ->references('id')->on('users')->onDelete('cascade');
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
        Schema::dropIfExists('track_items');
    }
};
