<?php

namespace Modules\CommissionAndPayout\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\CommissionAndPayout\app\Models\Commission;

class CommissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Commission::factory()->count(20)->create();
    }
}
