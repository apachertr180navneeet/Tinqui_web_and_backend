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

        Schema::table('bid_details', function (Blueprint $table) {

            $table->enum('disputed_bid', ['yes','no'])->default('no')->after('amount_paid')->nullable();
            $table->enum('dispute_type', ['','refund','exchange'])->default('')->after('disputed_bid')->nullable();
            $table->string('dispute_reason')->after('dispute_type')->nullable();
            $table->enum('dispute_status', ['','received','in_process','rejected','resolved'])->default('')->after('dispute_reason')->nullable();
            $table->string('dispute_status_notes')->after('dispute_status')->nullable();
            $table->json('dispute_images')->after('dispute_status_notes')->nullable();
            $table->timestamp('update_date_time')->nullable();

        });

    }



    /**

     * Reverse the migrations.

     *

     * @return void

     */

    public function down()

    {

        Schema::table('bid_details', function (Blueprint $table) {

             $table->dropColumn(['disputed_bid']);
             $table->dropColumn(['dispute_type']);
             $table->dropColumn(['dispute_reason']);
             $table->dropColumn(['dispute_status']);
             $table->dropColumn(['dispute_status_notes']);

        });

    }

};

