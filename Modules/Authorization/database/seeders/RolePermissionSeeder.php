<?php

namespace Modules\Authorization\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Modules\Authorization\App\Models\Role;
use Modules\Authorization\App\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = Role::all();
        $permissions = Permission::all();

        foreach ($roles as $role) {
            $assignedPermissions = $permissions->random(rand(1, $permissions->count()));

            foreach ($assignedPermissions as $permission) {
                DB::table('role_permissions')->insert([
                    'role_id' => $role->id,
                    'permission_id' => $permission->id,
                ]);
            }
        }
    }
}
