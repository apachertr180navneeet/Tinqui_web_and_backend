<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Modules\Core\Entities\BackendSetting;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('backend_settings', function (Blueprint $table) {

        });

        $backendSetting = BackendSetting::first();
        if($backendSetting){
            $backendSetting->backend_version_no = "1.2.2";
            $backendSetting->update();
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('backend_settings', function (Blueprint $table) {

        });
    }
};