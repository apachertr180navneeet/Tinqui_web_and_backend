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
        Schema::create('bid_notis', function (Blueprint $table) {
            $table->id();
             $table->unsignedBigInteger('bid_id');
            $table->string('type');
            $table->string('bid_noti_message');
            $table->string('bid_flag')->nullable();
            $table->boolean('is_read')->default(0);
            $table->timestamp('added_date');
            $table->timestamp('updated_date')->nullable();
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
        Schema::dropIfExists('bid_notis');
    }
};
