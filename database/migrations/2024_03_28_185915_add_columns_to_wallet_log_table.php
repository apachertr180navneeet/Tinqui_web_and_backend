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
        Schema::table('wallet_log', function (Blueprint $table) {
             $table->dropColumn('add_date');
             $table->string('payment_status')->after('payment_type')->nullable();
             $table->string('txn_id')->after('payment_status')->nullable();
              $table->string('paid_at')->after('txn_id')->nullable();
        }); 
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('wallet_log', function (Blueprint $table) {

              $table->dropColumn(['payment_status','txn_id','paid_at']);
    
        });
    }
};
