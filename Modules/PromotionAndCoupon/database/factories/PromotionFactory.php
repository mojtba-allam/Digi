<?php

namespace Modules\PromotionAndCoupon\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\PromotionAndCoupon\app\Models\Promotion;

class PromotionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     */
    protected $model = Promotion::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        $startDate = $this->faker->dateTimeBetween('-1 month', 'now');
        $endDate = $this->faker->dateTimeBetween($startDate, '+1 month');

        return [
            'name' => $this->faker->words(2, true),
            'start_date' => $startDate->format('Y-m-d'),
            'end_date' => $endDate->format('Y-m-d'),
        ];
    }
}

