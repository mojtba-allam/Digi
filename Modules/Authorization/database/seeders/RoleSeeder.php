<?php

namespace Modules\Authorization\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Authorization\app\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $roles = [
            ['role' => 'admin'],
            ['role' => 'vendor'],
            ['role' => 'customer'],
            ['role' => 'manager'],
            ['role' => 'support']
        ];

        foreach ($roles as $role) {
            Role::create($role);
        }
    }
}
