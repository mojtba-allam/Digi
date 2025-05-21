<?php

namespace Modules\PromotionAndCoupon\database\seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {


        $this->call([
            CouponSeeder::class,
            PromotionSeeder::class,
            DiscountRuleSeeder::class,
        ]);


    }
}
