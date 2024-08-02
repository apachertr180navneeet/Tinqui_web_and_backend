<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

// Update this import statement according to your actual model path
use Modules\Core\Entities\Role;
use App\Models\User;
use Modules\Core\Entities\RolePermission;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Check if the column already exists
        if (!Schema::hasColumn('roles', 'can_access_admin_panel')) {
            Schema::table('roles', function (Blueprint $table) {
                $table->tinyInteger('can_access_admin_panel')->default(0);
            });
        }

        // Update role with ID 1
        $role = Role::find(1);
        if ($role) {
            $role->can_access_admin_panel = 1;
            $role->save(); // Using save() instead of update() is generally preferred for single attribute updates
        } else {
            // Handle the case where the role is not found
            \Log::warning('Role with ID 1 not found');
        }

        // Update user with ID 1
        $user = User::find(1);
        if ($user) {
            $user->role_id = 1;
            $user->save(); // Using save() instead of update() is generally preferred for single attribute updates
        } else {
            // Handle the case where the user is not found
            \Log::warning('User with ID 1 not found');
        }

        // Check if the table exists before performing operations
        if (Schema::hasTable('role_permissions')) {
            // Delete role permissions with role_id 2
            $rolePermissions = RolePermission::where('role_id', 2)->get();
            $rolePermissionIds = $rolePermissions->pluck('id');
            RolePermission::destroy($rolePermissionIds);
        } else {
            \Log::warning('Table role_permissions does not exist');
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Remove the column in the down method
        Schema::table('roles', function (Blueprint $table) {
            $table->dropColumn('can_access_admin_panel');
        });
    }
};
