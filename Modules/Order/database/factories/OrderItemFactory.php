<?php

namespace Modules\Order\database\factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Order\app\Models\Order;
use Modules\Order\app\Models\OrderItem;
use Modules\Product\app\Models\ProductVariant;

class OrderItemFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     */
    protected $model = OrderItem::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'product_variant_id' => ProductVariant::factory(),
            'quantity' => $this->faker->numberBetween(1, 5),
            'price' => $this->faker->randomFloat(2, 10, 500),
            'order_id' => Order::factory(),
        ];
    }
}

