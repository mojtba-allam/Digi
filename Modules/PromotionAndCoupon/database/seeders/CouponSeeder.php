<?php

namespace Modules\PromotionAndCoupon\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\PromotionAndCoupon\app\Models\Coupon;

class CouponSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Coupon::factory()->count(20)->create();
    }
}
