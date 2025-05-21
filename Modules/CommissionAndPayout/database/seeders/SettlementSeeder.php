<?php

namespace Modules\CommissionAndPayout\database\seeders;

use Illuminate\Database\Seeder;
use Modules\CommissionAndPayout\app\Models\Settlement;

class SettlementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Settlement::factory()->count(12)->create();
    }
}
