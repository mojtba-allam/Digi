<?php

namespace Modules\CommissionAndPayout\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\CommissionAndPayout\app\Models\Settlement;

class SettlementFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     */
    protected $model = Settlement::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'month' => $this->faker->monthName,
            'amount' => $this->faker->randomFloat(2, 10, 10000),
            'status' => $this->faker->randomElement(['pending', 'paid', 'failed']),
        ];
    }
}

