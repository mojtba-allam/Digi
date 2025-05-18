<?php

namespace Modules\PromotionAndCoupon\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\PromotionAndCoupon\app\Models\DiscountRule;
use Modules\PromotionAndCoupon\app\Models\Promotion;

class DiscountRuleFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     */
    protected $model = DiscountRule::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        $conditionTypes = ['min_quantity', 'min_amount', 'category', 'user_group', 'product_id', 'weekday', 'time_range'];
        $conditionType = $this->faker->randomElement($conditionTypes);

        $value = match ($conditionType) {
            'min_quantity' => (string) $this->faker->numberBetween(1, 10),
            'min_amount'   => (string) $this->faker->randomFloat(2, 10, 500),
            'category'     => $this->faker->randomElement(['electronics', 'fashion', 'books']),
            'user_group'   => $this->faker->randomElement(['vip', 'regular', 'guest']),
            'product_id'   => (string) $this->faker->numberBetween(1, 100),
            'weekday'      => $this->faker->dayOfWeek(),
            'time_range'   => '08:00-12:00',
            default        => $this->faker->word(),
        };

        return [
            'promotion_id'   => Promotion::factory(),
            'condition_type' => $conditionType,
            'value'          => $value,
        ];
    }
}

