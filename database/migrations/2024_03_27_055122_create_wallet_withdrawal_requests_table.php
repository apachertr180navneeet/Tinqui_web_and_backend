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
        Schema::create('wallet_withdrawal_requests', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->double('withdraw_amount',10,2)->default(0.00);  
            $table->string('currency')->default('CHF');
            $table->string('bank_name')->nullable();
            $table->string('bank_code')->nullable();
            $table->string('branch_name')->nullable();
            $table->string('account_number')->nullable();
            $table->string('account_name')->nullable();  
            $table->string('address')->nullable();
            $table->string('state')->nullable();
            $table->string('city')->nullable();
            $table->string('postal_code')->nullable();
            $table->string('country')->nullable();
            $table->enum('withdraw_status', ['received', 'inprocess', 'accepted','declined'])->default('received');
            $table->datetime('request_date');
            $table->datetime('processing_date')->nullable();
            $table->string('decline_reason')->nullable();
             $table->string('notes')->nullable();
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
        Schema::dropIfExists('wallet_withdrawal_requests');
    }
};
