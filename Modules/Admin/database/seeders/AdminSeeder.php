<?php

namespace Modules\Admin\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Admin\app\Models\Admin;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $adminRole = \Modules\Authorization\app\Models\Role::where('name', 'admin')->first();
        
        if ($adminRole) {
            Admin::factory()->count(10)->create([
                'role_id' => $adminRole->id,
            ]);
        }
    }
}

