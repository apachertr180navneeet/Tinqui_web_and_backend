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
        Schema::create('wallet_log', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('users_wallet_id')->index();
            $table->double('amount_added',10,2)->default(0.00)->nullable();  
            $table->double('amount_deducted',10,2)->default(0.00)->nullable(); 
            $table->double('onhold_amount',10,2)->default(0.00)->nullable(); 
            $table->string('currency');
            $table->double('old_balance',10,2);
            $table->string('add_date');
            $table->string('payment_type');
            $table->timestamps();

            $table->foreign('users_wallet_id')
              ->references('id')->on('users_wallet')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('wallet_log');
    }
};
