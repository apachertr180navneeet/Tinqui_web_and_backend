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
        Schema::create('dispute_refund_tracking', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('bid_id');
              $table->string('refund_id')->nullable();
            $table->string('refund_status');
            $table->date('update_date');
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
        Schema::dropIfExists('dispute_refund_tracking');
    }
};
