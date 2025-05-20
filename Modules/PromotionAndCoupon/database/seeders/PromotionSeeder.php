<?php

namespace Modules\PromotionAndCoupon\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\PromotionAndCoupon\app\Models\Promotion;

class PromotionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Promotion::factory()->count(10)->create();
    }
}
