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
            ['name' => 'admin', 'display_name' => 'Administrator', 'description' => 'Full system access'],
            ['name' => 'vendor', 'display_name' => 'Vendor', 'description' => 'Vendor access'],
            ['name' => 'customer', 'display_name' => 'Customer', 'description' => 'Customer access'],
            ['name' => 'manager', 'display_name' => 'Manager', 'description' => 'Manager access'],
            ['name' => 'support', 'display_name' => 'Support', 'description' => 'Support access']
        ];

        foreach ($roles as $role) {
            Role::create($role);
        }
    }
}
