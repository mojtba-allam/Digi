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
        $product = \Modules\Product\app\Models\Product::inRandomOrder()->first();
        $variant = ProductVariant::inRandomOrder()->first();
        $quantity = $this->faker->numberBetween(1, 5);
        $price = $product ? $product->price : $this->faker->randomFloat(2, 10, 500);
        $total = $price * $quantity;
        
        return [
            'order_id' => Order::inRandomOrder()->first()->id,
            'product_id' => $product->id,
            'product_variant_id' => $variant?->id,
            'quantity' => $quantity,
            'price' => $price,
            'total' => $total,
            'product_name' => $product->name,
            'product_sku' => $product->sku ?? null,
            'product_options' => null,
        ];
    }
}

