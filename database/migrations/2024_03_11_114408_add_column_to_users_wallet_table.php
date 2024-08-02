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

        Schema::table('users_wallet', function (Blueprint $table) {
            $table->double('wallet_balance', 10, 2)->change();
            $table->double('amount_on_hold',10,2)->after('wallet_balance')->default(0.00)->nullable();

        });

    }



    /**

     * Reverse the migrations.

     *

     * @return void

     */

    public function down()

    {

        Schema::table('users_wallet', function (Blueprint $table) {

            $table->dropColumn(['amount_on_hold']);

        });

    }

};

