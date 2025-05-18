<?php

namespace Modules\CommissionAndPayout\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Business\app\Models\Vendor;
use Modules\CommissionAndPayout\app\Models\Commission;
use Modules\Order\app\Models\Order;

class CommissionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     */
    protected $model = Commission::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'vendor_id' => Vendor::factory(),
            'order_id' => Order::factory(),
            'rate' => $this->faker->randomFloat(2, 0, 100),
        ];
    }
}

