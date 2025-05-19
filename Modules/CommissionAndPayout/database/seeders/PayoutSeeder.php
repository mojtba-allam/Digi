<?php

namespace Modules\CommissionAndPayout\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\CommissionAndPayout\app\Models\Payout;

class PayoutSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Payout::factory()->count(20)->create();
    }
}
