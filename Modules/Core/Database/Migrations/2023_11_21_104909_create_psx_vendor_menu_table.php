<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vendor_menus', function (Blueprint $table) {
            $table->id();
            $table->string('module_name');
            $table->string('module_desc');
            $table->string('module_lang_key');
            $table->foreignId('icon_id');
            $table->tinyInteger('is_show_on_menu');
            $table->tinyInteger('ordering');
            $table->foreignId('core_sub_menu_group_id');
            $table->foreignId('module_id')->nullable();
            $table->timestamp('added_date');
            $table->foreignId('added_user_id');
            $table->timestamp('updated_date')->nullable();
            $table->foreignId('updated_user_id')->nullable();
            $table->smallInteger('updated_flag')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vendor_menus');
    }
};
