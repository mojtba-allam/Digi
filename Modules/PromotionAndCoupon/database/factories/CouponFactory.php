<?php

namespace Modules\PromotionAndCoupon\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\PromotionAndCoupon\app\Models\Coupon;

class CouponFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     */
    protected $model = Coupon::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'code' => strtoupper($this->faker->bothify('SAVE##??')),
            'discount' => $this->faker->randomFloat(2, 5, 50),
            'usage_limit' => $this->faker->numberBetween(1, 100),
        ];
    }
}

