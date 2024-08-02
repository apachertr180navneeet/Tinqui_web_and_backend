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
        Schema::create('bid_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('buyer_id');
            $table->unsignedBigInteger('seller_id');
            $table->double('bid_price',10,2)->default(0.00);  
            $table->double('product_price',10,2)->default(0.00); 
            $table->unsignedBigInteger('product_id'); 
            $table->string('product_title');
            $table->enum('bid_status', ['pending','processing', 'accepted','declined', 'item_shipped','item_received','item_delivered','completed','refunded','cancelled'])->default('pending');
            $table->string('bid_commission')->default(0.08);
            $table->double('amount_paid',10,2)->default(0.00);
            $table->timestamps();

            $table->foreign('buyer_id')
              ->references('id')->on('users')->onDelete('cascade');
            $table->foreign('seller_id')
              ->references('id')->on('users')->onDelete('cascade');
            $table->foreign('product_id')
              ->references('id')->on('items')->onDelete('cascade');
              

        });
    }

    /**
     * Reverse the migrations. 
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bid_details');
    }
};
