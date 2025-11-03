<?php

namespace Modules\Authorization\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Authorization\app\Models\TemporaryPermission;

class TemporaryPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $admins = \Modules\Admin\app\Models\Admin::all();
        $roles = \Modules\Authorization\app\Models\Role::all();
        $permissions = \Modules\Authorization\app\Models\Permission::all();
        
        if ($admins->isEmpty() || $roles->isEmpty() || $permissions->isEmpty()) {
            return;
        }
        
        foreach (range(1, 10) as $i) {
            TemporaryPermission::create([
                'admin_id' => $admins->random()->id,
                'role_id' => $roles->random()->id,
                'permission_id' => $permissions->random()->id,
                'granted_at' => now(),
                'expires_at' => now()->addDays(rand(7, 30)),
                'condition' => fake()->sentence(),
            ]);
        }
    }
}
