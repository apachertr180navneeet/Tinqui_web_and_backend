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
        Schema::create('users_wallet', function (Blueprint $table) {
           $table->id();
            $table->unsignedBigInteger('user_id')->index();
             $table->integer('wallet_balance');
              $table->string('currency');
              $table->string('recharge_date')->nullable();
             
            $table->timestamps();

             $table->foreign('user_id')
              ->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users_wallet');
    }
};
