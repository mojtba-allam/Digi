<?php

namespace Modules\Cart\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Cart\app\Models\Cart;
use Modules\PromotionAndCoupon\app\Models\Coupon;

class CartCouponFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     */

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'cart_id' => Cart::factory(),
            'coupon_id' => Coupon::factory(),
        ];
    }
}

