<?php

namespace Modules\PromotionAndCoupon\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\PromotionAndCoupon\app\Models\DiscountRule;

class DiscountRuleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DiscountRule::factory()->count(30)->create();
    }
}
