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
            // Your schema modifications here, if any
        });

        // Find the first record or create a new one if none exists
        $backendSetting = BackendSetting::first();

        if ($backendSetting) {
            $backendSetting->backend_version_no = "1.0.4";
            $backendSetting->save(); // Use save() instead of update()
        } else {
            // Optionally, you can handle the case where no record is found
            // For example, create a new record:
            BackendSetting::create([
                'backend_version_no' => '1.0.4',
                // Include other required fields here
            ]);
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
            // Reverse any schema changes made in the up() method
        });
    }
};
