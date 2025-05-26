<?php

namespace Modules\Authorization\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Authorization\App\Models\Role;
use Modules\Authorization\App\Models\Permission;
use Illuminate\Support\Facades\DB;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        $roles = Role::all();
        $permissions = Permission::all();
        $rolePermissions = [];

        foreach ($roles as $role) {
            if ($role->name === 'admin') {
                $assignedPermissions = $permissions;
            } elseif ($role->name === 'vendor') {
                $assignedPermissions = $permissions->filter(function($perm) {
                    return str_starts_with($perm->name, 'product') || str_starts_with($perm->name, 'order');
                });
            } else {
                $count = min(5, $permissions->count());
                $assignedPermissions = $permissions->random($count);
            }

            foreach ($assignedPermissions as $permission) {
                $rolePermissions[] = [
                    'role_id' => $role->id,
                    'permission_id' => $permission->id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
        }

        if (!empty($rolePermissions)) {
            DB::table('role_permissions')->insert($rolePermissions);
        }
    }
}
