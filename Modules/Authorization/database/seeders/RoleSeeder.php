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
            ['name' => 'admin'],
            ['name' => 'vendor'],
            ['name' => 'customer'],
            ['name' => 'manager'],
            ['name' => 'support']
        ];

        foreach ($roles as $role) {
            Role::create($role);
        }
    }
}