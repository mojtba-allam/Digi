<?php

namespace Modules\Order\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Order\app\Models\Order;
use Modules\Order\app\Models\OrderStatus;

class OrderStatusFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     */
    protected $model = OrderStatus::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'order_id' => Order::factory(),
            'status' => $this->faker->randomElement(['pending', 'processing', 'shipped', 'delivered', 'cancelled']),
        ];
    }
}

