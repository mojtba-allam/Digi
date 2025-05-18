<?php

namespace Modules\CommissionAndPayout\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Business\app\Models\Vendor;
use Modules\CommissionAndPayout\app\Models\Payout;

class PayoutFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     */
    protected $model = Payout::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'amount' => $this->faker->randomFloat(2, 1, 1000),
            'status' => $this->faker->randomElement(['pending', 'completed', 'failed']),
            'vendor_id' => Vendor::factory(),
        ];
    }
}

