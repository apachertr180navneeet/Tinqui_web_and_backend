<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Carbon\Carbon;

return new class extends Migration
{
    public function up()
    {
        // Create 'roles' table if it doesn't exist and insert the required role
        if (!Schema::hasTable('roles')) {
            Schema::create('roles', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->timestamps();
            });
        }

        // Ensure role with ID 1 exists
        $role = DB::table('roles')->where('id', 1)->first();
        if (empty($role)) {
            DB::table('roles')->insert([
                'id' => 1,
                'name' => 'Admin',
                'updated_date' => Carbon::now(),
            ]);
        }

        // Create 'modules' table if it doesn't exist
        if (!Schema::hasTable('modules')) {
            Schema::create('modules', function (Blueprint $table) {
                $table->id();
                $table->string('title');
                $table->string('lang_key');
                $table->timestamps();
            });
        }

        // Insert modules if not exist
        $fe_lang_module_id = DB::table('modules')->insertGetId([
            'title' => 'fe_language',
            'lang_key' => 'fe_language_module',
            'updated_date' => Carbon::now(),
        ]);

        DB::table('modules')->insert([
            'title' => 'fe_language_string',
            'lang_key' => 'fe_language_string_module',
            'updated_date' => Carbon::now(),
        ]);

        // Create 'role_permissions' table if it doesn't exist
        if (!Schema::hasTable('role_permissions')) {
            Schema::create('role_permissions', function (Blueprint $table) {
                $table->id();
                $table->foreignId('role_id')->constrained()->onDelete('cascade');
                $table->foreignId('module_id')->constrained();
                $table->integer('permission_id'); // Assuming permission_id should be an integer
                $table->timestamp('added_date');
                $table->foreignId('added_user_id');
                $table->timestamp('updated_date')->nullable();
                $table->foreignId('updated_user_id')->nullable();
            });
        }

        // Insert permissions
        DB::table('role_permissions')->insert([
            [
                'role_id' => 1,
                'module_id' => $fe_lang_module_id,
                'permission_id' => 1, // Adjust according to your requirement
                'added_date' => Carbon::now(),
                'added_user_id' => 1,
                'updated_date' => Carbon::now()
            ],
            [
                'role_id' => 1,
                'module_id' => $fe_lang_module_id + 1, // Assuming next module ID
                'permission_id' => 2, // Adjust according to your requirement
                'added_date' => Carbon::now(),
                'added_user_id' => 1,
                'updated_date' => Carbon::now()
            ]
        ]);
    }

    public function down()
    {
        // Drop the role_permissions table first to remove the foreign key constraints
        Schema::dropIfExists('role_permissions');

        // Drop the modules table after role_permissions has been dropped
        Schema::dropIfExists('modules');

        // Finally, drop the roles table
        Schema::dropIfExists('roles');
    }

};

