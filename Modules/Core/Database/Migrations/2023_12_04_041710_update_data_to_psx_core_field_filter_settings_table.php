<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Modules\Core\Entities\CoreFieldFilterSetting;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Update setting for 'is_show_email'
        $coreFieldFilterSettings = CoreFieldFilterSetting::where(CoreFieldFilterSetting::fieldName, 'is_show_email')->first();
        if ($coreFieldFilterSettings) {
            $coreFieldFilterSettings->enable = 1;
            $coreFieldFilterSettings->save();
        }

        // Update setting for 'is_show_phone'
        $coreFieldFilterSettings = CoreFieldFilterSetting::where(CoreFieldFilterSetting::fieldName, 'is_show_phone')->first();
        if ($coreFieldFilterSettings) {
            $coreFieldFilterSettings->enable = 1;
            $coreFieldFilterSettings->save();
        }
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('core_field_filter_settings', function (Blueprint $table) {

        });
    }
};
