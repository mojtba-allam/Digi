<?php

namespace Modules\Cart\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Modules\Cart\app\Models\Cart;
use Modules\PromotionAndCoupon\app\Models\Coupon;

class CartCouponSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $carts = Cart::all();

        foreach ($carts as $cart) {
            DB::table('cart_coupons')->insert([
                'cart_id' => $cart->id,
                'coupon_id' => Coupon::factory()->create()->id,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
