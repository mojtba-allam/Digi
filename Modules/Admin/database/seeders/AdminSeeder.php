<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Admin\app\Models\Admin;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Admin::factory()->count(10)->create();
    }
}

