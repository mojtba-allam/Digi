<?php

namespace Modules\Authorization\Database\Seeders;

use Illuminate\Database\Seeder;
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

        if ($roles->isEmpty() || $permissions->isEmpty()) {
            $this->command->warn('No roles or permissions found, skipping role-permission assignment');
            return;
        }

        // Prepare bulk insert data
        $rolePermissions = [];
        $now = now();

        foreach ($roles as $role) {
            // For defined roles, assign specific permissions instead of random ones
            if ($role->name === 'admin') {
                // Admin gets all permissions
                $assignedPermissions = $permissions;
            } elseif ($role->name === 'vendor') {
                // Vendors get a subset of permissions
                $assignedPermissions = $permissions->where('name', 'like', 'product%')
                    ->merge($permissions->where('name', 'like', 'order%'));
            } else {
                // Other roles get 1-5 random permissions instead of potentially many
                $assignedPermissions = $permissions->random(min(5, $permissions->count()));
            }

            foreach ($assignedPermissions as $permission) {
                $rolePermissions[] = [
                    'role_id' => $role->id,
                    'permission_id' => $permission->id,
                    'created_at' => $now,
                    'updated_at' => $now
                ];
            }
        }

        // Perform single bulk insert instead of many individual inserts
        if (count($rolePermissions) > 0) {
            // Insert in chunks to avoid memory issues
            foreach (array_chunk($rolePermissions, 100) as $chunk) {
                \Illuminate\Support\Facades\DB::table('role_permissions')->insert($chunk);
            }
        }
    }
}