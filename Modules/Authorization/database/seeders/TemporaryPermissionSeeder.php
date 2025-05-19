<?php

namespace Modules\Authorization\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Authorization\App\Models\TemporaryPermission;

class TemporaryPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        TemporaryPermission::factory()->count(10)->create();
    }
}
