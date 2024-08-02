<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Modules\Core\Entities\CoreMenu;
use Modules\Core\Entities\Module;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $coreMenu = CoreMenu::where('module_id', 17)->where('id', 17)->first();

        if ($coreMenu) {
            $coreMenu->delete();
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('', function (Blueprint $table) {
            // Add code to reverse the migration if necessary
        });
    }
};

