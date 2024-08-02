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
        Schema::create('bid_stripe_transactions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('bid_details_id');
            $table->string('txn_id')->nullable();
            $table->enum('payment_type', ['payment_indent', 'charge']);
            $table->string('payment_status');
            $table->string('txn_date');
            $table->timestamps();

            // Define the foreign key constraint after the column definitions
            // $table->foreign('bid_details_id')
            //       ->references('id')->on('bid_details')
            //       ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('bid_stripe_transactions', function (Blueprint $table) {
            // Drop foreign key first before dropping the table
            $table->dropForeign(['bid_details_id']);
        });

        Schema::dropIfExists('bid_stripe_transactions');
    }
};

